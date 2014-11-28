<?php

class PanelController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function register($hash)
    {
        //$domain = Domain::find($hash);

        //return View::make('panel.register')->with('domain',$domain);

        $cookie = Cookie::make('domain_hash', $hash);

        return Redirect::to('/')->withCookie($cookie);
    }

    public function dcp()
    {
        $domain = Domain::whereDomain(Request::server("SERVER_NAME"))->first();
        $cookie = Cookie::make('domain_hash', $domain->id);

        return Redirect::to('/')->withCookie($cookie);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($hash)
	{
        $input = Input::only('first_name', 'last_name', 'email', 'username', 'password');

        $rules = array(
            'first_name' => 'required|min:1',
            'email' => 'required|email|unique:users',
            'username' => 'required|min:3|alpha_num|unique:users',
            'password' => 'required|min:6',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'panel/'.$hash.'/register', 'errors' => $v, 'input' => TRUE));
        }

        $profile = new Profile(array(
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
        ));
        $profile->save();

        $user = new User(array(
            'domain_id' => $hash,
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'status' => 4,
        ));
        $user->profile()->associate($profile);
        $user->save();

        if ($user->id) {
            $confirmation = App::make('email-confirmation');
            $confirmation->send($user);
            Mail::send('emails.register', array('new_user' => $input['username']), function($message) {
                $message->from(
                    Config::get('startup.email_sender.address'),
                    Config::get('startup.email_sender.name')
                )
                    ->to(Input::get('email'))
                    ->subject(_('New user registration'));
            });

            return Output::push(array(
                'path' => 'login',
                'messages' => array('success' => _('You have registered successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'panel/'.$hash.'/register',
                'messages' => array('fail' => _('Fail to register')),
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
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
