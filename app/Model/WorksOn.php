<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorksOn extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'works_on';

    const ROLES = ['dev', 'pl', 'pm', 'po', 'sm'];
}
