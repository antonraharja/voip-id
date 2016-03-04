<?php

class DomainController extends \BaseController {

    /**
     * Instantiate a new DomainController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth');
        $this->beforeFilter('auth.manager');

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
            switch($input['search_category']){
                case '0':
                    return Redirect::to('domain');
                    break;

                case 'owner':
                    $domains = Domain::whereHas('user', function($q){
                        $q->where('username', 'LIKE', '%'.Input::get('search_keyword').'%');
                    })->get();
                    break;

                default:
                    if(Auth::user()->status == 2) {
                        $domains = Domain::where($input['search_category'], 'LIKE', '%' . $input['search_keyword'] . '%')->get();
                    }else{
                        $domains = Domain::where('user_id', Auth::user()->id)->where($input['search_category'], 'LIKE', '%' . $input['search_keyword'] . '%')->get();
                    }
                    break;
            }
            Session::set('search', $input);
        }else {
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $domains = Auth::user()->status == 2 ? Domain::all() : Domain::where('user_id', Auth::user()->id)->get();
        }

        return View::make('domain.index')->with('domains', $domains)->with('selected', $input);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getAdd()
	{
        $users = array();
        if(Auth::user()->status == 2){
            foreach (User::whereStatus(3)->get() as $user) {
                $users[$user['id']] = $user['username'];
            }
        }
        foreach(explode(",", str_replace(" ", "", Config::get('settings.available_css'))) as $css){
            $available_css[$css] = $css;
        }

        if(Domain::where('user_id',Auth::user()->id)->count() >= Config::get('settings.domain_limit')){
            return Output::push(array(
                'path' => 'domain',
                'messages' => array('fail' => _('You have reached limit domain')),
            ));
        }

        return View::make('domain.create')->with('users', $users)->with('available_css', $available_css);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        $input = Input::only('user_id', 'domain', 'sip_server', 'xmpp_domain', 'description', 'homepage', 'title', 'theme', 'allow_registration');
        $input['prefix'] = $this->generate_prefix();

        $rules = array(
            'domain' => 'required|domain|unique:domains,domain,NULL,id,deleted_at,NULL',
            'sip_server' => 'required|different:domain|unique:domains,sip_server,NULL,id,deleted_at,NULL',
			'xmpp_domain' => 'different:domain|unique:domains,sip_server,NULL,id,deleted_at,NULL',
            'prefix' => 'unique:domains,prefix',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
         
            return Output::push(array('path' => 'domain/add', 'errors' => $v, 'input' => TRUE));
        }
        
        $domain = new Domain([
	            'id' => md5($input['domain'].time()),
	            'user_id' => Auth::user()->status == 2 ? $input['user_id'] : Auth::user()->id,
	            'domain' => $input['domain'],
	            'sip_server' => $input['sip_server'],
				'xmpp_domain' => $input['xmpp_domain'],
	            'prefix' => $input['prefix'],
	            'allow_registration' => $input['allow_registration'],
	            'description' => $input['description'],
	            'title' => $input['title'],
	            'homepage' => $input['homepage'],
	            'theme' => $input['theme'],
				]);
        
        
        if($this->_registeredDss($input['sip_server'])){
            return Output::push(array(
                'path' => 'domain/add',
                'messages' => array('fail' => _('We Are Sorry! Domain name for SIP Server (DSS) was registered and Active')),
            ));
        }elseif($domain->id){
        	$domain->save();
        	Event::fire('logger',array(array('domain_add', array('id'=>$domain->id, 'domain_name'=>$domain->domain), 2)));
	        return Output::push(array(
                'path' => 'domain',
                'messages' => array('success' => _('You have added domain successfully')),
            ));
        }else {
            return Output::push(array(
                'path' => 'domain/add',
                'messages' => array('fail' => _('Fail to add domain')),
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
	public function getUsers($id)
	{
        if(Request::segment(4)=='search'){
            $input = Session::get('search') && !Input::get('search_category') ? Session::get('search') : Input::only(array('search_category','search_keyword'));
            switch($input['search_category']){
                case '0':
                    return Redirect::to('domain/users/'.$id);
                    break;

                case 'name':
                    $users = User::where('domain_id', $id)->whereHas('profile', function($q){
                        $q->where(function($q){
                            $q->where('first_name', 'like', '%'.Input::get('search_keyword').'%');
                            $q->orWhere('last_name', 'like', '%'.Input::get('search_keyword').'%');
                        });
                    })->get();
                    break;

                default:
                    $users = User::where('domain_id', $id)->where($input['search_category'], 'LIKE', '%'.$input['search_keyword'].'%')->get();
                    break;
            }
            Session::set('search', $input);
        }else{
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $users = User::where('domain_id', $id)->get();
        }
        return View::make('domain.users')->with('users',$users)->with('selected', $input);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
        $domain = Domain::find($id);
        foreach(explode(",", str_replace(" ", "", Config::get('settings.available_css'))) as $css){
            $available_css[$css] = $css;
        }

        $users = array();
        if(Auth::user()->status == 2){
            foreach (User::whereStatus(3)->get() as $user) {
                $users[$user['id']] = $user['username'];
            }
        }

        return View::make('domain.edit')->with('domain',$domain)->with('available_css', $available_css)->with('users', $users);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $input = Input::only('user_id', 'domain', 'sip_server', 'description', 'homepage', 'title', 'theme', 'allow_registration');

		// fixme anton - domain and sip_server may not be edited
		/*
        $rules = array(
            'domain' => 'required|domain|unique:domains,domain,'.$id.',id,deleted_at,NULL',
            'sip_server' => 'required',
        );
        $message = array(
            'domain' => 'The :attribute field is not valid.',
        );
        $v = Validator::make($input, $rules, $message);
        if ($v->fails()) {
            return Output::push(array('path' => 'domain/edit/'.$id, 'errors' => $v, 'input' => TRUE));
        }

        $domain = Domain::find($id);
        $domain->domain = $input['domain'];
        $domain->sip_server = $input['sip_server'];
        $domain->description = $input['description'];
        $domain->homepage = $input['homepage'];
        $domain->save();
        */

        $domain = Domain::find($id);
        $domain->allow_registration = $input['allow_registration'];
        $domain->description = $input['description'];
        $domain->title = $input['title'];
        $domain->homepage = $input['homepage'];
        $domain->theme = $input['theme'];
        if(Auth::user()->status == 2){
            $domain->user_id = $input['user_id'];
        }
        $domain->save();
        
        if ($id) {
            return Output::push(array(
                'path' => 'domain',
                'messages' => array('success' => _('You have updated domain successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'domain/edit/'.$id,
                'messages' => array('fail' => _('Fail to update domain')),
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
        $domain = Domain::find($id);
        $domain->delete();
        $user = User::whereDomainId($id)->first();
        if($user) {
            $user->delete();
            $phone_number = PhoneNumber::whereUserId($user->id)->first();
            $phone_number->delete();
            Event::fire('logger',array(array('phone_number_remove', array('id'=>$phone_number->id, 'extension'=>$phone_number->extension), 2)));
        }

        Event::fire('logger',array(array('domain_remove',array('id'=>$id,'domain_name'=>$domain->domain),2)));

        return Output::push(array(
            'path' => 'domain',
            'messages' => array('success' => _('Domain has been deleted'))
        ));
	}

    private function generate_prefix()
    {
	        $prefix = explode(',', str_replace(" ","",Config::get('settings.reserved_domain_prefix')));
        	foreach(Domain::all() as $domain){
	            $prefix[] = $domain['prefix'];
        	}
		foreach(Gateway::all() as $gateway){
			$prefix[] = $gateway['prefix'];
		}

	        $rand_prefix = rand(1,9).rand(1,9).rand(1,9);
        	if(in_array($rand_prefix, $prefix)){
	            $this->generate_prefix();
        	}else{
	            return $rand_prefix;
        	}
    }
    
    private function _registeredDss($sip_server){
		$results = DB::select('select sip_server from domains where deleted_at IS NULL and sip_server = ?', array($sip_server));
		if($results){
				return TRUE;
			}else return FALSE;
		
	}


}
