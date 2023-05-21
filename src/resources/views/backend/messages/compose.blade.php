@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Compose New Message</h1>
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
                New Message
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/messages/inbox') }}"><i class="glyphicon glyphicon-save"></i> Inbox</a></div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="">
                        <form name="frm_messages_new" id="frm_messages_new" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/messages') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <div class="form-group{{ $errors->has('sendtoemail') ? ' has-error' : '' }}">
                                <label for="sendtoemail" class="col-md-3 control-label">To Email</label>
                                <div class="col-md-7">
                                    <input id="sendtoemail" type="text" class="form-control" name="sendtoemail" value="{{ old('sendtoemail', $sendtoemail) }}">
                                    <input type="hidden" name="cc" value=""/>
                                    <input type="hidden" name="bcc" value=""/>
                                    <input type="hidden" name="sendtouser_id" value="{{ old('sendtouser_id', $sendtouser_id) }}"/>
                                    @if ($errors->has('sendtoemail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sendtoemail') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('sendtoname') ? ' has-error' : '' }}">
                                <label for="sendtoname" class="col-md-3 control-label">To Name</label>
                                <div class="col-md-7">
                                    <input id="sendtoname" type="text" class="form-control" name="sendtoname" value="{{ old('sendtoname', $sendtoname) }}">
                                    @if ($errors->has('sendtoname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sendtoname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label for="subject" class="col-md-3 control-label">Subject</label>
                                <div class="col-md-7">
                                    <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject', $subject) }}">
                                    @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body" class="col-md-3 control-label">Message </label>
                                <div class="col-md-7">
                                    <textarea name="body" id="body" class="ckeditorta form-control" >{!! old('body'), $body !!}</textarea>
                                    @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label"></label>
                                <div class="col-md-7">
                                    <?php if(!isset($draft_id)){ $draft_id = ''; } ?>
                                    <input type="hidden" name="draft_id" value="{{ old('draft_id', $draft_id) }}" readonly="readonly"/>
                                    <input type="hidden" name="mailchain_id" value="{{ old('mailchain_id', $mailchain_id) }}" readonly="readonly"/>
                                    <button type="submit" name="submit" value="send" class="btn btn-default">Send</button>
                                    <button type="submit" name="submit" value="save" class="btn btn-default">Save in drafts</button>
                                    <?php if(isset($draft_id)){ ?>
                                    <button type="submit" name="submit" value="deletedraft" class="btn btn-default">Delete</button>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                            
                        </form>
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