<div class="form-group">
    <h5>{{ $data['fields']['name'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <input type="text" name="name" value="{{ old('name', $data['postCatalogues']->name ?? null) }}" class="form-control nameforSlug" required data-validation-required-message="This field is required">
    </div>
</div>


<div class="form-group">
    <h5>{{ $data['fields']['description'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <textarea type="text" name="description" value="{{ old('description', $data['postCatalogues']->description ?? null) }}" class="form-control ck-editor" required id="ck_description" data-height="200"></textarea>
    </div>
</div>

<div class="form-group">
    <h5>{{ $data['fields']['content'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <textarea type="text" name="content" value="{{ old('content', $data['postCatalogues']->content ?? null) }}" class="form-control ck-editor" required id="ck_content" data-height="500"></textarea>
    </div>
</div>