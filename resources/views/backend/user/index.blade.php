@extends('backend.layout.main')

@section('title') {{ $data['index']['title'] }} @endsection

@section('styles')
    {{-- <link href="{{ asset('backend/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('backend/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/tablesaw-master/dist/tablesaw.css') }}" rel="stylesheet">
    @parent
    <link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert2/sweetalert2.min.css') }}"/>
    <style>
        .dataTables_wrapper{
            padding-top: unset;
        } 
        .swal2-container .swal2-cancel .swal2-actions .btn.btn-danger{
            margin: 0 5px;
        } 
        .swal2-actions>button.btn.btn-danger, .swal2-actions>button.btn.swal2-confirm {
            font-size: 17px;
            font-weight: 500;
            border-radius: 7px;
            padding: 10px 32px;
            margin: 0px 5px 0 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    @include('backend.component.breadCrumb',['title'=>$data['index']['title']])
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">{{ $data['index']['tableHeading'] }}</h4> --}}
                {{-- <h6 class="card-subtitle">The Column Toggle Table allows the user to select which columns they want to be visible.</h6> --}}
                <form action="{{ route('admin.user') }}" method="get">
                <div class="dataTables_length" id="myTable_length">
                    <label>Hiển thị 
                    <select name="perPages" aria-controls="myTable" class="">
                        <option value="10" @selected(request()->get('perPages')==10)>10</option> @selected(true)
                        <option value="25" @selected(request()->get('perPages')==25)>25</option>
                        <option value="50" @selected(request()->get('perPages')==50)>50</option>
                        <option value="100" @selected(request()->get('perPages')==100)>100</option>
                    </select> 
                    bản ghi</label>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <i class="ti-settings"></i>
                    </button>
                    <div class="dropdown-menu animated flipInX">
                        <a class="dropdown-item changeStatusAll" data-title="Bạn muốn thay đổi trạng thái" href="javascript:void(0)" onclick="changeStatusAll(this)" data-field="status" data-model="User" data-value="1" data-message="Bạn muốn Public toàn bộ User đã chọn ?" data-url="{{ route('admin.changeStatusAll') }}">Public Toàn bộ User đã chọn</a>
                        <a class="dropdown-item changeStatusAll" data-title="Bạn muốn thay đổi trạng thái" href="javascript:void(0)" onclick="changeStatusAll(this)" data-field="status" data-model="User" data-value="0" data-message="Bạn muốn UnPublic toàn bộ User đã chọn ?" data-url="{{ route('admin.changeStatusAll') }}">UnPublic Toàn bộ User đã chọn</a>
                        <a class="dropdown-item deleteItemAll" data-title="Bạn muốn xóa toàn bộ User đã chọn ?" data-message="Xóa User có thể ảnh hưởng đến dữ liệu hệ thống !" href="javascript:void(0)" onclick="deleteItemAll()">Xóa toàn bộ User đã chọn</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
                <div class="pull-right">
                    <div id="myTable_filter" class="dataTables_filter">
                        <label>Tìm kiếm:<input name="keyword" type="search" class="" placeholder="" aria-controls="myTable" value="{{ request()->get('keyword') ?? null }}"></label>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <x-elements.button-icon cname="Thêm mới" url="{{ route('admin.user.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon> &nbsp;
                    </div>
                </div>
            </form>
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
                                            <input type="checkbox" id="checkAll" name="inputCheckAll">
                                            <label for="checkAll" class=""> <span> </span> </label>
                                        </div>
                                    </a>
                                </th>
                                <th>STT</th>
                                <th>{{ $data['fields']['name'] ?? '#' }}</th>
                                <th>{{ $data['fields']['email'] ?? '#' }}</th>
                                <th>{{ $data['fields']['image'] ?? '#' }}</th>
                                <th>{{ $data['fields']['phone'] ?? '#' }}</th>
                                <th>{{ $data['fields']['status'] ?? '#' }}</th>
                                {{-- <th>{{ $data['fields']['userCreated'] ?? '#' }}</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <form action="" method="post"></form> --}}
                            @if ($data['users'])
                                @foreach ($data['users'] as $key => $user)
                                <tr id="row_user_{{ $user->id }}">
                                    <td class="title">
                                        <a class="link" href="javascript:void(0)">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" class="checkBoxItem" id="checkBoxItem_{{$user->id}}" name="checkItem" value="{{$user->id}}" data-status="{{$user->status}}">
                                                <label for="checkBoxItem_{{$user->id}}" class=""> <span> </span> </label>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->image }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <span id="changeActive_{{ $user->id }}">
                                            <button data-title="Bạn muốn thay đổi trạng thái User: {{ $user->name }}" data-field="status" data-model="User" data-value="{{$user->status}}" data-message="{{ ($user->status==0)?'Bạn muốn user :\'' .$user->name.'\' kích hoạt ?':'Bạn muốn user : \''.$user->name.'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" onclick="changeStatus(this,{{$user->id}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $user->status ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $user->isActive() !!} </button>
                                        </span>
                                    </td>
                                    {{-- <td>{{ $user->userCreated }}</td> --}}
                                    <td>
                                        @csrf
                                        <a href="{{ route('admin.user.edit', ['id'=>$user->id]) }}"> <button type="button" class="btn btn-success btn-circle"><i class="ti-pencil"></i> </button></a>
                                       
                                        <a href="javascript:void(0)" id="deleteItem_{{ $user->id }}" onclick="deleteItem({{ $user->id }})" data-action="false" data-title="Bạn muốn xóa User: {{ $user->name }}" data-message="Xóa User này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.user.delete', $user->id) }}"><button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button></a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7">
                                        {{ $data['users']->withPath('user')->onEachSide(1)->links('vendor.pagination.custom') }} 
                                    </td>
                                </tr>
                                @endif
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>

        @if (!empty($data['SoftDeletes']) && $data['SoftDeletes'])
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    {{ $data['index']['tableHeading'] }} tạm thời xóa 
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <i class="ti-settings"></i>
                        </button>
                        <div class="dropdown-menu animated flipInX">
                            <a class="dropdown-item changeStatusAll" data-title="Bạn muốn thay đổi trạng thái" href="javascript:void(0)" onclick="changeStatusAll(this)" data-field="status" data-model="User" data-value="0" data-message="Bạn muốn UnPublic toàn bộ User đã chọn ?" data-url="{{ route('admin.changeStatusAll') }}">UnPublic Toàn bộ User đã chọn</a>
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
                                <th>{{ $data['fields']['image'] ?? '#' }}</th>
                                <th>{{ $data['fields']['phone'] ?? '#' }}</th>
                                <th>{{ $data['fields']['status'] ?? '#' }}</th>
                                {{-- <th>{{ $data['fields']['userCreated'] ?? '#' }}</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <form action="" method="post"></form> --}}
                            @if ($data['SoftDeletes'])
                                @foreach ($data['SoftDeletes'] as $key => $user)
                                <tr id="row_user_{{ $user->id }}">
                                    <td class="title">
                                        <a class="link" href="javascript:void(0)">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" class="checkBoxItemSoftDeletes" id="checkBoxItemSoftDeletes_{{$user->id}}" name="checkItem" value="{{$user->id}}" data-status="{{$user->status}}">
                                                <label for="checkBoxItemSoftDeletes_{{$user->id}}" class=""> <span> </span> </label>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->image }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <span id="changeActive_{{ $user->id }}">
                                            <button data-title="Bạn muốn thay đổi trạng thái User: {{ $user->name }}" data-field="status" data-model="User" data-value="{{$user->status}}" data-message="{{ ($user->status==0)?'Bạn muốn user :\'' .$user->name.'\' kích hoạt ?':'Bạn muốn user : \''.$user->name.'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $user->status ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $user->isActive() !!} </button>
                                        </span>
                                    </td>
                                    {{-- <td>{{ $user->userCreated }}</td> --}}
                                    <td>
                                        @csrf
                                                                               
                                        <a href="javascript:void(0)" id="deleteItem_{{ $user->id }}" onclick="deleteItem({{ $user->id }})" data-action="false" data-title="Bạn muốn xóa User: {{ $user->name }}" data-message="Xóa User này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.user.delete', $user->id) }}"><button type="button" class="btn btn-primary btn-circle"><i class=" ti-back-right"></i> </button></a>
                                        <a href="javascript:void(0)" id="deleteItem_{{ $user->id }}" onclick="deleteItem({{ $user->id }})" data-action="false" data-title="Bạn muốn xóa User: {{ $user->name }}" data-message="Xóa User này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.user.delete', $user->id) }}"><button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button></a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7">
                                        {{ $data['users']->withPath('user')->onEachSide(1)->links('vendor.pagination.custom') }} 
                                    </td>
                                </tr>
                                @endif
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>
        @endif
        
    </div>
    
    
@endsection

@section('adminJs')

    <script src="{{ asset('backend/plugins/switchery/dist/switchery.min.js') }}"></script>
    <!-- This is data table -->
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/plugins/tablesaw-master/dist/tablesaw.js') }}"></script> --}}
    <!-- start - This is for export functionality only -->
    {{-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script> --}}
    {{-- <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('backend/plugins/sweetalert/jquery.sweet-alert.custom.js') }}"></script> --}}
    <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @parent
   

@endsection
@if(Session::has('code'))
<script>
    $.toast({
        heading: '{{ Session::get("title") ?? 'Thanh cong' }}',
        text: '{{ Session::get("content") ?? 'Thanh cong' }}',
        position: 'top-right',
        loaderBg:'#'+'{ Session::get(\'color\') ?? '26dad2' }',
        icon: '{{ Session::get("code") ?? "error" }}',
        hideAfter: 4500,
        stack: 6
    });
    
    </script>
@endif
