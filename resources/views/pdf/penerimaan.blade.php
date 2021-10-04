<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <style>
        @page {
            size: legal landscape
            /*size: 136pt 136pt;*/
        }

        #table {
            width: 100%;
            border-collapse: collapse;
        }

        #table td,
        #table th {
            font-size: 11px;
            border: 1px solid #ddd;
            padding: 8px;

        }

        #label {

            margin-top: 16px;
            line-height: 1px;
            margin-bottom: 16px;
        }

    </style>
</head>

<body class="antialiased">
    <div class="row">
        <div class="col-md-12">


            <div id="label">
                <h4 style="text-align: center">DAFTAR HASIL PENGADAAN BARANG MILIK DAERAH (DHPBMD)</h4>
                <h4 style="text-align: center">SEMESTER I dan II : (JANUARI S/D DESEMBER {{ $tahun }})</h4>


                <p>
                    <label style="margin-right: 80px">SKPD</label>
                    <label>: Sekretariat DPRD Prov Sul Sel</label>
                </p>
                <p>
                    <label style="margin-right: 38px">KAB/KOTA</label>
                    <label>: Makassar</label>
                </p>
                <p>
                    <label style="margin-right: 47px">PROVINSI</label>
                    <label>: Sulawesi Selatan</label>
                </p>


            </div>

            <table id="table">
                <thead>
                    <tr style="height: 10px">

                        <th rowspan="2" class="center">{{ __('#') }}</th>
                        <th rowspan="2">{{ __('JENIS BARANG DIBELI') }}</th>
                        <th colspan="2">{{ __('SPK/PERJANJIAN/KONTRAK') }}</th>
                        <th colspan="2">{{ __('DPA/SPM/KWITANSI') }}</th>
                        <th colspan="4">{{ __('JUMLAH') }}</th>
                        <th rowspan="2" class="text-right">{{ __('VENDOR') }}</th>

                    </tr>

                    <tr>
                        <th>{{ __('TANGGAL') }}</th>
                        <th>{{ __('NOMOR') }}</th>
                        <th>{{ __('TANGGAL') }}</th>
                        <th>{{ __('NOMOR') }}</th>
                        <th>{{ __('QTY') }}</th>
                        <th>{{ __('HARGA') }}</th>
                        <th>{{ __('TOTAL') }}</th>
                        <th>{{ __('SISA') }}</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($penerimaans as $index => $i)
                        @foreach ($i as $in => $item)
                            @php
                                $count++;
                            @endphp
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $item->barang->name }}</td>
                                <td>{{ $loop->iteration == 1 ? $item->spk_date : '' }}</td>
                                {{-- <td>{{ $item->spk_date }}</td> --}}
                                <td>{{ $loop->iteration == 1 ? $item->spk_no : '' }}</td>
                                {{-- <td>{{ $item->spk_no }}</td> --}}
                                <td>{{ $item->spm_date == 'spm' ? '' : $item->spm_date }}</td>
                                <td>{{ $item->spm_no == 'spm' ? '' : $item->spm_no }}</td>
                                <td>{{ $item->barang_qty . ' ' . $item->satuan->name }}</td>
                                <td>Rp. {{ number_format($item->barang_price) }}</td>
                                <td>Rp. {{ number_format($item->barang_price * $item->barang_qty) }}</td>
                                <td>{{ $item->barang_sisa . ' ' . $item->satuan->name }}</td>

                                <td>{{ $item->rekanan->name }}</td>

                            </tr>
                        @endforeach
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>

</body>

</html>
