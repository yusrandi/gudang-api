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
                <h4 style="text-align: center">SEKRETARIAT DPRD</h4>
                <h4 style="text-align: center">REKAPITULASI PENERIMAAN DAN PENGELUARAN BARANG PERSEDIAAN</h4>
                <h4 style="text-align: center">PER 1 JANUARI s/d 31 DESEMBER {{ $tahun }}</h4>

            </div>

            <table id="table">
                <thead>
                    <tr style="height: 10px">

                        <th rowspan="2" class="center">{{ __('#') }}</th>
                        <th rowspan="2">{{ __('Jenis Barang yg Dibeli') }}</th>
                        <th colspan="3" class="text-center">{{ __('Saldo Tahun Lalu') }}</th>
                        <th colspan="3" class="text-center">{{ __('Penerimaan') }}</th>
                        <th colspan="3" class="text-center">{{ __('Pengeluaran') }}</th>
                        <th colspan="3" class="text-center">{{ __('Stok') }}</th>

                    </tr>

                    <tr>
                        <th>{{ __('Jumlah') }}</th>
                        <th>{{ __('Harga') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Jumlah') }}</th>
                        <th>{{ __('Harga') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Jumlah') }}</th>
                        <th>{{ __('Harga') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Jumlah') }}</th>
                        <th>{{ __('Harga') }}</th>
                        <th>{{ __('Total') }}</th>

                    </tr>

                </thead>
                <tbody>

                    @foreach ($reports as $index => $i)
                        @foreach ($i as $item)

                        @endforeach
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->penerimaan->barang->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $i->where('status', 1)->sum('qty') }}</td>
                            <td>Rp. {{ number_format($item->penerimaan->barang_price) }}</td>
                            <td>Rp.
                                {{ number_format($item->penerimaan->barang_price * $i->where('status', 1)->sum('qty')) }}
                            </td>
                            <td>{{ $i->where('status', 2)->sum('qty') }}</td>
                            <td>Rp. {{ number_format($item->penerimaan->barang_price) }}</td>
                            <td>Rp.
                                {{ number_format($item->penerimaan->barang_price * $i->where('status', 2)->sum('qty')) }}
                            </td>
                            <td>{{ $i->where('status', 1)->sum('qty') - $i->where('status', 2)->sum('qty') }}
                            </td>
                            <td>Rp. {{ number_format($item->penerimaan->barang_price) }}</td>
                            <td>Rp.
                                {{ number_format(($i->where('status', 1)->sum('qty') - $i->where('status', 2)->sum('qty')) * $item->penerimaan->barang_price) }}
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
