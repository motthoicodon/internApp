<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMemberRequest;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends ApiController
{
    private $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = $this->member->getAll();
        return $this->showAll($members);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMemberRequest $request)
    {
        $member = $this->member->store($request);
        return $this->showOne($member);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = $this->member->find($id);
        return $this->showOne($member);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
