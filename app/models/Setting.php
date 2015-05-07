<?php
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

class Setting extends Eloquent{
    protected $fillable = array('name','value');
    protected $softDelete = true;
} 