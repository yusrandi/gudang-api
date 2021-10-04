<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <style>
        @page {
            size: legal landscape
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
                <h4 style="text-align: center">DAFTAR HASIL PENGELUARAN BARANG MILIK DAERAH (DHPBMD)</h4>
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

                        <th class="center">{{ __('#') }}</th>
                        <th>{{ __('No Surat/Nota') }}</th>
                        <th>{{ __('Tanggal') }}</th>
                        <th>{{ __('Nama Barang') }}</th>
                        <th>{{ __('Jumlah') }}</th>
                        <th>{{ __('Harga') }}</th>
                        <th>{{ __('Jumlah Barang') }}</th>
                        <th>{{ __('Penerima') }}</th>
                        <th>{{ __('Unit/Bagian') }}</th>
                    </tr>


                </thead>
                <tbody>

                    @foreach ($pengeluarans as $index => $item)
                        @foreach ($item as $key => $i)
                            @php
                                $count++;
                            @endphp
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $loop->iteration == 1 ? $index : '' }}</td>
                                <td>{{ $loop->iteration == 1 ? $i->date : '' }}</td>
                                <td>{{ $i->penerimaan->barang->name }}</td>
                                <td>{{ $i->qty . ' ' . $i->penerimaan->satuan->name }}</td>
                                <td>Rp. {{ number_format($i->penerimaan->barang_price) }}</td>
                                <td>Rp. {{ number_format($i->penerimaan->barang_price * $i->qty) }}</td>
                                <td>{{ $i->penerima }}</td>
                                <td>{{ $i->bagian->name }}</td>

                            </tr>
                        @endforeach
                    @endforeach



                </tbody>

            </table>
        </div>

    </div>

</body>

</html>
