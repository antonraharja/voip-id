<?php

class HomeController extends BaseController {

	public function showHome() {
        if(Cookie::get('domain_hash')) {
            $domain = Domain::find(Cookie::get('domain_hash'));
            $homepage = $domain->homepage ? $domain->homepage : $domain->domain;
            return View::make('home')->withHomepage($homepage);
        }else{
            return View::make('home');
        }
	}

}
