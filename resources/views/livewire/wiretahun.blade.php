<div class="row">
    <!-- product and new customar start -->
    <div class="col-xl-12 col-md-6">
        <div class="card new-cust-card">
            <div class="card-header">
                <h3>{{ __('Dashboard') }}</h3>

            </div>
            <div class="card-block">
                <form class="forms-sample">
                    <label class="control-label">Tahun Priode<span class="text-danger">*</span></label>

                    <div class="row">

                        <div class="col-sm-4">

                            <select class="custom-select" wire:model="year">
                                @for ($i = $now; $i < $last; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('year')
                                <small class="mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <button wire:click="save" type="button" class="btn btn-primary"><i
                                    class="ik ik-save"></i>{{ __('Submit') }}</button>
                        </div>

                    </div>



                </form>
            </div>
        </div>
    </div>
</div>
