<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg . '_message'))
                    <div class="alert alert-{{ $msg }}">
                        <p>{!! Session::get($msg . '_message')  !!}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>