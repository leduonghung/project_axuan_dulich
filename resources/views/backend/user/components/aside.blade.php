<div class="card">
    <div class="card-body">
        <div class="form-group @if($errors->has('parent_id'))error @endif">
            <h5>{{ $data['fields']['parent_id'] }} <span class="text-danger">(*)</span></h5>
            <div class="controls">
                <select name="parent_id" id="parent_id" class="select2 selectpicker location" style="width: 100%; height:36px;" data-target="district">
                    {{-- <option>-- Select --</option> --}}
                    {{-- <option value="0">-- Root --</option> --}}
                    {{-- <option value="1">-- Tin --</option> --}}
                    
                    @if (isset($data['dropdowns']))
                        @foreach ($data['dropdowns'] as $key => $val)
                        <option {{ old('parent_id', isset($data['postCatalogue']->parent_id) && $data['postCatalogue']->parent_id == $key ) ? 'selected':'' }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    @endif
                </select>
                @if($errors->has('parent_id'))
                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('parent_id') }}</li></ul></div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-group">
            <h5>{{__('messages.image') }} <span class="text-danger">(*)</span></h5>
            <div class="controls text-center">
                <span class="img img-cover img-target"><img src="{{ old('image',isset($data['postCatalogue']->image) ? asset($data['postCatalogue']->image): asset('backend/images/not-found.jpg')) }} " alt="image sa" style="max-height: 200px;"></span>
                <input type="hidden" value="{{ old('image',$data['postCatalogue']->image ?? null) }}" name="image" class="form-control upload-image-avartar @error('canonical') form-control-danger @enderror">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">

        <div class="form-group">
            <h5>{{__('messages.order') }} </h5>
            <div class="controls">
                <input type="text" name="order" value="{{ old('order',$data['postCatalogue']->order ?? null) }}" class="form-control" data-type='numbers'>
            </div>
        </div>

        <div class="form-group">
            <h5>{{ $data['fields']['follow'] }} 
            <div class="controls switchery-demo m-b-30">
                <input name="follow" {{ $segment =='create' || (isset($data['postCatalogue']->follow) && old('follow',$data['postCatalogue']->follow) == true )? 'checked':null }} type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" />
            </div>
        </div>
        <div class="form-group">
            <h5>{{__('messages.publish') }}
            <div class="controls switchery-demo m-b-30">
                <ul class="icheck-list">
                    <li>
                        <input type="radio" value="1" class="check" id="square-radio-1" name="publish"  @if((isset($data['postCatalogue']->publish) && old('publish',$data['postCatalogue']->publish)) ||  $segment =='create' ) checked @endif  data-radio="iradio_square-blue">
                        <label for="square-radio-1">Publish</label>
                    </li>
                    <li>
                        <input type="radio" value="0" class="check" id="square-radio-2" name="publish" @if((isset($data['postCatalogue']->publish) && !old('publish',$data['postCatalogue']->publish)) && $segment !='create') checked @endif data-radio="iradio_square-red">
                        <label for="square-radio-2">UnPublish</label>
                    </li>
                    {{-- <li>
                        <input type="radio" value="2" class="check" id="square-radio-3" name="publish" data-radio="iradio_square-yellow">
                        <label for="square-radio-2">Radio button 2</label>
                    </li> --}}
                    
                </ul>
                {{-- <input name="publish" {{ old('publish',$data['postCatalogue']->publish) == true || $segment ='create'  ? 'checked':null }} type="checkbox" class="js-switch" data-color="#26c6da" data-secondary-color="#f62d51" /> --}}
            </div>
        </div>
    </div>
</div>