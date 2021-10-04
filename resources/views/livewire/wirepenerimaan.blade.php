<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if (auth()->user()->level != 3)
                    <button wire:click="create" type="button" class="btn btn-success mr-3 text-center"><i
                            class="ik ik-plus-circle text-center"></i>{{ __('Tambah Data') }}</button>
                    {{-- <h3>{{ __('Data Penerimaan') }}</h3> --}}
                @endif

                <button wire:click="exportToPdf" type="button" class="btn-sm btn-info mr-3"><i
                        class="ik ik-printer"></i>{{ __('Cetak Data') }}</button>

                <button wire:click="exportToExcel" type="button" class="btn-sm btn-primary text-center"><i
                        class="ik ik-printer"></i>{{ __('Export Data') }}</button>
            </div>
            <div class="card-body template-demo">
                {{-- <button wire:click="create" type="button" class="btn btn-success">{{ __('Tambah Data') }}</button> --}}

                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="form-group row">

                    <div class="col-sm-4">
                        <select wire:model="filterTahun" class="custom-select">
                            {{ $last = date('Y') - 20 }}
                            {{ $now = date('Y') }}
                            <option value="{{ $now }}">pilih Tahun</option>

                            @for ($i = $now; $i >= $last; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <select wire:model="filterSemester" class="custom-select">
                            <option value="01,12">pilih Tahun</option>
                            <option value="01,12">1 Tahun</option>
                            <option value="01,06">Semester I</option>
                            <option value="07,12">Semester II</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select wire:model="filterKatid" class="custom-select">
                            <option value="">pilih Kategori</option>

                            @foreach ($klasifikasis as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                        <thead>
                            <tr style="height: 10px">

                                <th rowspan="2" class="center">{{ __('#') }}</th>
                                <th rowspan="2">{{ __('JENIS BARANG DIBELI') }}</th>
                                <th colspan="2">{{ __('SPK/PERJANJIAN/KONTRAK') }}</th>
                                <th colspan="2">{{ __('DPA/SPM/KWITANSI') }}</th>
                                <th colspan="4">{{ __('JUMLAH') }}</th>
                                <th rowspan="2" class="text-right">{{ __('VENDOR') }}</th>
                                <th rowspan="2" class="text-right">{{ __('AKSI') }}</th>
                            </tr>

                            <tr>
                                <th>{{ __('TANGGAL') }}</th>
                                <th>{{ __('NOMOR') }}</th>
                                <th>{{ __('TANGGAL') }}</th>
                                <th>{{ __('NOMOR') }}</th>
                                <th>{{ __('QTY') }}</th>
                                <th>{{ __('HARGA') }}</th>
                                <th>{{ __('TOTAL') }}</th>
                                <th>{{ __('SISA') }}</th>
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
                                        <td class="text-right">
                                            <i wire:click="selectedItem({{ $item->id }},'update')"
                                                class="ik ik-edit f-16 mr-15 text-green" style="cursor: pointer"></i>
                                            <i wire:click="selectedItem({{ $item->id }},'delete')"
                                                class="ik ik-trash-2 f-16 text-red" style="cursor: pointer"></i>
                                        </td>
                                    </tr>
                                @endforeach

                            @endforeach




                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
