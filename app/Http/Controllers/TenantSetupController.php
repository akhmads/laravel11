<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant\Tenant;
use App\Tenant\PrefixBase;

class TenantSetupController extends Controller
{
    public function create()
    {
        PrefixBase::up();
    }

    public function drop()
    {
        PrefixBase::down();
    }
}
