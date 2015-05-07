<?php

class DashboardController extends BaseController {

	/**
	* Instantiate a new DashboardController instance.
	*/
	public function __construct() {
		$this->beforeFilter('auth');
	}

	public function getIndex() {
        if(Cookie::get('domain_hash')) {
            $domain = Domain::find(Cookie::get('domain_hash'));
            $homepage = $domain->homepage ? $domain->homepage : $domain->domain;
            return View::make('dashboard.index')->withHomepage($homepage);
        }else{
            return View::make('dashboard.index');
        }
	}

}
