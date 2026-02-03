@if (Session::has('message'))
    <div x-data="notification" x-init="minixNotification(`{{ Session::get('message') }}`, '{{ Session::get('type') ?? 'success' }}', {{ Session::get('duration') ?? 3000 }})">
        <span id="danger-toast"></span>
    </div>
@endif
