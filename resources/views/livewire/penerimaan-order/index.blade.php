<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h3>{{ __('Tambah Penerimaan') }}</h3>
                </div> --}}
                <div class="card-body template-demo">

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>Nomor SPK/Perjanjian/Kontrak</label>

                            <input type="text" class="form-control datetimepicker-input"
                                placeholder="Nomor SPM/DPA/Kwitansi" wire:model="spk_no"
                                {{ $isUpdate ? 'readonly' : '' }}>
                            @error('spk_no')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="col-sm-4">
                            <label>Tanggal SPK/Perjanjian/Kontrak<span class="text-danger">*</span></label>
                            <div wire:ignore class="date" id="appointmentDate" data-target-input="nearest"
                                data-appointmentdate="@this">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#appointmentDate" id="appointmentDateInput"
                                    data-toggle="datetimepicker" placeholder="Tanggal SPK/Perjanjian/Kontrak">
                            </div>

                            <small class="mt-2 text-muted">{{ $spk_date_label }}</small>

                            @error('spk_date')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-sm-4">
                            <label for="formFile" class="form-label">File SPK/Perjanjian/Kontrak<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="formFile" wire:model="spk_file">
                            @error('spk_file')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>Nomor SPM/DPA/Kwitansi</label>
                            <input type="text" class="form-control datetimepicker-input"
                                placeholder="Nomor SPM/DPA/Kwitansi" wire:model="spm_no">
                            @error('spm_no')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label>Tanggal SPM/DPA/Kwitansi<span class="text-danger">*</span></label>
                            <div wire:ignore class="date" id="appointmentDatee" data-target-input="nearest"
                                data-appointmentdatee="@this">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#appointmentDatee" id="appointmentDateeInput"
                                    data-toggle="datetimepicker" placeholder="Tanggal SPM/DPA/Kwitansi">
                            </div>

                            @error('spm_date')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="formFile" class="form-label">File SPM/DPA/Kwitansi<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="formFile" wire:model="spm_file">
                            @error('spm_file')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                    </div>
                    <div class="form-group row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Nama Vendor<span class="text-danger">*</span></label>
                                <div>
                                    <select class="custom-select" wire:model="rekanan_id">
                                        <option>Please Choose</option>
                                        @foreach ($rekanans as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('rekanan_id')
                                    <small class="mt-2 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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
                                    <th {{ $isUpdate ? '' : 'hidden' }}>{{ __('Barang Tersedia') }}</th>
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
                                        <td {{ $isUpdate ? '' : 'hidden' }}>
                                            {{ $item->barang_sisa . ' ' . $item->satuan->name }}</td>
                                        <td class="text-right">
                                            <i wire:click="selectedItem({{ $item->id }},'update')"
                                                class="ik ik-check f-16 mr-10 text-green" style="cursor: pointer"></i>
                                            <i wire:click="selectedItem({{ $item->id }},'delete')"
                                                class="ik ik-x f-16 text-red" style="cursor: pointer"></i>
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
                        <div class="modal-dialog modal-dialog-centered" role="document">

                            @livewire('penerimaan-order.create',['isUpdate'=> $isUpdate])

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
