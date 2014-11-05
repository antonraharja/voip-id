<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace {
/**
 * Domain
 *
 * @property string $id
 * @property integer $user_id
 * @property string $domain
 * @property integer $prefix
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \User $user
 * @method static \Illuminate\Database\Query\Builder|\Domain whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain wherePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereDeletedAt($value)
 */
	class Domain {}
}

namespace {
/**
 * Created by PhpStorm.
 * 
 * User: rahman
 * Date: 11/5/14
 * Time: 8:50 AM
 *
 */
	class Logger {}
}

namespace {
/**
 * Created by PhpStorm.
 * 
 * User: rahman
 * Date: 14/10/14
 * Time: 0:38
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone_number
 * @property integer $account
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereDeletedAt($value)
 * @property integer $extension
 * @property string $sip_password
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereExtension($value) 
 * @method static \Illuminate\Database\Query\Builder|\PhoneNumber whereSipPassword($value) 
 */
	class PhoneNumber {}
}

namespace {
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
	class Profile {}
}

namespace {
/**
 * Created by PhpStorm.
 * 
 * User: rahman
 * Date: 13/10/14
 * Time: 13:52
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Setting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Setting whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Setting whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Setting whereDeletedAt($value)
 */
	class Setting {}
}

namespace {
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain[] $domain
 */
	class User {}
}

