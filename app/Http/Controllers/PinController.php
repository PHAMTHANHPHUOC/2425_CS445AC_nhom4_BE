<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinController extends Controller
{
    public function MaPin()
    {
        $pin = '';
        for ($i = 0; $i < 6; $i++) {
            $pin .= mt_rand(0, 9);
        }
        return $pin;
    }
}
