<?php
/**
 * Created by PhpStorm.
 * 
 * User: rahman
 * Date: 11/5/14
 * Time: 8:50 AM
 *
 * @property string $event_name
 * @property string $custom_parameter
 * @property string $verbose_level
 * @property string $request_uri
 * @property integer $flag
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Logger whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Logger whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Logger whereEventName($value)
 * @method static \Illuminate\Database\Query\Builder|\Logger whereCustomParameter($value)
 * @method static \Illuminate\Database\Query\Builder|\Logger whereVerboseLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\Logger whereRequestUri($value)
 * @method static \Illuminate\Database\Query\Builder|\Logger whereFlag($value)
 * @property integer $id
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\Logger whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Logger whereIpAddress($value) 
 */

class Logger extends Eloquent{
    protected $table = 'logs';
    protected $fillable = array('event_name','custom_parameter','verbose_level','ip_address','request_uri','flag');
} 