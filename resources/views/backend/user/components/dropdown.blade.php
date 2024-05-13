<div class="btn-group">
    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action <i class="ti-settings"></i>
    </button>
    <div class="dropdown-menu animated flipInX">
        <a class="dropdown-item changeStatusAll" data-title="Bạn muốn thay đổi trạng thái" href="javascript:void(0)" onclick="changeStatusAll(this)" data-field="publish" data-model="{{ $result['model'] }}" data-value="1" data-message="Bạn muốn Public toàn bộ {{ $result['name'] }} đã chọn ?" data-url="{{ route('admin.changeStatusAll') }}">Public Toàn bộ {{ $result['name'] }} đã chọn</a>
        <a class="dropdown-item changeStatusAll" data-title="Bạn muốn thay đổi trạng thái" href="javascript:void(0)" onclick="changeStatusAll(this)" data-field="publish" data-model="{{ $result['model'] }}" data-value="0" data-message="Bạn muốn UnPublic toàn bộ {{ $result['name'] }} đã chọn ?" data-url="{{ route('admin.changeStatusAll') }}">UnPublic Toàn bộ {{ $result['name'] }} đã chọn</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item deleteItemAll" data-title="Bạn muốn xóa toàn bộ {{ $result['name'] }} đã chọn ?" data-message="Xóa {{ $result['name'] }} có thể ảnh hưởng đến dữ liệu hệ thống !" href="javascript:void(0)" onclick="deleteItemAll()">Xóa toàn bộ {{ $result['name'] }} đã chọn</a>
    </div>
</div>