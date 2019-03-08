<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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

    public function find(int $id)
    {
        return self::findOrFail($id);
    }

    public function store(Request $request)
    {

        $input = $request->only([
            'name',
            'information',
            'deadline',
            'type',
            'status',
        ]);

        return self::create($input);
    }

    public function edit(Request $request,int $id)
    {

        $project = self::find($id);

        $input = $request->only([
            'name',
            'information',
            'deadline',
            'type',
            'status',
        ]);

        $project->fill($input);

        $project->save();

        return $project;
    }

    public function remove($id){
        $project = $this->project->find($id);
        $project->delete();
        return $project;
    }

}
