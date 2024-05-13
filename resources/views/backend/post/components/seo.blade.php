<div class="card">
    <div class="card-header text-primary font-bold">{{ __('messages.configSeo') }}</div>
    
    <div class="card-body">
     
        <div class="seo-container mb-2">
            <div class="seo-header">
                <div class="icon pull-left">
                    <img class="XNo5Ab" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAAAdVBMVEUaeQAPdgBJjT9WlE5TkkssgR0AbQAAcADW49T////5+/i50LY6hi7P3s2sx6js8evA074AXQAAVQBeilji6eFllF8gaREXZAEAUQDT3tIaewAMYQAqbB4YbAEAVwB7nXYAWwCuwquXsZS2x7MzcSlFhjxRgUoe9WyvAAAAqUlEQVR4AWKgKQD0RRcJDAIxAEVxdwvucP8jtozUkvI3yENGVBFpms4yTMtGD9iOK/L8wP7F0H0XWTfoOhaBcSw0sTCmWZYXTEsVYQWQ1s11VqQtgdCBe9UPLYEwslen1G4JnJfrdE1BbW+QK/1ZeOovdh0fUHc9+GcqGVzRi5B3DMnl2zJAKGuY0bhIA7TZ2z7DNyrHyauyuYNfVKzuigHGdgCcghQjrQ+1/R9lllZzRAAAAABJRU5ErkJggg==" style="height:26px;width:26px" alt="">
                </div>
                <div class="meta-canonical">
                    <div class="title-web">Báo Dân trí</div>
                    <div class="title-canonical clearfix"><a class="canonical" href="https://">https://</a></div>
                </div>
                <br>
            </div>
            <h3 class="meta_title">Bạn chưa có tiêu đề</h3>
            <div class="meta_description">Bạn chưa có mô tả SEO</div>
        </div>
        <div class="b-b mb-2"></div>
        <div class="form-group @if($errors->has('meta_title'))error @endif">
            <h5>{{__('messages.meta_title') }} <span class="text-danger">(*)</span></h5>
            <div class="controls">
                <input type="text" value="{{ old('meta_title', $data['post']->meta_title ?? null) }}" name="meta_title" class="form-control @error('meta_title') form-control-danger @enderror" required>
                @if($errors->has('meta_title'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('meta_title') }}</li></ul></div>
                @endif
            </div>
        </div>
        <div class="form-group @if($errors->has('canonical'))error @endif">
            <h5>{{__('messages.canonical') }} <span class="text-danger">(*)</span></h5>
           
            <div class="controls">
                <input type="text" value="{{ old('canonical', $create ? null: optional($data['post']->routes)->canonical) }}" name="canonical" class="form-control slugName @error('canonical') form-control-danger @enderror" required>
                @if($errors->has('canonical'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('canonical') }}</li></ul></div>
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('meta_keyword'))error @endif"">
            <h5>{{__('messages.meta_keyword') }} <span class="text-danger">(*)</span></h5>
            <div class="controls">
                <input type="text" value="{{ old('meta_keyword', $data['post']->meta_keyword ?? null) }}" name="meta_keyword" class="form-control @error('meta_keyword') form-control-danger @enderror">
                @if($errors->has('meta_keyword'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('meta_keyword') }}</li></ul></div>
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('meta_description'))error @endif"">
            <h5>{{__('messages.meta_description') }} <span class="text-danger">(*)</span> <span class="pull-right">0 ký tự</span></h5>
            <div class="controls">
                <textarea type="text" name="meta_description" class="form-control" id="ck_meta_description" rows="8">{{ old('meta_description', $data['post']->meta_description ?? null) }}</textarea>
                @if($errors->has('meta_description'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('meta_description') }}</li></ul></div>
                @endif
            </div>
        </div>

</div>
</div>