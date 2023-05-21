@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Message</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Delivery status -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Message on {{ $msg->created_on }}
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/messages/inbox') }}"><i class="glyphicon glyphicon-save"></i> Inbox</a></div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="">
                            @if(isset($messagebox) && $messagebox == "sent")
                                <div class="form-group">
                                    <label for="sendtoemail" class="col-md-3 control-label">To</label>
                                    <div class="col-md-7">
                                        <p>{{ $msg->toname }}
                                            @if(isset($msg->touser->email)) 
                                            &lt;{!! $msg->touser->email !!}&gt; 
                                            @elseif(isset($msg->toauser->email)) 
                                            [Admin]
                                            @endif</p>
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="sendtoemail" class="col-md-3 control-label">From</label>
                                    <div class="col-md-7">
                                        <p>{{ $msg->fromname }}
                                            @if(isset($msg->fromuser->email)) 
                                            &lt;{!! $msg->fromuser->email !!}&gt; 
                                            @elseif(isset($msg->fromauser->email)) 
                                            [Admin]
                                            @endif</p>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label for="subject" class="col-md-3 control-label">Subject</label>
                                <div class="col-md-7">
                                    <p><b>{!! $msg->message->subject !!}</b></p>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <div class="col-md-10">
                                    <p>{!! $msg->message->body !!}</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label"></label>
                                <div class="col-md-7">
                                    <form name="frm_messages_new" id="frm_messages_new" class="form-horizontal" role="form" 
                                            method="POST" action="{{ url('/admin/messages/compose') }}" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                          {{ method_field('PATCH') }}

                                        <input type="hidden" name="mailchain_id" value="{{ old('mailchain_id', $msg->mailchain_id) }}" readonly="readonly"/>
                                        <button type="submit" name="submit" value="Reply" class="btn btn-default">Reply</button>
                                    </form>
                                </div>
                            </div>
                            
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>
        $('.ckeditorta').ckeditor(); // if class is prefered.
    </script>
    
@endsection