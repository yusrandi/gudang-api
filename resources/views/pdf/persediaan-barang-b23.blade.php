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
                <h4 style="text-align: center">KARTU PERSEDIAAN BARANG</h4>


                <p>
                    <label style="margin-right: 65px">GUDANG</label>
                    <label>: Sekretariat DPRD Prov Sul Sel</label>
                </p>
                <p>
                    <label style="margin-right: 40px">SPESIFIKASI</label>
                    <label>: {{ $spesifikasi_nama }}</label>
                </p>

            </div>

            <table id="table">
                <thead>
                    <tr>
                        <th width="10">{{ __('#') }}</th>
                        <th>{{ __('TANGGAL') }}</th>
                        <th>{{ __('JENIS BARANG') }}</th>
                        <th width="10">{{ __('MASUK') }}</th>
                        <th width="10">{{ __('KELUAR') }}</th>
                        <th width="10">{{ __('SISA') }}</th>
                        <th>{{ __('HARGA SATUAN') }}</th>
                        <th>{{ __('BERTAMBAH') }}</th>
                        <th>{{ __('BERKURANG') }}</th>
                        <th>{{ __('SISA') }}</th>
                        <th>{{ __('KET') }}</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($reports as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->penerimaan->barang->name }}</td>
                            <td>{{ $item->status == 1 ? $item->qty : '0' }}</td>
                            <td>{{ $item->status == 1 ? '0' : $item->qty }}</td>
                            <td>{{ $item->sisa }}</td>
                            <td>Rp. {{ number_format($item->penerimaan->barang_price) }}</td>
                            <td>{{ $item->status == 1 ? 'Rp. ' . number_format($item->qty * $item->penerimaan->barang_price) : '0' }}
                            </td>
                            <td>{{ $item->status == 1 ? '0' : 'Rp. ' . number_format($item->qty * $item->penerimaan->barang_price) }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
