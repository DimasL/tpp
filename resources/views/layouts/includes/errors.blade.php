<div class="container">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has($msg . '_message'))
            <div class="alert alert-{{ $msg }}">
                <p>{{ Session::get($msg . '_message') }}</p>
            </div>
        @endif
    @endforeach
</div>