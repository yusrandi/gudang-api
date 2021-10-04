<div class="row">
    <!-- product and new customar start -->
    <div class="col-xl-4 col-md-6">
        <div class="card new-cust-card">
            <div class="card-header">
                <h3>{{ __('Tambah Barang') }}</h3>
                <div class="card-header-right">

                </div>
            </div>

            <div class="card-block">
                <form class="forms-sample">
                    <div class="form-group">
                        <label class="control-label">Spesifikasi Barang<span class="text-danger">*</span></label>

                        <select class="custom-select" wire:model="klasifikasi_id">
                            <option>Please Choose</option>
                            @foreach ($klasifikasis as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>

                        @error('klasifikasi_id')
                            <small class="mt-2 text-danger">{{ $message }}</small>
                        @enderror


                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">{{ __('Nama Barang') }}</label>
                        <input wire:model="name" autocomplete="off" required type="text" class="form-control"
                            placeholder="Input Nama Barang">

                        @if ($errors->has('name'))
                            <small class="mt-2 text-danger">{{ $errors->first('name') }}</small>
                        @endif
                    </div>

                    <button wire:click="save" type="button" class="btn btn-warning mr-2"><i
                            class="ik ik-save"></i>{{ __('Submit') }}</button>

                    <button class="btn btn-light">{{ __('Cancel') }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-md-6">
        <div class="card table-card">
            <div class="card-header">
                <h3>{{ __('Data Bagian') }}</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Klasifikasi Barang') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th class="text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->klasifikasi->name }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-right">
                                        <i wire:click="selectemItem({{ $item->id }},'update')"
                                            class="ik ik-edit f-16 mr-15 text-green" style="cursor: pointer"></i>
                                        <i wire:click="selectemItem({{ $item->id }},'delete')"
                                            class="ik ik-trash-2 f-16 text-red" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- product and new customar end -->

</div>
