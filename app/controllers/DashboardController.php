<?php

class DashboardController extends BaseController {

	/**
	* Instantiate a new DashboardController instance.
	*/
	public function __construct() {
		$this->beforeFilter('auth');
	}

	public function getIndex() {
		return View::make('dashboard.index');
	}

}
