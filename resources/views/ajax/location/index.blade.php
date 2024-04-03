@if ($data)
<option></option>
@foreach ($data as $item)
<option value="{{ $item['code'] }}">{{ $item['full_name'] }}</option>
@endforeach
@endif