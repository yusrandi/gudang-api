<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersediaanBarang extends Controller
{
    public function indexB22()
    {
        return view('pages.persediaan-barang-b22');
    }
    public function indexB23()
    {
        return view('pages.persediaan-barang-b23');
    }
}
