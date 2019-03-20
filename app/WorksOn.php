<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class WorksOn extends Model
{
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

    public function store(Request $request)
    {
        $input = $request->only([
            'role',
            'project_id',
            'member_id',
        ]);

        return self::create($input);
    }
}
