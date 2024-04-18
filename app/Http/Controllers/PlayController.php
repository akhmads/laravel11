<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HasCode;

class PlayController extends Controller
{
    use HasCode;

    public function index()
    {
        $code = $this->autoCode('INV/{Y}/{m}/{d}/{num}');
        return $code;
    }
}
