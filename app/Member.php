<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
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

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $request->avatar->store('');
        }
        return self::create($input);
    }

    public function edit(Request $request, $id)
    {
        $member = self::find($id);

        $input = $request->only([
            'name',
            'information',
            'phone',
            'birthday',
            'position',
            'gender'
        ]);

        $member->fill($input);

        if ($request->hasFile('avatar')) {
            Storage::delete($member->avatar);

            $member->avatar = $request->avatar->store('');
        }

        $member->save();

        return $member;
    }

    public function remove($id)
    {
        $member = $this->find($id);

        if ($member->avatar !== null) {
            Storage::delete($member->avatar);
        }

        $member->delete();

        return $member;
    }

    protected function deleteWorksOn(Collection $collection)
    {
        foreach ($collection as $item) {
            $item->delete();
        }
    }
}
