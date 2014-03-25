<?php

class DashboardController extends BaseController {

	public function showDashboard() {
		return View::make('dashboard');
	}

}
