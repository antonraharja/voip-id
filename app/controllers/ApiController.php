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
		$online_phone = '';
		if($user_id){
			$status = $this->_getUserStatus($user_id);
			
			if($status == 2){
				$online_phone = OnlinePhone::all();
			}elseif($status == 3){
				$domain = Domain::whereUserId($user_id)->get(array('sip_server'));
				$sip_server = array();
				foreach ($domain as $row) {
					$sip_server[] = $row['sip_server'];
				}
				if($sip_server){
					$online_phone = OnlinePhone::whereIn('sip_server', $sip_server)->get();
				} else $online_phone = [];
			}else{
				$sip_server = Domain::whereUserId($user_id)->first()->sip_server;
				$online_phone = OnlinePhone::whereSipServer($sip_server)->get();
			}
		}
		echo $online_phone;

		//return View::make('online_phone.index')->with('online_phones', $online_phone);
	}
	
	private function _getUserId($token){
		if(Token::where('token',$token)->exists()){
			$user = Token::where('token',$token)->get(['user_id']);
			return $user[0]->user_id;
		}else return false;
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
