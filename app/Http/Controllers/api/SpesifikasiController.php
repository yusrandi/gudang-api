<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Klasifikasi;
use Illuminate\Http\Request;

class SpesifikasiController extends Controller
{
    //
    public function index()
    {
        return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Selamat datang',
                'klasifikasi' => Klasifikasi::orderBy('name','ASC')->get()
        ], 201);
    }
}
