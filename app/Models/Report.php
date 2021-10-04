<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function penerimaan()  
    {
        return $this->belongsTo(Penerimaan::class)->with(['barang','satuan', 'rekanan']);
    }
    public function pengeluaran()  
    {
        return $this->belongsTo(Pengeluaran::class)->with(['barang','satuan', 'rekanan']);
    }
    
    public static function rekapitulasi($haha, $startDate, $endDate)
    {
         return Report::with('penerimaan')
            ->whereHas('penerimaan.barang', function($q) use($haha) {
            
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
            })
            ->WhereBetween('date', [$startDate, $endDate])
            ->get()->sortby('penerimaan.barang_id');

    }

}
