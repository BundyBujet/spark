@if (Session::has('message'))
    <div x-data="notification" x-init="minixNotification(`{{ Session::get('message') }}`, '{{ Session::get('type') ?? 'success' }}', {{ Session::get('duration') ?? 3000 }})">
        <span id="danger-toast"></span>
    </div>
@endif
@if (Session::has('success'))
    <div x-data="notification" x-init="minixNotification({{ json_encode(Session::get('success')) }}, 'success', 3000)">
        <span id="success-toast"></span>
    </div>
@endif
@if (Session::has('error'))
    <div x-data="notification" x-init="minixNotification({{ json_encode(Session::get('error')) }}, 'error', 5000)">
        <span id="error-toast"></span>
    </div>
@endif
