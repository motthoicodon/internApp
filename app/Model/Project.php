<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'name',
        'information',
        'deadline',
        'type',
        'status'
    ];

    const TYPES = ['lab', 'single', 'acceptance'];
    const STATUS = ['planned', 'onhold', 'doing', 'done','cancelled'];


}
