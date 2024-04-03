@extends('backend.layout.main')
@php $segment = request()->segment(4); @endphp

@section('title', $data[$segment])
@section('styles')
    <link href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/select2-bootstrap4-theme-master/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
    @parent
    <style>
        .select2-container--bootstrap4 .select2-selection__clear {
            width: 1em;
            height: 1em;
            padding-left: 0.19em;
            line-height: 0.95em;
        }
        .select2-selection.select2-selection--single.select2-selection.loading{
            border-color: #ff8080;
            -webkit-box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            box-shadow: 0 0 0 0.2rem rgb(255 0 0 / 25%);
        }
    </style>
@endsection
{{-- @prepend('styles')
    <link href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endprepend --}}
@section('content')
    @include('backend.component.breadCrumb',['title'=> $data[$segment]])
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form id="createlanguage" class="languageCreate" novalidate method="POST" action="{{ $data['action'] }}">
            @csrf
            <div class="general-info row">
                <div class="col-sm-3 pull-left hidden-sm-down">
                    <div class="card-body">
                        <h3 class="card-title">Thông tin chung</h3>
                        <p class="card-text">- Nhập thông tin chung của người sử dụng</p>
                        <p class="card-text">- Lưu ý : Những trường đánh dấu <span class="text-danger">(*)</span> bắt buộc phải nhập</p>
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
                
                <div class="col-sm-9 card pull-right">
                    <div class="card-body row">
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['name'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="text" name="name" value="{{ old('name',$data['language']->name ?? null) }}" class="form-control nameforSlug" required data-validation-required-message="This field is required"> 
                                {{-- <x-elements.input name="name" value="{{ old('name') }}" required="true" ></x-elements.input> --}}
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['canonical'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="text" value="{{ old('canonical',$data['language']->canonical ?? null) }}" name="canonical" class="form-control slugName @error('canonical') form-control-danger @enderror" required data-validation-required-message="This field is required">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['image'] }} </h5>
                            <div class="controls">
                                <input type="text" id="ckfinder-widget" name="image" value="{{ old('image',$data['language']->image ?? null) }}" class="form-control upload-image" data-upload="Images">
                            </div>
                        </div>
{{-- {{ dd($data['language']) }} --}}
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['status'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls switchery-demo m-b-30">
                                <input name="status" @if ((isset($data['language']->status) && $data['language']->status) || $segment ='create') checked @endif  type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" class="btn btn-info"> @if ($segment==='create') Thêm mới @else Chỉnh sửa @endif</button>
                            <button type="reset" class="btn btn-inverse">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
@endsection

@section('adminJs')
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('backend/js/validation.js') }}"></script>
    {{-- <script src="{{ asset('tinymce/tinymce.min.js') }}"></script> --}}
    <script src="{{ asset('backend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    
    
    <script>
        
        (function( $ ) {
            $( function(){
                $( document ).trigger( "enhance.tablesaw" );
            });
            
        })( jQuery );
        
        ! function(window, document, $) {
            "use strict";
            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(), $(".skin-square input").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green"
            }), $(".touchspin").TouchSpin(), $(".switchBootstrap").bootstrapSwitch();
        }(window, document, jQuery);
       
        $(document).ready(function() {
            // var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });
        });
        
    </script>
    <script src="{{ asset('backend/library/library.js') }}"></script>
    <script src="{{ asset('backend/plugins/ckfinder_2/ckfinder.js') }}"></script>
    <script src="{{ asset('backend/library/finder.js') }}"></script>
    <!-- This is data table -->

    <script>
    </script>
    @endsection