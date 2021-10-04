<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Form Tambah Pengeluaran') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body">

        <div class="form-group">
            <label class="control-label">Spesifikasi Barang<span class="text-danger">*</span></label>
            <div>
                <select class="form-control" wire:model="klasifikasi_id">
                    <option>Please Choose</option>
                    @foreach ($klasifikasis as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
            </div>
            @error('klasifikasi_id')
                <small class="mt-2 text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label class="control-label">Nama Barang<span class="text-danger">*</span></label>
            <div>
                <select class="form-control" wire:model="barang_id">
                    <option>Please Choose</option>
                    @foreach ($barangs as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('barang_id')
                <small class="mt-2 text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-nowrap">
                <thead>
                    <tr style="height: 10px">
                        <th>{{ __('Nomor Kontrak') }}</th>
                        <th>{{ __('Jenis Barang') }}</th>
                        <th>{{ __('Harga Barang') }}</th>
                        <th>{{ __('Sisa Barang') }}</th>
                        <th class="text-right">{{ __('Jumlah') }}</th>

                        <th class="text-right">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($datas as $index => $item)
                        <tr>
                            <td>
                                <label for=""> {{ $item->spk_no }} </label>
                            </td>
                            <td>
                                <label for=""> {{ $item->barang->name }} </label>
                            </td>
                            <td>
                                <label for=""> {{ $item->barang_price }} </label>
                            </td>
                            <td>
                                <label for=""> {{ $item->barang_sisa }} </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Masukkan Total Barang"
                                    wire:model="qty.{{ $index }}">
                                @error('qty.' . $index) <span
                                    class="text-danger error">{{ $message }}</span>@enderror
                            </td>

                            <td class="text-right">
                                <i wire:click="selectedItem({{ $item->id }},{{ $index }})"
                                    class="ik ik-check f-16 mr-10 text-green" style="cursor: pointer"></i>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        {{-- <button wire:click="save" type="button" class="btn btn-primary">{{ __('Save changes') }}</button> --}}
    </div>


</div>
