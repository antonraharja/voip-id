<?php
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
 */

class PhoneNumber extends Eloquent{
    protected $fillable = array('user_id', 'phone_number', 'account', 'description');
} 