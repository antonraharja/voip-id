<?php

class PhoneNumberController extends \BaseController {

    /**
     * Instantiate a new DomainController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth');
        $this->beforeFilter('phone_number');

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        if(Request::segment(2)=='search'){
            $input = Session::get('search') && !Input::get('search_category') ? Session::get('search') : Input::only(array('search_category','search_keyword'));

            if($input['search_category']=='0'){
                return Redirect::to('phone_number');
            }

            $phone_number = PhoneNumber::where('user_id', Auth::user()->id)->where($input['search_category'], 'LIKE', '%'.$input['search_keyword'].'%')->get();

            Session::set('search', $input);
        }else{
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $phone_number = PhoneNumber::where('user_id', Auth::user()->id)->get();
        }
        return View::make('phone_number.index')->with('phone_numbers', $phone_number)->with('selected', $input);
	}

    public function manage()
    {
        if(Request::segment(2)=='search'){
            $input = Session::get('search') && !Input::get('search_category') ? Session::get('search') : Input::only(array('search_category','search_keyword'));

            if($input['search_category']=='0'){
                return Redirect::to('phone_number');
            }

            $phone_number = PhoneNumber::where('user_id', Auth::user()->id)->where($input['search_category'], 'LIKE', '%'.$input['search_keyword'].'%')->get();

            Session::set('search', $input);
        }else{
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $phone_number = PhoneNumber::whereHas('user', function($q){
                $q->where('domain_id', Request::segment(3));
            })->get();
        }
        return View::make('phone_number.index')->with('phone_numbers', $phone_number)->with('selected', $input);
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getAdd()
	{
        if(PhoneNumber::where('user_id',Auth::user()->id)->count() >= Config::get('settings.phone_number_limit')){
            return Output::push(array(
                'path' => 'phone_number',
                'messages' => array('fail' => _('You have reached limit phone number')),
            ));
        }
        $data['global_prefix'] = Config::get('settings.global_prefix');
        $data['domain'] = Request::segment(2) == "manage" ? Domain::find(Request::segment(3)) : Domain::find(Auth::user()->domain_id);
        $data['extension'] = Cookie::get('rndext') ? Cookie::get('rndext') : $this->generate_extension();
        $data['users'] = array();
        if(Request::segment(2) == "manage"){
            foreach(User::whereDomainId(Request::segment(3))->get() as $row){
                $data['users'][$row['id']] = $row['username'];
            }
        }

        Cookie::queue('rndext',$data['extension'],60);
        return View::make('phone_number.create')->with('data',$data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        $input = Input::only('description','sip_password', 'user_id');
        $input['extension'] = Cookie::get('rndext');
        $path = Request::segment(2) == 'manage' ? "phone_number/manage/".Request::segment(3) : "phone_number";

        $rules = array(
            'extension' => 'unique:phone_numbers,extension,NULL,id,deleted_at,NULL',
            'sip_password' => 'required|min:6|alpha_num',
        );
        if(Request::segment(2) == 'manage'){
            $rules['user_id'] = 'required';
        }
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => $path.'/add', 'errors' => $v, 'input' => TRUE));
        }

        $phone_number = new PhoneNumber([
            'user_id' => $input['user_id'] ? $input['user_id'] : Auth::user()->id,
            'extension' => $input['extension'],
            'sip_password' => $input['sip_password'],
            'description' => $input['description'],
        ]);
        $phone_number->save();

        Event::fire('logger',array(array('phone_number_add', array('id'=>$phone_number->id, 'extension'=>$input['extension']), 2)));

        if ($phone_number->id) {
            $cookie = Cookie::forget('rndext');

            $user = $input['user_id'] ? User::find($input['user_id']) : Auth::user();
            $data = array(
                'phone_number_e164' => '+' . Config::get('settings.global_prefix') .'-'. $user->domain->prefix .'-'. $input['extension'],
                'local_phone_number' => $input['extension'],
                'domain_sip_server' => $user->domain->sip_server
            );
            $mail_to = $input['user_id'] ? User::find($input['user_id'])->email : Auth::user()->email;
            Mail::send('emails.phone_number', $data, function($message) use ($mail_to) {
                $message->from(
                    Config::get('mail.from.address'),
                    Config::get('mail.from.name')
                )
                    ->to($mail_to)
                    ->subject(_('New phone number'));
            });

            return Redirect::to($path)->with('success', _('You have added Phone Number successfully'))->withCookie($cookie);

        } else {
            return Output::push(array(
                'path' => $path.'/add',
                'messages' => array('fail' => _('Fail to add Phone Number')),
                'input' => TRUE,
            ));
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function getEdit($id, $c_id=null)
    {
        $data['global_prefix'] = Config::get('settings.global_prefix');
        $data['domain'] = $c_id ? Domain::find($id) : Domain::find(Auth::user()->domain_id);
        $data['phone_number'] = $c_id ? PhoneNumber::find($c_id) : PhoneNumber::find($id);
        if(Request::segment(2) == "manage"){
            foreach(User::whereDomainId(Request::segment(3))->get() as $row){
                $data['users'][$row['id']] = $row['username'];
            }
        }

        return View::make('phone_number.edit')->with('data',$data);
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id, $c_id=null)
    {
        $input = Input::only('description','sip_password', 'user_id');

        $id = $c_id ? $c_id : $id;
        $path = $input['user_id'] ? "phone_number/manage/".Request::segment(3) : "phone_number";
        $rules = array(
            'sip_password' => 'min:6|alpha_num',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => $path.'/edit/'.$id, 'errors' => $v, 'input' => TRUE));
        }

        $phone_number = PhoneNumber::find($id);
        $phone_number->description = $input['description'];
        if($c_id) {
            $phone_number->user_id = $input['user_id'];
        }
        if ($input['sip_password']) {
            $phone_number->sip_password = $input['sip_password'];

            Event::fire('logger',array(array('phone_number_sip_password_update', array('id'=>$id,'extension'=>$phone_number->extension), 2)));
        }
        $phone_number->save();

        if ($id) {
            return Output::push(array(
                'path' => $path,
                'messages' => array('success' => _('You have updated phone number successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => $path.'/edit/'.$id,
                'messages' => array('fail' => _('Fail to update phone number')),
                'input' => TRUE,
            ));
        }
    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function getDelete($id,$c_id=null)
    {
        $id = $c_id ? $c_id : $id;
        $phone_number =PhoneNumber::find($id);
        $phone_number->delete();

        Event::fire('logger',array(array('phone_number_remove', array('id'=>$id, 'extension'=>$phone_number->extension), 2)));

        $path = Request::segment(2) == "manage" ? "manage/".Request::segment(3) : "";
        return Output::push(array(
            'path' => 'phone_number/'.$path,
            'messages' => array('success' => _('Phone number  has been deleted'))
        ));
    }

    private function generate_extension()
    {
        $extensions = explode(",",str_replace(" ","",Config::get('settings.reserved_extension')));
        $users = User::where('domain_id',Auth::user()->domain_id)->get();
        foreach ($users as $user) {
            foreach(PhoneNumber::where('user_id',$user['id'])->get() as $phone_number){
                $extensions[] = $phone_number['extension'];
            }
        }

        $rand_ext = rand(100000,999999);
        if(in_array($rand_ext, $extensions) && Cookie::get('rndext') == $rand_ext){
            $this->generate_extension();
        }else{
            return $rand_ext;
        }
    }

}
