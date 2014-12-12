<?php

/**
 * Domain
 *
 * @property-read \User $user
 */
class Gateway extends Eloquent {

	protected $fillable = array('id', 'user_id', 'gateway_name', 'gateway_address', 'prefix');
    protected $softDelete = true;

	public function user() {
		return $this->belongsTo('User');
	}

}
