<?php
/**
 * Created by PhpStorm.
 * 
 * User: rahman
 * Date: 12/23/14
 * Time: 4:19 PM
 *
 * @property integer $id
 * @property string $username
 * @property string $domain
 * @property \Carbon\Carbon $created_at
 * @method static \Illuminate\Database\Query\Builder|\OnlinePhone whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\OnlinePhone whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\OnlinePhone whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\OnlinePhone whereCreatedAt($value)
 * @property string $sip_server
 * @method static \Illuminate\Database\Query\Builder|\OnlinePhone whereSipServer($value)
 * @property \Carbon\Carbon $updated_at 
 * @property-read \PhoneNumber $phonenumber 
 * @method static \Illuminate\Database\Query\Builder|\OnlinePhone whereUpdatedAt($value)
 */

class Cdr extends Eloquent{

    public function domain() {
        return $this->belongsTo('Domain','sip_server','sip_server');
    }

    public function phonenumber(){
        return $this->belongsTo('PhoneNumber','username','extension');
    }
    
}