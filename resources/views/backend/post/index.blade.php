@extends('backend.layout.main')

@section('title') {{ config('apps.user.title') }} @endsection
@section('styles')
    <link href="{{ asset('backend/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('backend.component.breadCrumb',['data'=>$data['breadCrumb']])
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Responsive Table </h4>
                    <h6 class="card-subtitle">Create responsive tables by wrapping any <code>.table</code> in <code>.table-responsive </code></h6>
                    <div class="table-responsive">
                        <div class="dataTables_length" id="example_length"><label>Show <select name="example_length" aria-controls="example" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div>

                        <div id="example_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="example"></label></div>
                        

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>{{ $data['fields']['name'] }}</th>
                                    <th>{{ $data['fields']['email'] }}</th>
                                    <th>{{ $data['fields']['image'] }}</th>
                                    <th>{{ $data['fields']['phone'] }}</th>
                                    <th>{{ $data['fields']['status'] }}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data['users']['data'])
                            @foreach ($data['users']['data'] as $key => $user)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['image'] }}</td>
                                <td>{{ $user['phone'] }}</td>
                                <td>
                                    <input type="checkbox" {{ $user['status'] === 1 ? 'checked': null }}  data-color="#26dad2" data-secondary-color="#f62d51" class="js-switch" data-size="small" />
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-circle"><i class="ti-pencil"></i> </button>
                                    <button type="button" class="btn btn-danger btn-circle"><i class="ti-trash"></i> </button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
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
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection

    @section('scripts')
    <script src="{{ asset('backend/plugins/switchery/dist/switchery.min.js') }}"></script>
    <!-- This is data table -->
    <!-- start - This is for export functionality only -->
    {{-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script> --}}
    @endsection
    @if(session('success'))
    <script>
            $.toast({
                heading: 'Chào mừng đến với trang quản trị !',
                text: "{{ session('success') }}",
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'success',
                hideAfter: 3500,
                stack: 6
            });
         </script>
    @endif
    