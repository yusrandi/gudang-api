<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class RekapitulasiController extends Controller
{
    //
    public function index()
    {
        // return Report::with('penerimaan')
        //     ->orderBy('date')
        //     ->get()->sortby('penerimaan.barang_id');
        return view('pages.rekapitulasi');
    }

    public function exportToPDF($klasifikasi_id, $filterTahun)
    {
        $haha = $klasifikasi_id;
        $monthStart = '01';
        $monthEnd = '12';
        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/31');

        $reports =  Report::rekapitulasi($haha, $startDate, $endDate)
            ->groupBy('penerimaan_id');

        $pdf = PDF::loadView('pdf.rekapitulasi',[
            'tahun' => $filterTahun,
            'reports' => $reports,
            'count' => 0
        ]);
        $pdf->setPaper('Legal', 'landscape');
        return $pdf->download('rekapitulasi.pdf');
    }
}
