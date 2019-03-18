<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/members' , 'AdminController@showMember');
Route::get('/admin/projects' , 'AdminController@showProject');

Route::get('/test', function (){

    $member = \App\Member::where('id', '>', 0)->get();

    $pageSize = 10;

    $result = $member->slice(1 * $pageSize, $pageSize)->values();

    $resultWhere = $member->search('id', 1)->all();

    echo '<pre>';
    print_r($page = \Illuminate\Pagination\Paginator::resolveCurrentPage());
    echo '</pre>';

    echo '<pre>';
    print_r($page = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage());
    echo '</pre>';

    return response()->json(['data' => $resultWhere], 200);

});