<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if (auth()->user()->level != 3)
                    <button wire:click="create" type="button" class="btn btn-success mr-3 text-center"><i
                            class="ik ik-plus-circle text-center"></i>{{ __('Tambah Data') }}</button>
                @endif
                <button wire:click="exportToPdf" type="button" class="btn-sm btn-info mr-3"><i
                        class="ik ik-printer"></i>{{ __('Cetak Data') }}</button>

                <button wire:click="exportToExcel" type="button" class="btn btn-primary"><i
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
                        <select wire:model="filterSemester" class="custom-select">
                            <option value="01,12">pilih Priode</option>
                            <option value="01,12">1 Tahun</option>
                            <option value="01,06">Semester I</option>
                            <option value="07,12">Semester II</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select wire:model="filterKatid" class="custom-select">
                            <option value="">pilih Spesifikasi</option>

                            @foreach ($klasifikasis as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select wire:model="filterBagianId" class="custom-select">
                            <option value="">pilih Unit</option>

                            @foreach ($bagians as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach

                        </select>
                    </div>

                </div>


                <div class="table-responsive">
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
                                <th class="text-right">{{ __('Aksi') }}</th>
                            </tr>


                        </thead>
                        <tbody>

                            @foreach ($pengeluarans as $index => $item)
                                @foreach ($item as $key => $i)
                                    @php
                                        $count++;
                                        $total += $i->penerimaan->barang_price * $i->qty;
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
                                        <td class="text-right">
                                            <i wire:click="selectedItem({{ $i->id }},'update')"
                                                class="ik ik-edit f-16 mr-15 text-green" style="cursor: pointer"></i>
                                            <i wire:click="selectedItem({{ $i->id }},'delete')"
                                                class="ik ik-trash-2 f-16 text-red" style="cursor: pointer"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                            <td colspan="6" class="text-right title">
                                <h4><b>Total</b></h4>
                            </td>
                            <td><b>
                                    <h4>Rp. {{ number_format($total) }}</h4>
                                </b></td>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
