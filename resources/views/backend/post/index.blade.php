@extends('backend.layout.main')

@section('title') {{ $data['index'] }} @endsection

@section('styles')
    <link href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/select2-bootstrap4-theme-master/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/tablesaw-master/dist/tablesaw.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert2/sweetalert2.min.css') }}"/>
    @parent
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
        /* .search.pull-right{width: 60%;} */
    </style>
@endsection

@section('content')
    @include('backend.component.breadCrumb',['title'=>$data['index']])
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
                <form action="{{ route($data['action']) }}" method="get">
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
                    @include('backend.post.components.dropdown',['result'=>['model'=>'Post','name'=>'Bài viết']])
                    @include('backend.post.components.filter',['result'=>['model'=>'Post','name'=>'Bài viết']])
                </form>
                   @include('backend.post.components.table',['posts'=>$data['posts']])
            </div>
        </div>
        
        
    </div>
    
    
@endsection

@section('adminJs')
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @parent
    <script>
        $(document).ready(function () {
            $(".select2").select2({
                theme: "bootstrap4",
                allowClear :true,
                // multiple :true,
                placeholder: $(this).data('placeholder')
            });
        });
    </script>
@endsection
@if(Session::has('code'))
<script>
    
    $.toast({
        heading: '{{ Session::get("title") }}',
        text: '{{ Session::get("content") }}',
        position: 'top-right',
        loaderBg:'#26dad2',
        icon: '{{ Session::get("code") ?? "error" }}',
        hideAfter: 4500,
        stack: 6
    });
    
    </script>
@endif
