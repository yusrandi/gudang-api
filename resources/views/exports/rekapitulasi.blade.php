<table class="table table-bordered table-hover mb-0 text-nowrap">
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
