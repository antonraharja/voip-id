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
				$call_detail_report = $this->_orWhereIn('caller_domain','callee_domain',$sip_server);
			 	//$call_detail_report = Cdr::whereIn('caller_domain', $sip_server)->get();
				//$call_detail_report2 = Cdr::whereIn('callee_domain', $sip_server)->get();
				//$call_detail_report->merge($call_detail_report2);
			} else $call_detail_report = [];
		}else{
			$sip_server = Domain::find(Cookie::get('domain_hash'))->sip_server;
			$call_detail_report = Cdr::whereSipServer($sip_server)->get();
		}
		//print_r($call_detail_report);
		return View::make('call_detail_reports.index')->with('call_detail_reports', $call_detail_report);
	}
	
	
	
	
	public function getFilter(){
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
				$call_detail_report = $this->_orWhereIn('caller_domain','callee_domain',$sip_server);
			} else $call_detail_report = [];
		}else{
			$sip_server = Domain::find(Cookie::get('domain_hash'))->sip_server;
			$call_detail_report = Cdr::whereSipServer($sip_server)->get();
		}
		
		$input = Input::only(array('datefilter','datefrom','dateto','timefilter','timefrom','timeto','durationparam','durationfilter','duration','fromfilter','from','tofilter','to'));
		if($input['datefilter'] || $input['timefilter'] || $input['durationfilter'] || $input['fromfilter'] || $input['tofilter']){
			$q = "select * from cdrs where ";
			$q = $q."(".$this->_orGenerator('caller_domain','callee_domain',$sip_server).") ";
			if($input['datefilter']){
				$fromdate = $this->_intlDate($input['datefrom']);
				$todate = $this->_intlDate($input['dateto']);
				if($input['timefilter']){
					$q = $q."AND (call_start_time BETWEEN ";
					$q = $q."'".$fromdate." ".$input['timefrom']."' AND '".$todate." ".$input['timeto']."') ";
				}else{
					$q = $q."AND (call_start_time BETWEEN ";
					$q = $q."'".$fromdate."' AND '".$todate."') ";
				}
			}
			if($input['timefilter'] && !$input['datefilter']){
				$q = $q."AND (call_start_time BETWEEN ";
				$fromdate = "2000-01-01";
				$todate = date("Y-m-d");
				$q = $q."'".$fromdate." ".$input['timefrom']."' AND '".$todate." ".$input['timeto']."') ";
			}
			if($input['durationfilter']){
				$duration = $this->_getDuration($input['duration']);
				$q = $q."AND (duration ".$input['durationparam']." ".$duration.") ";
			}
			if($input['fromfilter']){
				$fromarr = explode("@",$input['from']);
				$q = $q."AND (src_uri = '".$fromarr[0]."' and caller_domain = ".$fromarr[1].") ";
			}
			if($input['tofilter']){
				$toarr = explode("@",$input['to']);
				$q = $q."AND (dst_uri = '".$toarr[0]."' and callee_domain = ".$toarr[1].") ";
			}
			$q = $q."order by call_start_time desc";
			$results = DB::select($q);
			return View::make('call_detail_reports.index')->with('call_detail_reports', $results);
		}else{
			return View::make('call_detail_reports.index')->with('call_detail_reports', $call_detail_report);
		}
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
		$q = 'select * from cdrs WHERE  YEAR(call_start_time) = YEAR(curdate()) and MONTH(call_start_time) = MONTH(curdate()) and ( '.$sip_server_or.' ) order by call_start_time desc';	
		$results = DB::select($q);
		if($results){
				return $results;
			}else return FALSE;		
	}
	
	private function _orGenerator($arg1,$arg2,$sip_server){
		$sip_server_or = "";
		foreach ($sip_server as $row) {
				$tempq = $arg1." = '".$row."' or ".$arg2." = '".$row."'";
				if($sip_server_or){
					$sip_server_or = $sip_server_or." or ".$tempq;
					} else{
						$sip_server_or = $tempq;
					}
			}
		if($sip_server_or){
				return $sip_server_or;
			}else return FALSE;		
	}
	
	private function _intlDate($datevar){
		$datearr = explode("/",$datevar);
		$todate = $datearr[2]."-".$datearr[1]."-".$datearr[0];
		return $todate;
	}
	
	private function _getDuration($timevar){
		$timearr = explode(":",$timevar);
		$tosecond = $timearr[2]+($timearr[1]*60)+($timearr[0]*3600);
		return $tosecond;
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
