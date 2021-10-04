<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function barang()  
    {
        return $this->belongsTo(Barang::class)->with('klasifikasi');
    }
    public function rekanan()  
    {
        return $this->belongsTo(Rekanan::class);
    }
    public function satuan()  
    {
        return $this->belongsTo(Satuan::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function penerimaans($klasifikasi_id)
    {
        $haha = $klasifikasi_id;
        
        return Penerimaan::with(['barang','rekanan','satuan'])
        ->orderBy('spk_date')
        ->whereHas('barang', function($q) use($haha) {
            
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
        })
        
        ->get();
    }

    public static function pengeluarans()
    {
        return Pengeluaran::orderBy('penerimaan_id')->get();
    }

    public function manypengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }
    public function manyreports()
    {
        return $this->hasMany(Report::class);
    }
}
