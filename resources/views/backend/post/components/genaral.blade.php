
<div class="card">
    <div class="card-header text-primary font-bold"> {{ __('messages.generalTitle') }}</div>
    <div class="card-body">
        <div class="form-group @if($errors->has('name'))error @endif">
            <h5>{{ $data['fields']['name'] }} <span class="text-danger">(*)</span></h5>
            <div class="controls">
                <input type="text" name="name" value="{{ old('name', $data['post']->name ?? null) }}" class="form-control nameforSlug" required data-validation-required-message="This field is required">
                @if($errors->has('name'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('name') }}</li></ul></div>
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('description'))error @endif">
            <h5>{{ $data['fields']['description'] }} <span class="text-danger">(*)</span></h5>
            <div class="controls">
                <textarea type="text" name="description" class="form-control ck-editor" id="ck_description" data-height="200">{{ old('description', $data['post']->description ?? null) }}</textarea>
                @if($errors->has('description'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('description') }}</li></ul></div>
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('content'))error @endif">
            <h5>{{__('messages.content') }} <span class="text-danger">(*)</span> <a href="javascript:void(0)" class="pull-right multipleUploadImageCkeditor" data-target="ckContent">Upload Nhiều hình ảnh</a></h5>
            <div class="controls">
                <textarea type="text" name="content"class="form-control ck-editor" id="ckContent" data-height="500">{{ old('content', $data['post']->content ?? null) }}</textarea>
                @if($errors->has('content'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('content') }}</li></ul></div>
                @endif
            </div>
        </div>
    </div>
</div>