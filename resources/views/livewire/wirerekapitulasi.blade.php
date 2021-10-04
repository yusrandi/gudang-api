<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>{{ __('Data Rekapitulasi') }}</h3>
            </div>
            <div class="card-body template-demo">
                {{-- <button wire:click="create" type="button" class="btn btn-success">{{ __('Tambah Data') }}</button> --}}

                <div class="form-group row">

                    <div class="col-sm-3">
                        <select wire:model="filterTahun" class="custom-select">
                            {{ $last = date('Y') - 20 }}
                            {{ $now = date('Y') }}
                            <option value="{{ $now }}">pilih Tahun</option>

                            @for ($i = $now; $i >= $last; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>


                    <div class="col-sm-3">
                        <select wire:model="klasifikasi_id" class="custom-select">
                            <option value="">pilih Spesifikasi</option>

                            @foreach ($klasifikasis as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-sm-6 row">
                        <button wire:click="exportToPdf" type="button" class="btn btn-info text-center"
                            style="height: 40px"><i class="ik ik-printer"></i>{{ __('Cetak Data') }}</button>
                        <button wire:click="exportToExcel" type="button" class="btn btn-primary text-center"
                            style="height: 40px"><i class="ik ik-printer"></i>{{ __('Export Data') }}</button>
                    </div>
                </div>

                <div class="table-responsive">
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
                </div>
            </div>
        </div>

    </div>

</div>
