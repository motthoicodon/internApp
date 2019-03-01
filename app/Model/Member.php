<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    const GENDER = ['male', 'female'];
    const POSITIONS = ['intern', 'junior', 'senior', 'pm','ceo','cto', 'bo'];

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
}
