<?php

/**
 * Domain
 *
 * @property-read \User $user
 * @property integer $id
 * @property integer $user_id
 * @property string $gateway_name
 * @property string $gateway_address
 * @property integer $prefix
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereGatewayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereGatewayAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway wherePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Gateway whereDeletedAt($value)
 */
class Gateway extends Eloquent {

	protected $fillable = array('id', 'user_id', 'gateway_name', 'gateway_address', 'prefix');
    protected $softDelete = true;

	public function user() {
		return $this->belongsTo('User');
	}

}
