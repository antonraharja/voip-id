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
				//$online_phone = OnlinePhone::all();
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
				//$sip_server = Domain::whereUserId($user_id)->first()->sip_server;
				//$online_phone = OnlinePhone::whereSipServer($sip_server)->get();
			}
		}
		
		echo $online_phone;
	}
	
	public function postUserlist()
	{
		$token = Input::only('token','domain');
		$user_id = $this->_getUserId($token['token']);
		$domain = $token['domain'];
		$user_list = '';
		if($user_id){
			$status = $this->_getUserStatus($user_id);
			if($status == 3){
				$domain_id = $this->_getDomainId($user_id,$domain);
				if($domain_id){
					$user_list = User::where('domain_id', $domain_id)->get();
				}
			}
		}
		return View::make('api.userlist')->with('users',$user_list);
	}
	
	public function postPhoneNumberlist()
	{
		$token = Input::only('token','dcp','user');
		$user_id = $this->_getUserId($token['token']);
		$domain = $token['dcp'];
		$user = $token['user'];
		$phone_number = '';
		if($user_id){
			$status = $this->_getUserStatus($user_id);
			if($status == 3){
				$domain_id = $this->_getDomainId($user_id,$domain);
				$domains_id = $this->_getDomainsId($user_id);
				if($domain_id){
					if(!$user){
						$phone_number = PhoneNumber::whereHas('user', function($q) use($domain_id){
										$q->where('domain_id', $domain_id);
										})->get();
										print_r($cars);
					}else{
						$phone_number = $this->_getPhoneNumberbyUser($user,$domains_id);
					}
				}else if($user){
					$phone_number = $this->_getPhoneNumberbyUser($user,$domains_id);
				}
			}
		}
		return View::make('api.phonenumber')->with('phone_numbers',$phone_number);
	}
	
	public function postDomainlist(){
		$token = Input::only('token');
		$user_id = $this->_getUserId($token['token']);
		$domain_list = '';
		if($user_id){
			$status = $this->_getUserStatus($user_id);
			
			if($status == 3){
				$domain_list = Domain::where('user_id', $user_id)->get();
			}
		}
		return View::make('api.domainlist')->with('domain_list',$domain_list);
	}
	
	private function _getPhoneNumberbyUser($user,$domains_id){
		$field = "username";
		if($this->_isEmail($user)){
			$field = "email";
		}
		$phone_number = PhoneNumber::whereHas('user', function($q) use($user,$field,$domains_id){
										$q->where($field, $user)->whereIn('domain_id',$domains_id);
										})->get();
		return $phone_number;
	}
	
	private function _isEmail($user){
		$userasemail = explode("@", $user);
		if(isset($userasemail[1])){
			return true;
		}else return false;
	}
	
	private function _getUserId($token){
		if(Token::where('token',$token)->exists()){
			$user = Token::where('token',$token)->get(['user_id']);
			return $user[0]->user_id;
		}else return false;
	}
	
	private function _getDomainId($user_id,$domain){
		if(Domain::where('user_id',$user_id)->where('domain',$domain)->exists()){
			$domain = Domain::where('user_id',$user_id)->where('domain',$domain)->get(['id']);
			return $domain[0]->id;
		}else return false;
	}
	
	private function _getDomainsId($user_id){
		if(Domain::where('user_id',$user_id)->exists()){
			$domains = Domain::where('user_id',$user_id)->get(['id']);
			$domains_temp = $domains->toArray();
			$domainids = [];
			foreach ($domains_temp as $doms){
				array_push($domainids,$doms['id']);
			}
			return $domainids;
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
