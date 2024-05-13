@extends('backend.layout.main')

@section('title') {{ $data['index']['title'] }} @endsection

@section('styles')
    <link href="{{ asset('backend/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet">
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

                {{-- <div class="dataTables_length" id="myTable_length"><label>Show <select name="myTable_length" aria-controls="myTable" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div>
                <div class="pull-right">
                    <x-elements.button-icon cname="Them moi" url="{{ route('admin.user.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon>
                </div>&nbsp;
                <div id="myTable_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="myTable"></label></div> --}}

                <div class="table-responsive">
                    <div class="pull-right">
                        <x-elements.button-icon cname="Them moi" url="{{ route('admin.user.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon>
                    </div>
                    <table id="myTable" class="tablesaw table-striped table-bordered table" data-tablesaw-mode="columntoggle">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>STT</th>
                                <th>{{ $data['fields']['name'] ?? '#' }}</th>
                                <th>{{ $data['fields']['email'] ?? '#' }}</th>
                                <th>{{__('messages.image') ?? '#' }}</th>
                                <th>{{ $data['fields']['phone'] ?? '#' }}</th>
                                <th>{{ $data['fields']['status'] ?? '#' }}</th>
                                <th>{{__('messages.userCreated') ?? '#' }}</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <form action="" method="post"></form> --}}
                            @if ($data['users'])
                                @foreach ($data['users'] as $key => $user)
                                <tr id="row_user_{{ $user->id }}">
                                    {{-- <td class="title"><a class="link" href="javascript:void(0)">
                                        <div class="checkbox checkbox-info">
                                            <input type="checkbox" id="inputSchedule_{{$user->id}}" name="inputCheckboxesSchedule">
                                            <label for="inputSchedule_{{$user->id}}" class=""> <span> </span> </label>
                                        </div>
                                    </a></td> --}}
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->image }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <span id="changeActive_{{ $user->id }}">
                                            <button data-field="status" data-message="{{ ($user->status==0)?'Bạn muốn user : '.$user->name.' kích hoạt ?':'Bạn muốn user : '.$user->name.' Ẩn ?' }}" data-url="{{ route('admin.user.loadAjax') }}" onclick="changeActive(this,{{$user->id}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $user->status ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $user->isActive() !!} </button>
                                        </span>
                                    </td>
                                    <td>{{ $user->userCreated }}</td>
                                    <td>
                                        @csrf
                                        <a href="{{ route('admin.user.edit', ['id'=>$user->id]) }}"> <button type="button" class="btn btn-success btn-circle"><i class="ti-pencil"></i> </button></a>
                                       
                                        <a href="javascript:void(0)" id="deleteItem_{{ $user->id }}" onclick="deleteItem({{ $user->id }})" data-action="false" data-title="Bạn muốn xóa User: {{ $user->name }}" data-message="Xóa User này có thể ảnh hưởng đến dữ liệu !" data-url="{{ route('admin.user.delete', $user->id) }}"><button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button></a>
                                    </td>
                                </tr>
                                @endforeach
                                {{-- <tr>
                                    <td colspan="7">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end">
                                              <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                                              </li>
                                              <li class="page-item"><a class="page-link" href="#">1</a></li>
                                              <li class="page-item"><a class="page-link" href="#">2</a></li>
                                              <li class="page-item"><a class="page-link" href="#">3</a></li>
                                              <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                              </li>
                                            </ul>
                                          </nav>
                                    </td>
                                </tr> --}}
                                @endif
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>
        
    </div>
    
    
@endsection

@section('adminJs')

    <script src="{{ asset('backend/plugins/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <!-- This is data table -->
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/plugins/tablesaw-master/dist/tablesaw.js') }}"></script> --}}
    <!-- start - This is for export functionality only -->
    {{-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script> --}}
    {{-- <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('backend/plugins/sweetalert/jquery.sweet-alert.custom.js') }}"></script> --}}
    <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @parent
    <script>
        (function( $ ) {
            // DOM-ready auto-init of plugins.
            // Many plugins bind to an "enhance" event to init themselves on dom ready, or when new markup is inserted into the DOM
            $( function(){
                $( document ).trigger( "enhance.tablesaw" );
            });

            })( jQuery );
        $(document).ready(function() {
            $('#myTable').DataTable({
                order: [[1, 'desc']],
                "language": {
                    "url": "{{ asset('backend/plugins/datatables/lang/vi.json') }}"
                }
            });

            // var table = $('#example').DataTable({
            //     "columnDefs": [{
            //         "visible": false,
            //         "targets": 2
            //     }],
            //     "order": [
            //         [2, 'asc']
            //     ],
            //     "displayLength": 25,
            //     "drawCallback": function(settings) {
            //         var api = this.api();
            //         var rows = api.rows({
            //             page: 'current'
            //         }).nodes();
            //         var last = null;
            //         api.column(2, {
            //             page: 'current'
            //         }).data().each(function(group, i) {
            //             if (last !== group) {
            //                 $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
            //                 last = group;
            //             }
            //         });
            //     }
            // });
            // Order by the grouping
            // $('#example tbody').on('click', 'tr.group', function() {
            //     var currentOrder = table.order()[0];
            //     if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            //         table.order([2, 'desc']).draw();
            //     } else {
            //         table.order([2, 'asc']).draw();
            //     }
            // });

            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });


            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $('body').on('click', '#delete-user', function () {
  
            //     var userURL = $(this).data('url');
            //     var trObj = $(this);

            //     if(confirm("Are you sure you want to remove this user?") == true){
            //             $.ajax({
            //                 url: userURL,
            //                 type: 'DELETE',
            //                 dataType: 'json',
            //                 success: function(data) {
            //                     alert(data.success);
            //                     trObj.parents("tr").remove();
            //                 }
            //             });
            //     }
            // });

        });
    </script>

    @if(Session::has('code'))
    <script>
        $.toast({
            heading: '{{ Session::get("title") }}',
            text: '{{ Session::get("content") }}',
            position: 'top-right',
            loaderBg:'#'+'{ Session::get(\'color\') }',
            icon: '{{ Session::get("code") ?? "error" }}',
            hideAfter: 4500,
            stack: 6
        });
        
        </script>
    @endif
    @endsection
