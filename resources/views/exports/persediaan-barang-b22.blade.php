<table class="table table-bordered mb-0 text-nowrap">
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 text-nowrap">
            <thead>
                <tr>
                    <th colspan="6" class="text-center">
                        <label for="">KARTU BARANG</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" class="text-center">
                        <label for="">SEKRETARIAT DPRD PROVINSI SULAWESI SELATAN</label>
                    </th>
                </tr>
                <tr>
                    <th>{{ __('#') }}</th>
                    <th>{{ __('TANGGAL') }}</th>
                    <th>{{ __('JENIS BARANG') }}</th>
                    <th width="10">{{ __('MASUK') }}</th>
                    <th width="10">{{ __('KELUAR') }}</th>
                    <th width="10">{{ __('SISA') }}</th>
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
</table>
