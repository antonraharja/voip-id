<?php

/**
 * User profiles
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $website
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \User $user
 * @method static \Illuminate\Database\Query\Builder|\Profile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Profile whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Profile whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Profile whereDeletedAt($value)
 */
class Profile extends Eloquent {

	protected $fillable = array('first_name', 'last_name', 'email', 'website', 'address');

	public function user() {
		return $this->hasOne('User');
	}

}
