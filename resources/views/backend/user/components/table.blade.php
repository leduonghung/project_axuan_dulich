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
            <th>{{ $data['fields']['name'] ?? '#' }}</th>
            {{-- <th>{{ $data['fields']['language'] ?? '#' }}</th> --}}
            <th>{{__('messages.image') ?? '#' }}</th>
            <th>{{__('messages.publish') ?? '#' }}</th>
            {{-- <th>{{__('messages.userCreated') ?? '#' }}</th> --}}
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ dd($postCatalogues) }} --}}
        @if(isset($postCatalogues) && is_object($postCatalogues))
            @foreach ($postCatalogues as $key => $postCata)
            <tr id="row_user_{{ $postCata->id }}">
                <td class="title">
                    <a class="link" href="javascript:void(0)">
                        <div class="checkbox checkbox-info">
                            <input type="checkbox" class="checkBoxItem" id="checkBoxItem_{{$postCata->id}}" name="checkItem" value="{{$postCata->id}}" data-status="{{$postCata->publish}}">
                            <label for="checkBoxItem_{{$postCata->id}}" class=""></label>
                        </div>
                    </a>
                </td>
                <td>{{ $key+1 }}</td>
                <td>{{ str_repeat('|----', (($postCata->level > 0) ? ($postCata->level - 1): 0)).$postCata->name }}</td>
                {{-- <td>{{ $postCata->name }}</td> --}}
                <td><img src="{{ asset($postCata->image) }}" alt="" srcset="" style="height: 35px;"></td>
                {{-- <td>{{ dd($postCata->post_catalogue_language) }}</td> --}}
                {{-- <td>{{ dd($postCata->languages->wherePivot('id', '=', 1)) }}</td> --}}
                <td>
                    <span id="changeActive_{{ $postCata->id }}">
                        <button data-title="Bạn muốn thay đổi trạng thái danh mục: {{ $postCata->name }}" data-field="publish" data-model="PostCatalogue" data-value="{{$postCata->publish}}" data-message="{{ ($postCata->publish==0)?'Bạn muốn danh mục :\'' .$postCata->name.'\' kích hoạt ?':'Bạn muốn danh mục : \''.$postCata->name.'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" onclick="changeStatus(this,{{$postCata->id}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $postCata->publish ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $postCata->isActive() !!} </button>
                    </span>
                </td>
                {{-- <td>{{ $postCata->danh mụcCreated }}</td> --}}
                <td>
                    @csrf
                    <a href="{{ route('admin.post.catalogue.edit', ['id'=>$postCata->id]) }}"> <button type="button" class="btn btn-success btn-circle"><i class="ti-pencil"></i> </button></a>
                   
                    <a href="javascript:void(0)" id="deleteItem_{{ $postCata->id }}" onclick="deleteItem({{ $postCata->id }})" data-model="PostCatalogue" data-action="false" data-title="Bạn muốn xóa danh mục: {{ $postCata->name }}" data-message="Xóa danh mục này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.post.catalogue.delete', $postCata->id) }}"><button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button></a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="7">
                    {{ $postCatalogues->withPath('catalogue')->onEachSide(1)->links('vendor.pagination.custom') }} 
                </td>
            </tr>
            @endif
    </tbody>
</table>