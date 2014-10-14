<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Users
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Profile $profile
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereProfileId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereDeletedAt($value)
 * @property string $remember_token
 * @method static \Illuminate\Database\Query\Builder|\User whereRememberToken($value)
 * @property integer $status
 * @property integer $flag_banned
 * @method static \Illuminate\Database\Query\Builder|\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereFlagBanned($value)
 * @property string $domain_id
 * @method static \Illuminate\Database\Query\Builder|\User whereDomainId($value) 
 */
class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier() {
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail() {
		return $this->email;
	}

	/**
	 * Get remember token
	 *
	 * @return string
	 */
	public function getRememberToken() {
		return $this->remember_token;
	}

	/**
	 * Set remember token
	 */
	public function setRememberToken($value) {
		$this->remember_token = $value;
	}

	/**
	 * Get remember token name
	 *
	 * @return string
	 */
	public function getRememberTokenName() {
		return 'remember_token';
	}
	
	protected $fillable = array('domain_id','email', 'username', 'password', 'status');

	public function profile() {
		return $this->belongsTo('Profile');
	}

}
