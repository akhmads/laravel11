<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\HasFilter;

class SalesInvoice extends Model
{
    use HasFactory, HasUuids, HasFilter;

    protected $table = 'sales_invoice';
    protected $guarded = [];
    protected $keyType = 'string';
}
