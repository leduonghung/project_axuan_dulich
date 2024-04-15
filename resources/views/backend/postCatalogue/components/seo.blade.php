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
<div class="form-group">
    <h5>{{ $data['fields']['meta_title'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <input type="text" value="{{ old('meta_title', $data['postCatalogue']->meta_title ?? null) }}" name="meta_title" class="form-control @error('meta_title') form-control-danger @enderror" required>
    </div>
</div>
<div class="form-group">
    <h5>{{ $data['fields']['canonical'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <input type="text" value="{{ old('canonical', $data['postCatalogue']->canonical ?? null) }}" name="canonical" class="form-control slugName @error('canonical') form-control-danger @enderror" required>
    </div>
</div>

<div class="form-group">
    <h5>{{ $data['fields']['meta_keyword'] }} <span class="text-danger">(*)</span></h5>
    <div class="controls">
        <input type="text" value="{{ old('meta_keyword', $data['postCatalogue']->meta_keyword ?? null) }}" name="meta_keyword" class="form-control @error('meta_keyword') form-control-danger @enderror">
    </div>
</div>

<div class="form-group">
    <h5>{{ $data['fields']['meta_description'] }} <span class="text-danger">(*)</span> <span class="pull-right">0 ký tự</span></h5>
    <div class="controls">
        <textarea type="text" name="meta_description" class="form-control" id="ck_meta_description" rows="8">{{ old('meta_description', $data['postCatalogue']->meta_description ?? null) }}</textarea>
    </div>
</div>

{{-- {!! 1. Th&#244;ng số cơ bản của M&#225;y in Epson L3150 M&#225;y in Epson L3150 l&#224; d&#242;ng m&#225;y in phun m&#224;u đa chức năng với IN, SCAN, COPY, WIFI. M&#225;y in m&#224;u Epson L3150 với khổ giấy in tối đa l&#224; A4. M&#225;y bao gồm 4 m&#224;u mực cơ bản Cyan, Magenta, Yellow v&#224; Black. M&#225;y được thiết kế nhỏ gọn với hệ thống dẫn mực ch&#237;nh h&#227;ng được đặt ph&#237;a trước m&#225;y. !!} --}}