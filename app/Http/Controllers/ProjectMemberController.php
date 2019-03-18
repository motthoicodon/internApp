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
     * @param  \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Member $member)
    {
        //
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
