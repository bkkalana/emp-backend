<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','middle_name','address','department_id','city_id','state_id','country_id','zip','birthday','date_hired',
    ];
}
