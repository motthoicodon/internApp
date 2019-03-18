<?php

namespace App\Http\Controllers;

use App\Member;
use App\Project;
use App\WorksOn;
use Illuminate\Http\Request;

class ProjectMemberController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $members = $project->members;

        return $this->successResponse(['data' => $members], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $rules = [
            'member_id' => 'required|exists:members,id',
            'role' => 'required|in:' . implode(',', WorksOn::ROLES),
        ];

        $this->validate($request, $rules);

        $input = $request->only([
            'member_id',
            'role'
        ]);


        $input['project_id'] = $project->id;

        $member = Member::findOrFail($input['member_id']);

        if ($project->isExistMember($member)) {
            return $this->errorResponse('The member has been assigned into this project', 422);
        }

        $worksOn = WorksOn::create($input);

        return $this->showOne($worksOn);

    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Member $member)
    {
        $worksOn = WorksOn::where('project_id', $project->id)
                        ->where('member_id', $member->id)
                        ->firstOrFail();

        $worksOn->delete();

        return $this->showOne($worksOn);
    }
}
