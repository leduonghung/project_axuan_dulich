@if ($data['postCatalogues']->total() >0 )
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    {{ $data['index'] }} tạm thời xóa 
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <i class="ti-settings"></i>
                        </button>
                        <div class="dropdown-menu animated flipInX">
                            <a class="dropdown-item changeStatusAll" data-title="Bạn muốn thay đổi trạng thái" href="javascript:void(0)" onclick="changeStatusAll(this)" data-field="status" data-model="Language" data-value="0" data-message="Bạn muốn UnPublic toàn bộ User đã chọn ?" data-url="{{ route('admin.changeStatusAll') }}">UnPublic Toàn bộ User đã chọn</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item deleteItemAll" data-title="Bạn muốn xóa toàn bộ User đã chọn ?" data-message="Xóa User có thể ảnh hưởng đến dữ liệu hệ thống !" href="javascript:void(0)" onclick="deleteItemAll()">Xóa toàn bộ User đã chọn</a>
                        </div>
                    </div>
                </div>
                {{-- <h6 class="card-subtitle">The Column Toggle Table allows the user to select which columns they want to be visible.</h6> --}}
                <div class="table-responsive">
                    {{-- <div class="pull-right">
                        <x-elements.button-icon cname="Them moi" url="{{ route('admin.user.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon>
                    </div> --}}
                    
                    <table id="myTable" class="tablesaw table-striped table-bordered table" data-tablesaw-mode="columntoggle">
                        <thead>
                            <tr>
                                <th>
                                    <a class="link" href="javascript:void(0)">
                                        <div class="checkbox checkbox-info">
                                            <input type="checkbox" id="checkAllSoftDeletes" name="inputCheckAllSoftDeletes">
                                            <label for="checkAllSoftDeletes" class=""> <span> </span> </label>
                                        </div>
                                    </a>
                                </th>
                                <th>STT</th>
                                <th>{{ $data['fields']['name'] ?? '#' }}</th>
                                <th>{{ $data['fields']['email'] ?? '#' }}</th>
                                <th>{{__('messages.image') ?? '#' }}</th>
                                <th>{{ $data['fields']['phone'] ?? '#' }}</th>
                                <th>{{ $data['fields']['status'] ?? '#' }}</th>
                                {{-- <th>{{__('messages.userCreated') ?? '#' }}</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <form action="" method="post"></form> --}}
                            @if ($data['postCatalogues'])
                                @foreach ($data['postCatalogues'] as $key => $language)
                                <tr id="row_user_{{ $language->id }}">
                                    <td class="title">
                                        <a class="link" href="javascript:void(0)">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" class="checkBoxItemSoftDeletes" id="checkBoxItemSoftDeletes_{{$language->id}}" name="checkItem" value="{{$language->id}}" data-status="{{$language->status}}">
                                                <label for="checkBoxItemSoftDeletes_{{$language->id}}" class=""> <span> </span> </label>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $language->name }}</td>
                                    <td>{{ $language->email }}</td>
                                    <td>{{ $language->image }}</td>
                                    <td>{{ $language->phone }}</td>
                                    <td>
                                        <span id="changeActive_{{ $language->id }}">
                                            <button data-title="Bạn muốn thay đổi trạng thái User: {{ $language->name }}" data-field="status" data-model="Language" data-value="{{$language->status}}" data-message="{{ ($language->status==0)?'Bạn muốn user :\'' .$language->name.'\' kích hoạt ?':'Bạn muốn user : \''.$language->name.'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $language->status ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $language->isActive() !!} </button>
                                        </span>
                                    </td>
                                    {{-- <td>{{ $language->userCreated }}</td> --}}
                                    <td>
                                        @csrf
                                                                               
                                        <a href="javascript:void(0)" id="deleteItem_{{ $language->id }}" onclick="deleteItem({{ $language->id }})" data-action="false" data-title="Bạn muốn khôi phục ngôn ngữ : {{ $language->name }}" data-message="khôi phục ngôn ngữ bạn có thể sử dụng nó !" data-url="{{ route('admin.user.delete', $language->id) }}"><button type="button" class="btn btn-primary btn-circle"><i class=" ti-back-right"></i> </button></a>
                                        <a href="javascript:void(0)" id="deleteItem_{{ $language->id }}" onclick="deleteItem({{ $language->id }})" data-action="false" data-title="Bạn muốn xóa User: {{ $language->name }}" data-message="Xóa User này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.user.delete', $language->id) }}"><button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button></a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7">
                                        {{ $data['postCatalogues']->withPath('user')->onEachSide(1)->links('vendor.pagination.custom') }} 
                                    </td>
                                </tr>
                                @endif
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>
        @endif