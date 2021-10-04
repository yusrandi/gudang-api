<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ url('storage/photos_thumb', $oldPhoto) }}" class="rounded-circle" width="150" />
                    <h4 class="card-title mt-10">{{ $name }}</h4>
                    <p class="card-subtitle">
                        {{ $level == '1' ? ($level == '1' ? 'Admin' : 'Staff') : ($level == '2' ? 'Staff' : 'Manager') }}
                    </p>

                </div>
            </div>
            <hr class="mb-0">
            <div class="card-body">
                <small class="text-muted d-block">{{ __('Email address') }} </small>
                <h6>{{ $email }}</h6>

                <small class="text-muted d-block pt-30">{{ __('Social Profile') }}</small>
                <br />
                <button class="btn btn-icon btn-facebook"><i class="fab fa-facebook-f"></i></button>
                <button class="btn btn-icon btn-twitter"><i class="fab fa-twitter"></i></button>
                <button class="btn btn-icon btn-instagram"><i class="fab fa-instagram"></i></button>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div aria-labelledby="pills-setting-tab">
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="example-name">{{ __('Full Name') }}</label>
                            <input wire:model="name" type="text" placeholder="Johnathan Doe" class="form-control"
                                name="example-name" id="example-name">

                            @error('name')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="example-email">{{ __('Email') }}</label>
                            <input wire:model="email" type="email" placeholder="johnathan@admin.com"
                                class="form-control" name="example-email" id="example-email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="example-password">{{ __('New Password ?') }}</label>
                            <input wire:model="password" type="password" class="form-control"
                                autocomplete="new-password">
                            @error('password')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-name">{{ __('Photo') }}</label>
                            <input wire:model="photo" type="file" class="form-control">
                        </div>

                        <button wire:click="update" class="btn btn-success" type="button">Update Profile</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
