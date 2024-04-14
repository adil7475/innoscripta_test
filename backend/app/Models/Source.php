<?php

namespace App\Models;

use App\Http\Filters\Baseline\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'sources';

    protected $guarded = [];
}
