<div class="card">
    <div class="card-body">
        <div class="form-group">
            <h5>{{ $data['fields']['parent_id'] }} <span class="text-danger">(*)</span></h5>
            <div class="controls">
                <select name="province_id" id="province_id" class="select2 selectpicker location" style="width: 100%; height:36px;" data-target="district">
                    <option value="0">-- Root --</option>
                    @if (isset($data['provinces']))
                        @foreach ($data['provinces'] as $province)
                        <option {{ old('province_id', isset($data['user']->province_id) && $data['user']->province_id == $province['code'] ) ? 'selected':'' }} value="{{ $province['code'] }}">{{ $province['full_name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group">
            <h5>{{ $data['fields']['image'] }} <span class="text-danger">(*)</span></h5>
            <div class="controls text-center">
                <span class="img img-cover img-target"><img src="{{ asset('backend/images/not-found.jpg') }}" alt="image sa" style="max-width:100%"></span>
                <input type="hidden" value="{{ old('image',$data['postCatalogues']->image ?? null) }}" name="image" class="form-control upload-image-avartar @error('canonical') form-control-danger @enderror">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">

        <div class="form-group">
            <h5>{{ $data['fields']['lft'] }} </h5>
            <div class="controls">
                <input type="text" id="ckfinder-widget" name="image" value="{{ old('image',$data['postCatalogues']->image ?? null) }}" class="form-control upload-image" data-upload="Images">
            </div>
        </div>

        <div class="form-group">
            <h5>{{ $data['fields']['public'] }} <span class="text-danger">(*)</span></h5>
            <div class="controls switchery-demo m-b-30">
                <input name="status" @if ((isset($data['postCatalogues']->public) && $data['postCatalogues']->public) || $segment ='create') checked @endif  type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
            </div>
        </div>
    </div>
</div>