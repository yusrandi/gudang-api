<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class PenerimaanController extends Controller
{
    

    public function index()
    {
        //
        return view('pages.penerimaan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.penerimaan-order');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function show(Penerimaan $penerimaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penerimaan $penerimaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penerimaan $penerimaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penerimaan $penerimaan)
    {
        //
    }

    public function printPdf($filterKatid, $filterSemester, $filterTahun)
    {
        $haha = $filterKatid;

        $splitMonth = explode(',', $filterSemester, 2);
        $monthStart = $splitMonth[0];
        $monthEnd = $splitMonth[1];
        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/31');
        
        $penerimaans =  Penerimaan::penerimaans($haha)
        ->WhereBetween('spk_date', [$startDate, $endDate])
        ->groupBy('spk_no');

        $pdf = PDF::loadView('pdf.penerimaan',[
            'tahun' => $filterTahun,
            'penerimaans' => $penerimaans,
            'count' => 0
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('penerimaan.pdf');
    }
}
