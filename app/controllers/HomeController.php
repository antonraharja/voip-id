<?php

class HomeController extends BaseController {

	public function showWelcome() {
		return View::make('home');
	}

	public function showDashboard() {
		return View::make('dashboard');
	}

}
