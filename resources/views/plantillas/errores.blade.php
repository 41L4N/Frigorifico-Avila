@if(count($errors))
    <div class="alert alert-danger">
        @foreach ($errors->all() as $e)
            @if( count($errors) > 1)
                <b>{{$loop->iteration}}</b>
            @endif
            {{__($e)}}<br>
        @endforeach
    </div>
@endif