<div class="row">
    <!-- product and new customar start -->
    <div class="col-xl-4 col-md-6">
        <div class="card new-cust-card">
            <div class="card-header">
                <h3>{{ __('Tambah Bagian') }}</h3>
                <div class="card-header-right">

                </div>
            </div>
            <div class="card-block">
                <form class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputUsername1">{{ __('Nama Bagian') }}</label>
                        <input wire:model="name" autocomplete="off" required type="text" class="form-control"
                            placeholder="Input Nama Bagian">

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

            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Nama Bagian') }}</th>
                                <th class="text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bagians as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
