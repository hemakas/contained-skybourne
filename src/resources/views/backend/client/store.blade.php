@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Client - Add New</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Client -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<!-- Display success message -->
<div class="success">
    @include('common.success')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Client Details
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form name="frm_client_new" id="frm_client_new" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/clients/') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            
                            
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-6 control-label">Title</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="title" id="title">
                                        <option value="">Select Title</option>
                                        <option @if(old('title') == 'Mr') selected="selected" @endif id="title" value="Mr" >Mr</option>                                        
                                        <option @if(old('title') == 'Mrs') selected="selected" @endif id="title" value="Mrs" >Mrs</option>
                                        <option @if(old('title') == 'Ms') selected="selected" @endif id="title" value="Ms" >Ms</option>
                                    </select>
                                    
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label for="firstname" class="col-md-6 control-label">Firstname</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}">
                                    @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label for="lastname" class="col-md-6 control-label">Lastname</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}">
                                    @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('adrsline1') ? ' has-error' : '' }}">
                                <label for="adrsline1" class="col-md-6 control-label">Address Line 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="adrsline1" name="adrsline1" value="{{ old('adrsline1') }}">
                                    @if ($errors->has('adrsline1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('adrsline1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('adrsline2') ? ' has-error' : '' }}">
                                <label for="adrsline2" class="col-md-6 control-label">Address Line 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="adrsline2" name="adrsline2" value="{{ old('adrsline2') }}">
                                    @if ($errors->has('adrsline2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('adrsline2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">
                                <label for="town" class="col-md-6 control-label">Town</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="town" name="town" value="{{ old('town') }}">
                                    @if ($errors->has('town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('town') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                                <label for="postcode" class="col-md-6 control-label">Postcode</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="postcode" name="postcode" value="{{ old('postcode') }}">
                                    @if ($errors->has('postcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }}">
                                <label for="county" class="col-md-6 control-label">County</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="county" name="county" value="{{ old('county') }}">
                                    @if ($errors->has('county'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('county') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                <label for="country" class="col-md-6 control-label">Country</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                                    @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                                <label for="telephone" class="col-md-6 control-label">Telephone</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}">
                                    @if ($errors->has('telephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="mobile" class="col-md-6 control-label">Mobile</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}">
                                    @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-6 control-label">Email</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-6 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation" class="col-md-6 control-label">Password Confirmation</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="col-md-6 control-label">Active</label>
                                <div class="col-md-6">
                                    <div class="form-group input-group">
                                        <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="status" id="status" value="1" @if(old('status') == 1) checked="checked" @endif> Active
                                        </label>
                                        </div>
                                    </div>
                                    
                                    @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            
                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default">Reset</button>
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

@endsection