<?php

class SettingController extends \BaseController {

    /**
     * Instantiate a new SettingController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth');
        $this->beforeFilter('auth.admin');

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$settings = Setting::all();

        return View::make('setting.index')->with('settings',$settings);
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
	public function store()
	{
		//
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
	 * @return Response
	 */
	public function postUpdate()
	{
        $input = Input::only('global_prefix','panel_path', 'domain_limit', 'phone_number_limit', 'mail_address', 'sender_name', 'sip_server');

        $rules = array(
            'global_prefix' => 'required|min:1|max:10',
            'panel_path' => 'required|min:1',
            'domain_limit' => 'required|numeric',
            'phone_number_limit' => 'required|numeric',
            'mail_address' => 'required|email',
            'sender_name' => 'required|min:1',
            'sip_server' => 'required|min:3',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'main_config', 'errors' => $v, 'input' => TRUE));
        }

        $panel_path = Setting::whereName('global_prefix')->first();
        $panel_path->value = $input['global_prefix'];
        $panel_path->save();

        $panel_path = Setting::whereName('panel_path')->first();
        $panel_path->value = $input['panel_path'];
        $panel_path->save();

        $domain_limit = Setting::whereName('domain_limit')->first();
        $domain_limit->value = $input['domain_limit'];
        $domain_limit->save();

        $phone_number_limit = Setting::whereName('phone_number_limit')->first();
        $phone_number_limit->value = $input['phone_number_limit'];
        $phone_number_limit->save();

        $mail_address = Setting::whereName('mail_address')->first();
        $mail_address->value = $input['mail_address'];
        $mail_address->save();

        $sender_name = Setting::whereName('sender_name')->first();
        $sender_name->value = $input['sender_name'];
        $sender_name->save();

        $sip_server = Setting::whereName('sip_server')->first();
        $sip_server->value = $input['sip_server'];
        $sip_server->save();

        if ($panel_path->id && $domain_limit->id && $phone_number_limit && $mail_address && $sender_name && $sip_server) {
            return Output::push(array(
                'path' => 'main_config',
                'messages' => array('success' => _('You have updated main configuration successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'main_config',
                'messages' => array('fail' => _('Fail to update main configuration')),
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
	public function destroy($id)
	{
		//
	}


}
