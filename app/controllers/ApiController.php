<?php

class ApiController extends \BaseController {

	/**
	 * Instantiate a new OnlinePhonesController instance.
	 */
	public function __construct() {

		//$this->beforeFilter('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function postOnlinephonelist()
	{
		$token = Input::only('token');
		$user_id = $this->_getUserId($token['token']);
		echo $user_id;
		echo $this->_getUsername($user_id);
		echo $this->_getUserStatus($user_id);
		//var_dump($varnya);

		//return View::make('online_phone.index')->with('online_phones', $online_phone);
	}
	
	private function _getUserId($token){
		$user = Token::where('token',$token)->get(['user_id']);
		return $user[0]->user_id;
	}
	
	private function _getUsername($user_id){
		$username = User::find($user_id);
		return $username->username;
	}
	
	private function _getUserStatus($user_id){
		$status = User::find($user_id);
		return $status->status;
	}
	
	private function _haveOnlinePhone($sip_server){
		$results = DB::select('select sip_server from domains where deleted_at IS NULL and sip_server = ?', array($sip_server));
		if($results){
				return TRUE;
			}else return FALSE;
		
	}


}
