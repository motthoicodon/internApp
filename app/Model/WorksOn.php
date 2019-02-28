<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorksOn extends Model
{

    protected $table = 'works_on';

    const ROLES = ['dev', 'pl', 'pm', 'po', 'sm'];
}
