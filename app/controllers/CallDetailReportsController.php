<?php

class CallDetailReportsController extends \BaseController {

	/**
	 * Instantiate a new OnlinePhonesController instance.
	 */
	public function __construct() {

		$this->beforeFilter('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$status = Auth::user()->status;
		if($status == 2){
			$call_detail_report = Cdr::all();
		}elseif($status == 3){
			$domain = Domain::whereUserId(Auth::user()->id)->get(array('sip_server'));
			$sip_server = array();
			foreach ($domain as $row) {
				$sip_server[] = $row['sip_server'];
			}
			if($sip_server){
				//$call_detail_report = $this->_orWhereIn('caller_domain','callee_domain',$sip_server);
			 	$call_detail_report = Cdr::whereIn('caller_domain', $sip_server)->get();
				$call_detail_report2 = Cdr::whereIn('callee_domain', $sip_server)->get();
				$call_detail_report->merge($call_detail_report2);
			} else $call_detail_report = [];
		}else{
			$sip_server = Domain::find(Cookie::get('domain_hash'))->sip_server;
			$call_detail_report = Cdr::whereSipServer($sip_server)->get();
		}
		//print_r($call_detail_report);
		return View::make('call_detail_reports.index')->with('call_detail_reports', $call_detail_report);
	}
	
	
	
	
	public function getFilter(){
		$input = Input::only(array('datefilter','datefrom','dateto','timefilter','timefrom','timeto','durationfilter','duration','fromfilter','from','tofilter','to'));
		print_r($input);
		
	}
	
	private function _orWhereIn($arg1,$arg2,$sip_server){
		$sip_server_or = "";
		foreach ($sip_server as $row) {
				$tempq = $arg1." = '".$row."' or ".$arg2." = '".$row."'";
				if($sip_server_or){
					$sip_server_or = $sip_server_or." or ".$tempq;
					} else{
						$sip_server_or = $tempq;
					}
			}
			
		$results = DB::select('select * from cdrs WHERE MONTH(FROM_UNIXTIME(created)) = MONTH(CURDATE())
   AND YEAR(FROM_UNIXTIME(created)) = YEAR(CURDATE()) and ( '.$tempq.' )');
		if($results){
				return $results;
			}else return FALSE;
		
	}
	
	
	public function getFilterori()
	{
		if(Request::segment(2)=='filter'){
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



}
