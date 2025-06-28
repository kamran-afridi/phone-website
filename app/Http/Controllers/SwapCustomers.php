<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwapCustomers extends Controller
{
    public function swapCustomers()
    {
        return view('Swap.swapCustomers');
    }
}
