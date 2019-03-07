<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'information',
        'deadline',
        'type',
        'status'
    ];

    public function members()
    {
        return $this->belongsToMany('App\Member', 'works_on');
    }
}
