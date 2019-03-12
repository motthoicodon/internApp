<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorksOn extends Model
{
    use SoftDeletes;
    protected $table = 'works_on';

    const ROLES = ['dev','pl','pm','po','sm'];

    protected $fillable = [
        'member_id',
        'project_id',
        'role',
    ];

    public function member()
    {
        return $this->belongsTo('App\Member');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
