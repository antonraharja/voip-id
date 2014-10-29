<?php

class PhoneNumberController extends \BaseController {

    /**
     * Instantiate a new DomainController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth');
//        $this->beforeFilter('auth.admin');

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $phone_number = PhoneNumber::where('user_id',Auth::user()->id)->get();

        return View::make('phone_number.index')->with('phone_numbers', $phone_number);
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
        $data['domain_prefix'] = Domain::find(Auth::user()->domain_id)->pluck('prefix');
        $data['extension'] = Cookie::get('rndext') ? Cookie::get('rndext') : $this->generate_extension();

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
        $input = Input::only('description','sip_password');
        $input['extension'] = Cookie::get('rndext');

        $rules = array(
            'extension' => 'unique:phone_numbers,extension',
            'sip_password' => 'required|min:6|alpha_num',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'phone_number/add', 'errors' => $v, 'input' => TRUE));
        }

        $phone_number = new PhoneNumber([
            'user_id' => Auth::user()->id,
            'extension' => $input['extension'],
            'sip_password' => $input['sip_password'],
            'description' => $input['description'],
        ]);
        $phone_number->save();

        if ($phone_number->id) {
            $cookie = Cookie::forget('rndext');
//            return Output::push(array(
//                'path' => 'phone_number',
//                'messages' => array('success' => _('You have added Phone Number successfully')),
//            ));

            return Redirect::to('phone_number')->with('success', _('You have added Phone Number successfully'))->withCookie($cookie);

        } else {
            return Output::push(array(
                'path' => 'phone_number/add',
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
    public function getEdit($id)
    {
        $data['global_prefix'] = Config::get('settings.global_prefix');
        $data['domain_prefix'] = Domain::find(Auth::user()->domain_id)->pluck('prefix');
        $data['phone_number'] = PhoneNumber::find($id);

        return View::make('phone_number.edit')->with('data',$data);
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id)
    {
        $input = Input::only('description','sip_password');

        $rules = array(
            'sip_password' => 'required|min:6|alpha_num',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'phone_number/edit/'.$id, 'errors' => $v, 'input' => TRUE));
        }

        $domain = PhoneNumber::find($id);
        $domain->description = $input['description'];
        if ($input['sip_password']) {
            $domain->sip_password = $input['sip_password'];
        }
        $domain->save();

        if ($id) {
            return Output::push(array(
                'path' => 'phone_number',
                'messages' => array('success' => _('You have updated phone number successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'phone_number/edit/'.$id,
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
    public function getDelete($id)
    {
        PhoneNumber::destroy($id);

        return Output::push(array(
            'path' => 'phone_number',
            'messages' => array('success' => _('Phone number  has been deleted'))
        ));
    }

    private function generate_extension()
    {
        $extensions = array();
        $users = User::where('domain_id',Auth::user()->domain_id)->get();
        foreach ($users as $user) {
            foreach(PhoneNumber::where('user_id',$user['id'])->get() as $phone_number){
                $extensions[] = $phone_number['extension'];
            }
        }

        $rand_ext = rand(100,999);
        if(in_array($rand_ext, $extensions) && Cookie::get('rndext') == $rand_ext){
            $this->generate_extension();
        }else{
            return $rand_ext;
        }
    }

}
