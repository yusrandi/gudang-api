<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Form Tambah Data') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label class="control-label">Spesifikasi Barang<span class="text-danger">*</span></label>
            <div>
                <select class="custom-select" wire:model="klasifikasi_id">
                    <option value="">Please Choose</option>
                    @foreach ($klasifikasis as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('klasifikasi_id')
                    <small class="mt-2 text-danger">{{ $message }}</small>
                @enderror
            </div>

        </div>
        <div class="form-group">
            <label class="control-label">Nama Barang<span class="text-danger">*</span></label>
            <div>
                <select class="custom-select" wire:model="barang_id">
                    <option value="">Please Choose</option>
                    @foreach ($barangs as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <small class="mt-2 text-danger">{{ $message }}</small>
                @enderror
            </div>

        </div>
        <div class="form-group">
            <label class="control-label">Satuan Barang<span class="text-danger">*</span></label>
            <div>
                <select class="custom-select" wire:model="satuan_id">
                    <option value="">Please Choose</option>
                    @foreach ($satuans as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('satuan_id')
                    <small class="mt-2 text-danger">{{ $message }}</small>
                @enderror
            </div>

        </div>
        <div class="form-group">
            <label class="control-label">Harga Barang<span class="text-danger">*</span></label>

            <div class="input-group">
                <input wire:model="barang_price" autocomplete="off" required type="number" class="form-control"
                    placeholder="Masukkan Harga Barang">
                <span class="input-group-append" id="basic-addon3">
                    <label class="input-group-text">{{ $satuan }}</label>
                </span>


            </div>
            @error('barang_price')
                <small class="mt-2 text-danger">{{ $message }}</small>
            @enderror

        </div>
        <div class="form-group">
            <label>{{ __('Jumlah Barang') }}<span class="text-danger">*</span></label>
            <div class="input-group">
                <input wire:model="barang_qty" autocomplete="off" required type="number" class="form-control"
                    placeholder="Masukkan Jumlah Barang">
                <span class="input-group-append" id="basic-addon3">
                    <label class="input-group-text">{{ $satuan }}</label>
                </span>


            </div>
            @error('barang_qty')
                <small class="mt-2 text-danger">{{ $message }}</small>
            @enderror

        </div>

        @if ($isUpdate)
            <div class="form-group">
                <label>{{ __('Barang Tersedia') }}<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input wire:model="barang_sisa" autocomplete="off" required type="number" class="form-control"
                        placeholder="Masukkan Sisa Barang">
                    <span class="input-group-append" id="basic-addon3">
                        <label class="input-group-text">{{ $satuan }}</label>
                    </span>


                </div>
                @error('barang_sisa')
                    <small class="mt-2 text-danger">{{ $message }}</small>
                @enderror

            </div>
        @endif


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        <button wire:click="save" type="button" class="btn btn-primary">{{ __('Save changes') }}</button>
    </div>


</div>
