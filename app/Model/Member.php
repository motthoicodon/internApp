<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];



    const GENDER = ['male', 'female'];
    const POSITIONS = ['intern', 'junior', 'senior', 'pm','ceo','cto', 'bo'];

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
}
