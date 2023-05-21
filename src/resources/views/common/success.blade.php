@if(isset($success) or session()->has('success'))
    <div class="alert alert-success">
        <strong>Done!</strong>
        <br>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @elseif(isset($success['message']))
                <div><label class="alert alert-success">$success['message']</label></div>
            @elseif(isset($success))
                <div>{{ $success }}</div>
            @endif
        </ul>
    </div>
@endif