<?php

class GatewayController extends \BaseController {

	/**
	 * Instantiate a new GatewayController instance.
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
					return Redirect::to('gateway');
					break;

				case 'owner':
					$gateways = Gateway::whereHas('user', function($q){
						$q->where('username', 'LIKE', '%'.Input::get('search_keyword').'%');
					})->get();
					break;

				default:
					if(Auth::user()->status == 2) {
						$gateways = Gateway::where($input['search_category'], 'LIKE', '%' . $input['search_keyword'] . '%')->get();
					}else{
						$gateways = Gateway::where('user_id', Auth::user()->id)->where($input['search_category'], 'LIKE', '%' . $input['search_keyword'] . '%')->get();
					}
					break;
			}
			Session::set('search', $input);
		}else {
			Session::remove('search');
			$input = array('search_category'=>'','search_keyword'=>'');
			$gateways = Auth::user()->status == 2 ? Gateway::all() : Gateway::where('user_id', Auth::user()->id)->get();
		}

		return View::make('gateway.index')->with('gateways', $gateways)->with('selected', $input);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getAdd()
	{
//		if(Auth::user()->status == 2){
//			return Redirect::to('/gateway');
//		}

//		if(gateway::where('user_id',Auth::user()->id)->count() >= Config::get('settings.gateway_limit')){
//			return Output::push(array(
//				'path' => 'gateway',
//				'messages' => array('fail' => _('You have reached limit gateway')),
//			));
//		}

		return View::make('gateway.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
		$input = Input::only('gateway_name', 'gateway_address');
		$input['prefix'] = $this->generate_prefix();

		$rules = array(
			'gateway_name' => 'required|min:3',
			'gateway_address' => 'required|ip_hostname|unique:gateways,gateway_address,NULL,id,deleted_at,NULL',
			'prefix' => 'unique:gateways,prefix',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array('path' => 'gateway/add', 'errors' => $v, 'input' => TRUE));
		}

		$gateway = new Gateway([
			'user_id' => Auth::user()->id,
			'gateway_name' => $input['gateway_name'],
			'gateway_address' => $input['gateway_address'],
			'prefix' => $input['prefix']
		]);
		$gateway->save();
		Event::fire('logger',array(array('gateway_add', array('id'=>$gateway->id, 'gateway_name'=>$gateway->gateway), 2)));

		if ($gateway->id) {
			return Output::push(array(
				'path' => 'gateway',
				'messages' => array('success' => _('You have added gateway successfully')),
			));
		} else {
			return Output::push(array(
				'path' => 'gateway/add',
				'messages' => array('fail' => _('Fail to add gateway')),
				'input' => TRUE,
			));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$gateway = Gateway::find($id);

		return View::make('gateway.edit')->with('gateway',$gateway);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function anyUpdate($id)
	{
		$input = Input::only('gateway_name', 'gateway_address');

		$rules = array(
			'gateway_name' => 'required|min:3',
			'gateway_address' => 'required|ip_hostname|unique:gateways,gateway_address,'.$id.',id,deleted_at,NULL',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array('path' => 'gateway/edit/'.$id, 'errors' => $v, 'input' => TRUE));
		}

		$gateway = Gateway::find($id);
		$gateway->gateway_name = $input['gateway_name'];
		$gateway->gateway_address = $input['gateway_address'];
		$gateway->save();

		if ($id) {
			return Output::push(array(
				'path' => 'gateway',
				'messages' => array('success' => _('You have updated gateway successfully')),
			));
		} else {
			return Output::push(array(
				'path' => 'gateway/edit/'.$id,
				'messages' => array('fail' => _('Fail to update gateway')),
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
		$gateway = Gateway::find($id);
		$gateway->delete();

		Event::fire('logger',array(array('gateway_remove',array('id'=>$id,'gateway_name'=>$gateway->gateway_name),2)));

		return Output::push(array(
			'path' => 'gateway',
			'messages' => array('success' => _('Gateway has been deleted'))
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


}
