<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class PersediaanBarangB22Controller extends Controller
{
    
    public function exportPDF($klasifikasi_id, $filterTahun)
    {
        $haha = $klasifikasi_id;
        $monthStart = '01';
        $monthEnd = '12';
        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/31');

        $reports =  Report::with('penerimaan')
            ->orderBy('barang_id')
            // ->where(function ($query){
            
            //     if($klasifikasi_id != null){
            //         $query->Where('klasifikasi_id', $klasifikasi_id);
            //     }
            
            // })
            ->whereHas('penerimaan.barang', function($q) use($haha) {
            
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
        })
            ->WhereBetween('date', [$startDate, $endDate])
            ->get();

        $pdf = PDF::loadView('pdf.persediaan-barang-b22',[
            'tahun' => $filterTahun,
            'reports' => $reports,
            'count' => 0
        ]);
        $pdf->setPaper('Legal', 'landscape');
        return $pdf->download('PersediaanBarangB23.pdf');
    }
}
