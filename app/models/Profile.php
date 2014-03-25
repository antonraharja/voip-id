<?php

class Profile extends Eloquent {

	protected $table = 'profiles';
	protected $fillable = array('name', 'email', 'website', 'address');

	public function user() {
		return $this->hasOne('User', 'user_id');
	}

}
