<?php

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
 * @property string $sip_server
 * @method static \Illuminate\Database\Query\Builder|\Domain whereSipServer($value)
 * @property string $title
 * @property string $homepage
 * @property string $theme
 * @method static \Illuminate\Database\Query\Builder|\Domain whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereHomepage($value)
 * @method static \Illuminate\Database\Query\Builder|\Domain whereTheme($value)
 * @property integer $allow_registration
 * @method static \Illuminate\Database\Query\Builder|\Domain whereAllowRegistration($value) 
 */
class Domain extends Eloquent {

	protected $fillable = array('id', 'user_id', 'name', 'domain', 'sip_server', 'prefix', 'description', 'homepage', 'title', 'theme', 'allow_registration');
    public $incrementing = false;
    protected $softDelete = true;

	public function user() {
		return $this->belongsTo('User');
	}

}
