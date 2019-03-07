<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'information',
        'phone',
        'birthday',
        'avatar',
        'position',
        'gender',
    ];

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'works_on');
    }
}
