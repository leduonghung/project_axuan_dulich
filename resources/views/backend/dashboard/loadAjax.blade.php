@if ($data['field']=='status')
<button data-field="status" data-model="User" data-value="{{$data['status']}}" data-message="{{ ($data['status']==0)?'Bạn muốn user :\'' .$data['name'].'\' kích hoạt ?':'Bạn muốn user : \''.$data['name'].'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" onclick="changeStatus(this,{{$data['id']}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $data['status'] ? 'btn-outline-info':'btn-outline-warning' }}"> {!! $data['label'] !!} </button>
@endif
{{-- <button data-field="status" data-model="User" data-value="{{$data['status']}}" data-message="{{ ($data['status']==0)?'Bạn muốn user : \''.$data['name'].'\' kích hoạt ?':'Bạn muốn user : \''.$data['name'].'\' Ẩn ?' }}" data-url="{{ route('admin.changeStatus') }}" onclick="changeStatus(this,{{$data['id']}})" type="button" class="btn btn-sm waves-effect waves-light btn-rounded {{ $data['status'] ? 'btn-outline-info':'btn-outline-warning' }}">{!! $data['label'] !!} </button> --}}