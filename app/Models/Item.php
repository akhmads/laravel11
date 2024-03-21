<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFilter;

class Item extends Model
{
    use HasFactory, HasFilter;

    protected $table = 'item';
    protected $guarded = [];
}
