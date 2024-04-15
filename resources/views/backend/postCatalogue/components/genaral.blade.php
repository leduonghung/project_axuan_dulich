<div class="form-group">
    <h5>{{ $data['fields']['name'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <input type="text" name="name" value="{{ old('name', $data['postCatalogue']->name ?? null) }}" class="form-control nameforSlug" required data-validation-required-message="This field is required">
    </div>
</div>

<div class="form-group">
    <h5>{{ $data['fields']['description'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <textarea type="text" name="description" class="form-control ck-editor" id="ck_description" data-height="200">{{ old('description', $data['postCatalogue']->description ?? null) }}</textarea>
    </div>
</div>

<div class="form-group">
    <h5>{{ $data['fields']['content'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <textarea type="text" name="content"class="form-control ck-editor" id="ck_content" data-height="500">{{ old('content', $data['postCatalogue']->content ?? null) }}</textarea>
    </div>
</div>