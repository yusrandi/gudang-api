<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.pengeluaran');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.pengeluaran-order');
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
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
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
        
        $pengeluarans =  Pengeluaran::pengeluarans($haha, null)
                ->WhereBetween('date', [$startDate, $endDate])
                ->groupBy('nota_no');

        $pdf = PDF::loadView('pdf.pengeluaran',[
            'tahun' => $filterTahun,
            'pengeluarans' => $pengeluarans,
            'count' => 0
        ]);
        $pdf->setPaper('Legal', 'landscape');
        return $pdf->download('pengeluaran.pdf');
    }
}
