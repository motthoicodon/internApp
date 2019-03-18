<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource(
    'projects',
    'ProjectController',
    ['except' => ['create', 'edit']]
);

Route::resource(
    'members',
    'MemberController',
    ['except' => ['create', 'edit']]
);

Route::resource(
    'workson',
    'WorksOnController',
    ['only' => ['store']]
);

Route::resource(
    'projects.members',
    'ProjectMemberController',
    ['only' => ['index', 'destroy', 'store']]
);
