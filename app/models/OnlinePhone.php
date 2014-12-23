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
 */

class OnlinePhone extends Eloquent{

    public function domain() {
        return $this->belongsTo('Domain','sip_server','sip_server');
    }
}