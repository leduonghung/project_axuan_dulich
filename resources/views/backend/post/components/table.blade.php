<div class="table-responsive">
    <table id="myTable" class="tablesaw table-striped table-bordered table" data-tablesaw-mode="columntoggle">
        <thead>
            <tr>
                <th>
                    <a class="link" href="javascript:void(0)">
                        <div class="checkbox checkbox-info">
                            <input type="checkbox" id="checkAll" name="inputCheckAll">
                            <label for="checkAll" class=""> <span> </span> </label>
                        </div>
                    </a>
                </th>
                <th>STT</th>
                <th>{{__('messages.image') ?? '#' }}</th>
                <th width="40%">{{ $data['fields']['name'] ?? '#' }}</th>
                <th>{{__('messages.publish') ?? '#' }}</th>
                {{-- <th>{{__('messages.userCreated') ?? '#' }}</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{ dd($posts) }} --}}
            @if(isset($posts) && is_object($posts))
                @foreach ($posts as $key => $post)
                <tr id="row_user_{{ $post->id }}">
                    <td class="title">
                        <a class="link" href="javascript:void(0)">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" class="checkBoxItem" id="checkBoxItem_{{$post->id}}" name="checkItem" value="{{$post->id}}" data-status="{{$post->publish}}">
                                <label for="checkBoxItem_{{$post->id}}" class=""></label>
                            </div>
                        </a>
                    </td>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td><img src="{{ $post->image }}" alt="" style="width: 80px;"></td>
                    <td>
                        <div class="name">
                        <span class="maintitle">{{ $post->name }}</span>
                        </div> 
                        <div class="catalogue">
                            <span class="text-danger">Nhóm hiển thị</span>
                            {{-- {{ dd($post->catalogue->post_language) }} --}}
                            {{-- @foreach ($post->post_catalogues as $cate) --}}
                                <a class="text-success" href="{{ optional($post->catalogue)->post_language ? url(optional($post->catalogue)->post_language->canonical):'' }}">{{ optional($post->catalogue)->post_language ? optional($post->catalogue)->post_language->name :'' }}</a>
                                
                            {{-- @endforeach --}}
                        </div>
                    </td>
                    
                    <td>
                        <span id="changeActive_{{ $post->id }}">
                            <button data-title="Bạn muốn thay đổi trạng thái bài viết : {{ $post->name }}" data-field="publish" data-model="Post" data-value="{{$post->publish}}" data-message="{{ ($post->publish==0)?'Bạn muốn bài viết  :\'' .$post->name.'\' kích hoạt ?':'Bạn muốn bài viết  : \''.$post->name.'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" onclick="changeStatus(this,{{$post->id}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $post->publish ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $post->isActive() !!} </button>
                        </span>
                    </td>
                    {{-- <td>{{ $post->danh mụcCreated }}</td> --}}
                    <td>
                        @csrf
                        <a href="{{ route('admin.post.edit', ['id'=>$post->id]) }}"> <button type="button" class="btn btn-success btn-circle"><i class="ti-pencil"></i> </button></a>
                    
                        <a href="javascript:void(0)" id="deleteItem_{{ $post->id }}" onclick="deleteItem({{ $post->id }})" data-model="Post" data-action="false" data-title="Bạn muốn xóa bài viết : {{ $post->name }}" data-message="Xóa bài viết  này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.post.delete', $post->id) }}"><button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button></a>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7">
                        {{ $posts->withPath('post')->onEachSide(1)->links('vendor.pagination.custom') }} 
                    </td>
                </tr>
                @endif
        </tbody>
    </table>
</div>