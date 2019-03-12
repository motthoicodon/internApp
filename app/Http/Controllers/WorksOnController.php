<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorksOnRequest;
use App\Member;
use App\Project;
use App\WorksOn;
use Illuminate\Http\Request;

class WorksOnController extends ApiController
{
    private $worksOn;

    public function __construct(WorksOn $worksOn)
    {
        $this->worksOn = $worksOn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateWorksOnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorksOnRequest $request)
    {
        $member = Member::findOrFail($request->member_id);
        $project = Project::findOrFail($request->project_id);

        if ($project->isExistMember($member)) {
            return $this->errorResponse('The member has been assigned into this project', 500);
        }

        $workson = WorksOn::create($request->all());
        return $this->showOne($workson);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
