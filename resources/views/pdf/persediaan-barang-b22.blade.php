<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <style>
        @page {
            size: legal
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
                <h4 style="text-align: center">KARTU BARANG</h4>
                <h4 style="text-align: center">SEKRETARIAT DPRD PROVINSI SULAWESI SELATAN</h4>


                {{-- <p>
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
                </p> --}}


            </div>

            <table id="table">
                <thead>

                    <tr>
                        <th width="20">{{ __('#') }}</th>
                        <th>{{ __('TANGGAL') }}</th>
                        <th>{{ __('JENIS BARANG') }}</th>
                        <th width="20">{{ __('MASUK') }}</th>
                        <th width="20">{{ __('KELUAR') }}</th>
                        <th width="20">{{ __('SISA') }}</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
