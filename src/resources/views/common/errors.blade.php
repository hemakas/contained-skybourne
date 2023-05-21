@if(session()->has('warning'))
    <div class="alert alert-warning">
        <strong>{!! session()->get('warning') !!}</strong>
    </div>
@elseif(session()->has('error'))
    <div class="alert alert-danger">
        <strong>{!! session()->get('error') !!}</strong>
    </div>
@elseif (count($errors) > 0 )

    <!-- Form Error List -->
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong!</strong>

        <br><br>

        <ul>
            @if(isset($error) && $error != "")
                <li>{{ $error }}</li>
            @elseif(is_array($errors) && isset($errors['message']))
                @if(is_array($errors['message']))
                    @foreach ($errors['message'] as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @else
                    <li>$errors['message']</li>
                @endif
            @elseif(is_array($errors))
                @foreach ($errors as $k=>$error)
                    <li>{{ $error }}</li>
                @endforeach
            @elseif($errors->all()!== null)
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                
            @else
            
            @endif
        </ul>
    </div>
@endif