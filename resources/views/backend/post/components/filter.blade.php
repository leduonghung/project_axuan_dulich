<div class="pull-right search row" style="display: -webkit-box;">
    <div class="controls">
        <input name="keyword" type="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm" aria-controls="myTable" value="{{ request()->get('keyword') ?? null }}">
    </div>
    
    <div class="catalog">
        <select name="post_catalogue_id" id="post_catalogue_id" class="select2" style="height:36px;" data-placeholder="Chọn danh mục">
            <option></option>
            @if (isset($data['dropdowns']))
                @foreach ($data['dropdowns'] as $key => $val)
                <option @if(request()->has('post_catalogue_id')) {{ request()->input('post_catalogue_id')== $key  ? 'selected':'' }} @endif  value="{{ $key }}">{{ $val }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="publish">
        <select name="publish" id="publish" class="select2" style="height:36px;" data-placeholder="Trạng thái">
            <option></option>
            @php
                $check = request()->has('publish') && !is_null(request()->publish)
            @endphp
            <option value="1" @if($check) {{ request()->input('publish')== 1  ? 'selected':'' }} @endif>Xuất bản</option>
            <option value="0" @if($check) {{ request()->input('publish')== 0  ? 'selected':'' }} @endif>Không xuất bản</option>
            
        </select>
    </div>
            
        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Tìm kiếm</button>
        <x-elements.button-icon cname="Thêm mới" url="{{ route('admin.post.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon> &nbsp;
</div>