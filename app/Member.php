<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Member extends Model
{
    use SoftDeletes;

    const POSITIONS = ['intern','junior','senior','pm','ceo','cto','bo'];
    const GENDERS = ['male','female'];

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

    public function workson()
    {
        return $this->hasMany(WorksOn::class);
    }

    public function getAll()
    {
        return self::all();
    }

    public function find(int $id)
    {
        return self::findOrFail($id);
    }

    public function store(Request $request)
    {
        $input = $request->only([
            'name',
            'information',
            'phone',
            'birthday',
            'avatar',
            'position',
            'gender'
        ]);

        if ($request->avatar != null) {
            $input['avatar'] = $request->avatar->store('');
        }
        return self::create($input);
    }
}
