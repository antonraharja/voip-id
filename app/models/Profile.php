<?php

class Profile extends Eloquent {

	protected $table = 'profiles';
	protected $fillable = array('first_name', 'last_name', 'email', 'website', 'address');

	public function user() {
		return $this->hasOne('User', 'user_id');
	}

}
