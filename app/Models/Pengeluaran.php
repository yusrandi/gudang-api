<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function penerimaan()  
    {
        return $this->belongsTo(Penerimaan::class)->with(['barang','satuan','rekanan']);
    }
    public function bagian()  
    {
        return $this->belongsTo(Bagian::class);
    }
    public static function pengeluarans($klasifikasi_id, $filterBagianId)
    {
        $haha = $klasifikasi_id;
        $bagianId = $filterBagianId;

        if ($bagianId != null) {
            return Pengeluaran::with(['penerimaan','bagian'])
                    ->orderBy('date')
                    ->where('bagian_id', $filterBagianId)
                    ->whereHas('penerimaan.barang', function($q) use($haha) {
                        if($haha != null){
                            $q->where('klasifikasi_id', $haha);
                        }
                    })
                    ->get();
        } else {
            return Pengeluaran::with(['penerimaan','bagian'])
                    ->orderBy('date')
                    ->whereHas('penerimaan.barang', function($q) use($haha) {
                        if($haha != null){
                            $q->where('klasifikasi_id', $haha);
                        }
                    })
                    ->get();
                    
                }
    }
}
