@extends('backend.layout.main')

@section('title') {{ $data['index'] }} @endsection

@section('styles')
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
                @include('backend.postCatalogue.components.dropdown',['result'=>['model'=>'PostCatalogue','name'=>'Danh mục']])
                <div class="pull-right">
                    <div id="myTable_filter" class="dataTables_filter">
                        <label>Tìm kiếm:<input name="keyword" type="search" class="" placeholder="" aria-controls="myTable" value="{{ request()->get('keyword') ?? null }}"></label>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <x-elements.button-icon cname="Thêm mới" url="{{ route('admin.post.catalogue.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon> &nbsp;
                    </div>
                </div>
            </form>
                <div class="table-responsive">
                    {{-- <div class="pull-right">
                        <x-elements.button-icon cname="Them moi" url="{{ route('admin.user.create') }}" iconClass="ti-plus text">Thêm mới</x-elements.button-icon>
                    </div> --}}
                   @include('backend.postCatalogue.components.table',['postCatalogues'=>$data['postCatalogues']])

                </div>
                
            </div>
        </div>
        
        
    </div>
    
    
@endsection

@section('adminJs')
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @parent
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
@endsection
