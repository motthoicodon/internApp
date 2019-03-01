<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
