<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    const TYPES = ['lab','single','acceptance'];

    const STATUS = ['planned','onhold','doing','done','cancelled'];

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

    public function getAll()
    {
        return self::all();
    }
}
