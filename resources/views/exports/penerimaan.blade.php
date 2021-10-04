<table class="table table-bordered mb-0 text-nowrap">
    <thead>
        <tr>
            <th rowspan="2" class="center">{{ __('#') }}</th>
            <th rowspan="2">{{ __('JENIS BARANG DIBELI') }}</th>
            <th colspan="2">{{ __('SPK/PERJANJIAN/KONTRAK') }}</th>
            <th colspan="2">{{ __('DPA/SPM/KWITANSI') }}</th>
            <th colspan="4">{{ __('JUMLAH') }}</th>
            <th rowspan="2" class="text-right">{{ __('KET') }}</th>
        </tr>
        <tr>
            <th width="15">{{ __('TANGGAL') }}</th>
            <th width="15">{{ __('NOMOR') }}</th>
            <th width="10">{{ __('TANGGAL') }}</th>
            <th width="10">{{ __('NOMOR') }}</th>
            <th width="10">{{ __('QTY') }}</th>
            <th width="15">{{ __('HARGA') }}</th>
            <th width="15">{{ __('TOTAL') }}</th>
            <th width="10">{{ __('SISA') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($penerimaans as $index => $i)

            @foreach ($i as $item)
                @php
                    $count++;
                @endphp
                <tr>
                    <td>{{ $count }}</td>
                    {{-- <td>{{ $item->id }}</td> --}}
                    <td>{{ $item->barang->name }}</td>
                    <td>{{ $loop->iteration == 1 ? $item->spk_date : '' }}</td>
                    {{-- <td>{{ $item->spk_date }}</td> --}}
                    <td>{{ $loop->iteration == 1 ? $item->spk_no : '' }}</td>
                    {{-- <td>{{ $item->spk_no }}</td> --}}
                    <td>{{ $item->spm_date }}</td>
                    <td>{{ $item->spm_no }}</td>
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
