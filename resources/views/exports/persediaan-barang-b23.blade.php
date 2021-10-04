<table class="table table-bordered table-hover mb-0 text-nowrap">
    <thead>
        <tr>
            <th>{{ __('#') }}</th>
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
