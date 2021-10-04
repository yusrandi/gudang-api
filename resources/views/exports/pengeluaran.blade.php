<table class="table table-bordered table-hover mb-0 text-nowrap">
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
