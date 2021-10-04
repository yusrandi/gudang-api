<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    
    public function penerimaan(Request $request)
    {
        // return $request;
        $spesifikasiId = $request->spesifikasi_id;
        $filterSemester = $request->semester;
        
        $filterTahun = $request->tahun;
        
        $splitMonth = explode(',', $filterSemester, 2);

        $monthStart = $splitMonth[0];
        $monthEnd = $splitMonth[1];

        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/28');
        
         

         return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Data Has Found',
                'penerimaan' => Penerimaan::penerimaans($spesifikasiId)
                ->WhereBetween('spk_date', [$startDate, $endDate])
                // ->groupBy('spk_no')
        ], 200);
    }
    public function pengeluaran(Request $request)
    {
        // return $request;
        $spesifikasiId = $request->spesifikasi_id;
        $filterSemester = $request->semester;
        $filterBagianId = $request->bagian_id;
        
        $filterTahun = $request->tahun;
        
        $splitMonth = explode(',', $filterSemester, 2);

        $monthStart = $splitMonth[0];
        $monthEnd = $splitMonth[1];

        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/28');
        
        $data = Pengeluaran::pengeluarans($spesifikasiId, $filterBagianId)
               
                ->WhereBetween('date', [$startDate, $endDate]);
         

        return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Data Has Found',
                'pengeluaran' => $data
            
        ], 200);
    }

    public function pb22(Request $request)
    {
        $haha = $request->klasifikasi_id;
        $filterTahun = $request->tahun;

        $monthStart = '01';
        $monthEnd = '12';
        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/28');
        
        $data =  Report::with('penerimaan')
            ->orderBy('barang_id')
            ->whereHas('penerimaan.barang', function($q) use($haha) {
            
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
        })
            ->WhereBetween('date', [$startDate, $endDate])
            ->get();

         return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Data Has Found',
                'pb22' => $data
            
        ], 200);
    }

    public function pb23(Request $request)
    {
        $monthStart = '01';
        $monthEnd = '12';
        $filterTahun = $request->tahun;

        $haha = $request->klasifikasi_id;

        $startDate = date($filterTahun.'/'.$monthStart.'/00');
        $endDate = date($filterTahun.'/'.$monthEnd.'/31');

        $data =  Report::with('penerimaan')
            ->orderBy('barang_id')
            ->whereHas('penerimaan.barang', function($q) use($haha) {
            
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
            })
            ->WhereBetween('date', [$startDate, $endDate])
            ->get();

        return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Data Has Found',
                'pb23' => $data
            
        ], 200);
    }

    public function rekapitulasi(Request $request)
    {
        
        $haha = $request->klasifikasi_id;
        $monthStart = '01';
        $monthEnd = '12';

        $startDate = date($request->filterTahun.'/'.$monthStart.'/00');
        $endDate = date($request->filterTahun.'/'.$monthEnd.'/31');

        $data =  Report::with('penerimaan')
            ->orderBy('barang_id')
            ->whereHas('penerimaan.barang', function($q) use($haha) {
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
            })
            ->WhereBetween('date', [$startDate, $endDate])
            ->get();

        return response()->json([
                'responsecode' => '1',
                'responsemsg' => 'Data Has Found',
                'rekapitulasi' => $data
        ], 200);
    }

}
