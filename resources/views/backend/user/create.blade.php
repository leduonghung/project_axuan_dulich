@extends('backend.layout.main')
@php $routeName = Route::current()->getName() @endphp
@section('title') {{ $routeName=='admin.user.create' ? $data['create'] : $data['update'] }} @endsection


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
    
    @include('backend.component.breadCrumb',['title'=> $routeName=='admin.user.create' ? $data['create'] : $data['update']])
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


        <form id="createUser" class="userCreate" novalidate method="POST" action="{{ $data['action'] }}">
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
                            <h5>{{ $data['fields']['email'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="email" value="{{ old('email',$data['user']->email ?? null) }}" name="email" class="form-control @error('email') form-control-danger @enderror" required data-validation-required-message="This field is required">
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['name'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="text" name="name" value="{{ old('name',$data['user']->name ?? null) }}" class="form-control" required data-validation-required-message="This field is required"> 
                                {{-- <x-elements.input name="name" value="{{ old('name') }}" required="true" ></x-elements.input> --}}
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['birthday'] }} </h5>
                            <div class="controls">
                                <input type="date" name="birthday" value="{{ old('birthday', $data['user']->birthday ?? null) }}" class="form-control" >
                            </div>
                        </div>
                        @if ($routeName =='admin.user.create')
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['password'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="password" name="password" class="form-control @error('password') form-control-danger @enderror" required data-validation-required-message="This field is required">
                            </div>
                        </div>
    
                        <div class="form-group col-sm-6 @error('re_password') has-danger @enderror">
                            <h5>{{ $data['fields']['re_password'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="password" name="re_password" class="form-control @error('re_password') form-control-danger @enderror" required data-validation-required-message="This field is required">
                            </div>
                            @error('re_password') 
                            <small class="form-control-feedback">{{ $message }}</small>
                            @enderror
                            
                        </div>
                            
                        @endif

                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['image'] }} </h5>
                            <div class="controls">
                                <input type="text" name="image" value="{{ old('image',$data['user']->image ?? null) }}" class="form-control upload-image" data-upload="Images" style="width:60%">
                                <img src="{{ url($data['user']->image) ?? null }}" alt="" height="50">
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-info row">
                <div class="col-sm-3 pull-left hidden-sm-down">
                    <div class="card-body">
                        <h3 class="card-title">Thông tin liên hệ</h3>
                        <p class="card-text">- Nhập thông tin liên hệ của người sử dụng</p>
                        {{-- <p class="card-text">- Lưu ý : Những trường đánh dấu <span class="text-danger">(*)</span> bắt buộc phải nhập</p> --}}
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                        
                    </div>
                </div>
                
                <div class="col-sm-9 card pull-right">
                    <div class="card-body row">
                        
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['province_id'] }} {{-- <span class="text-danger">(*)</span> --}}</h5>
                            <div class="controls">
                                <select name="province_id" id="province_id" class="select2 selectpicker location" style="width: 100%; height:36px;" data-target="district">
                                    <option></option>
                                    @if (isset($data['provinces']))
                                        @foreach ($data['provinces'] as $province)
                                        <option {{ old('province_id', isset($data['user']->province_id) && $data['user']->province_id == $province['code'] ) ? 'selected':'' }} value="{{ $province['code'] }}">{{ $province['full_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['district_id'] }} {{-- <span class="text-danger">(*)</span> --}}</h5>
                            <div class="controls">
                                <select name="district_id" id="district_id" class="select2 selectpicker location" style="width: 100%; height:36px;"  @if ($routeName=='admin.user.create' && !old('district_id')) disabled @endif  data-target="ward" @if (old('district_id',!isset($data['user']->district_id)) ) disabled @endif>
                                    <option></option>
                                    @if (isset($data['districts']['districts']))
                                        @foreach ($data['districts']['districts'] as $district)
                                        <option {{ old('district_id', $routeName=='admin.user.edit' && $data['user']->district_id == $district['code'] ) ? 'selected':'' }} value="{{ $district['code'] }}">{{ $district['full_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['ward_id'] }} {{-- <span class="text-danger">(*)</span> --}}</h5>
                            <div class="controls">
                                <select name="ward_id" id="ward_id" class="select2 selectpicker" style="width: 100%; height:36px;" @if ( $routeName=='admin.user.create' || !isset($data['user']->ward_id)) disabled @endif>
                                    <option></option>
                                    @if (isset($data['wards']['wards']))
                                        @foreach ($data['wards']['wards'] as $ward)
                                        <option {{ old('province_id', $routeName=='admin.user.edit' && $data['user']->ward_id == $ward['code'] ) ? 'selected':'' }} value="{{ $ward['code'] }}">{{ $ward['full_name'] }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['address'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="text" name="address" value="{{ old('address',$data['user']->address ?? null) }}" class="form-control" required data-validation-required-message="This field is required">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['content'] }} </h5>
                            <textarea name="description" class="form-control" id="editor" rows="3" placeholder="Message">{{ old('description',$data['user']->description ?? null) }}</textarea>
                            {{-- <textarea id="mymce" name="area"></textarea> --}}
                        </div>
        
                        <div class="form-group col-sm-6">
                            <h5>{{ $data['fields']['phone'] }} <span class="text-danger">(*)</span></h5>
                            <div class="controls">
                                <input type="text" name="phone" value="{{ old('phone',$data['user']->phone ?? null) }}" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-12 row">
                            <div class="form-group col-sm-6">
                                <h5>{{ $data['fields']['status'] }} <span class="text-danger">(*)</span></h5>
                                <div class="controls switchery-demo m-b-30">
                                    <input name="status" checked type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="reset" class="btn btn-inverse">Cancel</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <hr>
            
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
        var province_id =  `{{ isset($data['user']->province_id) ? $data['user']->province_id : old('province_id') }}`
        var district_id =  `{{ isset($data['user']->district_id) ? $data['user']->district_id : old('district_id') }}`
        var ward_id =  `{{ isset($data['user']->ward_id) ? $data['user']->ward_id : old('ward_id') }}`;
        $(document).ready(function() {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });
        });
        
        // var province_id =  `${{ isset($data['user']->province_id) ? $data['user']->province_id : old('province_id') }}`
        // var district_id =  `${ isset($data['user']->district_id) ? $data['user']->district_id : old('district_id') }`
        // var ward_id =  `${ isset($data['user']->ward_id) ? $data['user']->ward_id : old('ward_id') }`
    </script>
    <script src="{{ asset('backend/library/library.js') }}"></script>
    <script src="{{ asset('backend/library/location.js') }}"></script>
    <script src="{{ asset('backend/plugins/ckfinder_2/ckfinder.js') }}"></script>
    <script src="{{ asset('backend/library/finder.js') }}"></script>
    
    <!-- This is data table -->
    
    @endsection