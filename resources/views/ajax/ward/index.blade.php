@if ($data)
<option></option>
@foreach ($data as $item)
<option value="{{ $item['code'] }}">{{ $item['name'] }}</option>
@endforeach
@endif