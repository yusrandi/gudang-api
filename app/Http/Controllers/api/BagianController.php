<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    
    public function index()
    {
        //
        return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Data Has Found',
                'bagian' => Bagian::orderby('name','ASC')->get()
                
                // ->groupBy('spk_no')
        ], 201);
    }

    
}
