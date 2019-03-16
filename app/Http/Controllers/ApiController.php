<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponser;
  
     protected function paginate(Collection $collection){

          $page = LengthAwarePaginator::resolveCurrentPage();

          $perPage = 10;

          $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();

          $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
              'path' => LengthAwarePaginator::resolveCurrentPath()
          ]);

          $paginated->appends(request()->all());

          return $paginated;
      }
}
