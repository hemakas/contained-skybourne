@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row"></div>
    <div class="col-lg-12">
        @if($response == 'fail')
            <div class="alert alert-danger">
                <strong>{!! $message !!}</strong>
            </div>
        @else
            <div class="alert alert-success">
                <strong>{!! $message !!}</strong>
            </div>
        @endif
        <div class="clearfix"></div>

    </div>
    
</div>

</script>
@endsection
