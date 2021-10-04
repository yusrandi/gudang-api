<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h3>{{ __('Tambah Pengeluaran') }}</h3>
                </div> --}}
                <div class="card-body template-demo">

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>Tanggal<span class="text-danger">*</span></label>
                            <div wire:ignore class="date" id="appointmentDate" data-target-input="nearest"
                                data-appointmentdate="@this">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#appointmentDate" id="appointmentDateInput"
                                    data-toggle="datetimepicker" placeholder="Tanggal Pengeluaran">
                            </div>

                            <small class="mt-2 text-muted">{{ $date_label }}</small>

                            @error('date')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-sm-4">
                            <label>Penanggung Jawab</label>

                            <input type="text" class="form-control datetimepicker-input" placeholder="Penanggung Jawab"
                                wire:model="penanggung" readonly>
                            @error('penanggung')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror

                        </div>


                        <div class="col-sm-4">
                            <label for="formFile" class="form-label">Nomor Surat/Nota<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control datetimepicker-input" placeholder="Nomor Surat/Nota"
                                wire:model="nota_no" {{ $isUpdate ? 'readonly' : '' }}>
                            @error('nota_no')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>Unit / Bagian</label>

                            <select class="custom-select" wire:model="bagian_id">
                                <option>Please Choose</option>
                                @foreach ($bagians as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
                            </select>

                            @error('bagian_id')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label>Penerima</label>

                            <input type="text" class="form-control datetimepicker-input" placeholder="Penerima"
                                wire:model="penerima">
                            @error('penerima')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="formFile" class="form-label">File Surat / Nota<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="formFile" wire:model="nota_file">
                            @error('nota_file')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                    </div>


                </div>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('Detail Barang') }}</h3>
                </div>
                <div class="card-body template-demo">

                    <button wire:click="create" type="button" class="btn btn-success text-right"><i
                            class="ik ik-plus-circle"></i>{{ __('Tambah Data') }}</button>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-nowrap">
                            <thead>
                                <tr style="height: 10px">
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Jenis Barang') }}</th>
                                    <th>{{ __('Satuan') }}</th>
                                    <th>{{ __('Harga Barang') }}</th>
                                    <th>{{ __('Jumlah Barang') }}</th>
                                    <th>{{ __('Total Barang') }}</th>
                                    <th class="text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->barang->name }}</td>
                                        <td>{{ $item->satuan->name }}</td>
                                        <td>Rp. {{ number_format($item->barang_price) }}</td>
                                        <td>{{ $item->barang_qty . ' ' . $item->satuan->name }}</td>
                                        <td>Rp. {{ number_format($item->barang_qty * $item->barang_price) }}</td>
                                        <td class="text-right">
                                            <i wire:click="selectedItem({{ $item->id }},'update')"
                                                class="ik ik-edit f-16 mr-15 text-green" style="cursor: pointer"></i>
                                            <i wire:click="selectedItem({{ $item->id }},'delete')"
                                                class="ik ik-trash-2 f-16 text-red" style="cursor: pointer"></i>
                                        </td>

                                        @php
                                            $total += $item->barang_qty * $item->barang_price;
                                        @endphp
                                    </tr>
                                @endforeach

                                <td colspan="5" class="text-right title">
                                    <h4><b>Total</b></h4>
                                </td>
                                <td><b>
                                        <h4>Rp. {{ number_format($total) }}</h4>
                                    </b></td>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button wire:click.prevent="submitall" type="button" class="btn btn-warning text-right mt-10"><i
                                class="ik ik-save"></i>{{ __('Submit All') }}</button>

                    </div>

                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">

                            @livewire('pengeluaran-order.create')

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
