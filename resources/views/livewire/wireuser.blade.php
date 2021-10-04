<div class="row">
    <!-- product and new customar start -->
    <div class="col-xl-4 col-md-6">
        <div class="card new-cust-card">
            <div class="card-header">
                <h3>{{ __('Tambah User') }}</h3>

            </div>
            <div class="card-block">
                <form class="forms-sample">

                    <div class="form-group">
                        <label class="control-label">Level User<span class="text-danger">*</span></label>

                        <select class="custom-select" wire:model="level">
                            <option value="">Please Choose</option>
                            <option value="1">Admin</option>
                            <option value="2">Staff</option>
                            <option value="3">Pimpinan</option>
                        </select>
                        @error('level')
                            <small class="mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Foto User<span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="formFile" wire:model="photo">
                        @error('photo')
                            <small class="mt-2 text-danger">{{ $message }}</small>
                        @enderror

                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" width="100%">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">{{ __('Nama User') }}<span
                                class="text-danger">*</span></label>
                        <input wire:model="name" autocomplete="off" required type="text" class="form-control"
                            placeholder="Masukkan Nama User">
                        @error('name')
                            <small class="mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('Email User') }}<span class="text-danger">*</span></label>
                        <input wire:model="email" autocomplete="off" required type="text" class="form-control"
                            placeholder="Masukkan Email User" {{ $selectedItemId ? 'readonly' : '' }}>

                        @error('email')
                            <small class="mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password"
                            class="col-form-label text-md-right">{{ $selectedItemId ? 'New Password ?' : 'Passowrd' }}</label>

                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password" placeholder="Masukkan Password" wire:model="password">

                        @error('password')
                            <small class="mt-2 text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    <button wire:click="save" type="button" class="btn btn-warning mr-2"><i
                            class="ik ik-save"></i>{{ __('Submit') }}</button>

                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-md-6">
        <div class="card table-card">
            <div class="card-header">
                <h3>{{ __('Data User') }}</h3>

            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>

                                <th>{{ __('#') }}</th>
                                <th>{{ __('Picture') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Email Address') }}</th>
                                <th>{{ __('User Level') }}</th>

                                <th class="text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img class="rounded-circle"
                                            src="{{ url('storage/photos_thumb', $item->photo) }}" alt="Image"
                                            style="height: 50px; width: 50px;">

                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>

                                        <span
                                            class="badge label-table {{ $item->level == '1' ? ($item->level == '1' ? 'badge-primary' : 'badge-success') : ($item->level == '2' ? 'badge-danger' : 'badge-success') }}">{{ $item->level == '1' ? ($item->level == '1' ? 'Admin' : 'Staff') : ($item->level == '2' ? 'Staff' : 'Manager') }}</span>

                                    </td>
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
