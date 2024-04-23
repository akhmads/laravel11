<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Akhmads\Hyco\Traits\HasFilter;

class Example extends Model
{
    use HasFilter;

    protected $table = 'example';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
