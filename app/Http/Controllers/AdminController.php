<?php

namespace App\Http\Controllers;

use App\Model\Member;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showMember(){
        return view('admin.member-show');
    }

    public function showProject(){

    }
}
