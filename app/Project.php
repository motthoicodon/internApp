<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
            'deadline',
            'type',
            'status',
        ]);

        return self::create($input);
    }

    public function edit(Request $request, int $id)
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

    public function remove($id)
    {
        $project = $this->find($id);

        if (count($project->workson) > 0) {
            $this->deleteWorksOn($project->workson);
        }

        $project->delete();

        return $project;
    }

    protected function deleteWorksOn(Collection $collection)
    {
        foreach ($collection as $item) {
            $item->delete();
        }
    }

    public function isExistMember(Member $member)
    {

        $countMember = $this->members()
                            ->where('member_id', $member->id)
                            ->count();

        return  $countMember !== 0;
    }
}
