<div class="row">
    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <h3>{{ __('Data Penerimaan') }}</h3>
            </div> --}}
            <div class="card-body template-demo">

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

                                    @php
                                        if ($barang_id == $item->barang_id) {
                                            if ($item->status == 1) {
                                                $sisa += $item->qty;
                                            } else {
                                                $sisa -= $item->qty;
                                            }
                                        } else {
                                            $sisa = $item->qty;
                                        }
                                        
                                    @endphp
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->penerimaan->barang->name }}</td>
                                    <td>{{ $item->status == 1 ? $item->qty : '0' }}</td>
                                    <td>{{ $item->status == 1 ? '0' : $item->qty }}</td>
                                    <td>{{ $sisa }}</td>
                                    <td>Rp. {{ number_format($item->penerimaan->barang_price) }}</td>
                                    <td>{{ $item->status == 1 ? 'Rp. ' . number_format($item->qty * $item->penerimaan->barang_price) : '0' }}
                                    </td>
                                    <td>{{ $item->status == 1 ? '0' : 'Rp. ' . number_format($item->qty * $item->penerimaan->barang_price) }}
                                    </td>
                                    <td>{{ 'Rp. ' . number_format($sisa * $item->penerimaan->barang_price) }}</td>
                                    <td></td>

                                    @php
                                        $barang_id = $item->barang_id;
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
