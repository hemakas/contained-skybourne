@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="menu-header">Menu - Edit</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="error">
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
                New Menu Details
            </div>

            <div class="panel-body">

                <div class="col-lg-12">
                    <form name="frm_menu_new" id="frm_menu_new" class="form-horizontal" role="form" 
                          method="POST" action="{{ url('/admin/menus/'.$menu->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="row">
                        <div class="form-group pull-left col-lg-12 {{ $errors->has('menutype') ? ' has-error' : '' }}">
                            <label for="menutype" class="col-md-2 control-label">Menu In</label>
                            <div class="col-lg-10">
                                <input id="menutype" type="text" class="form-control" name="menutype" value="Mainmenu" readonly="readonly">
                                @if ($errors->has('menutype'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('menutype') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="form-group pull-left col-lg-12 {{ $errors->has('menustring') ? ' has-error' : '' }}">
                            <label for="menustring" class="col-md-2 control-label">Menu Title</label>
                            <div class="col-lg-10">
                                <input id="menustring" type="text" class="form-control" name="menustring" value="{{ old('menustring', $menu->menustring) }}">
                                @if ($errors->has('menustring'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('menustring') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="form-group pull-left col-lg-12 {{ $errors->has('menuurl') ? ' has-error' : '' }}">
                            <label for="menuurl" class="col-md-2 control-label">Menu Url</label>
                            <div class="col-md-10">
                                <input id="menuurl" type="text" class="form-control" name="menuurl" value="{{ old('menuurl', $menu->menuurl) }}">
                                @if ($errors->has('menuurl'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('menuurl') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="form-group pull-left col-lg-12 {{ $errors->has('submenuof') ? ' has-error' : '' }}">
                            <label for="submenuof" class="col-md-2 control-label">Sub menu of</label>
                            <div class="col-md-10">
                                <select class="form-control" name="submenuof" id="submenuof">
                                    <option value="0" @if(old('submenuof', $menu->submenuof) == 0) selected="selected" @endif >Select Main menu</option>
                                    @foreach($mainmenus as $mm)
                                    <option @if(old('submenuof', $menu->submenuof) == $mm->id) selected="selected" @endif id="{{ $mm->id }}" value="{{ $mm->id }}" >{{ $mm->menustring }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('submenuof'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('submenuof') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="form-group pull-left col-lg-12 {{ $errors->has('position') ? ' has-error' : '' }}">
                            <label for="position" class="col-md-2 control-label">Menu position</label>
                            <div class="col-md-10">
                                <input id="position" type="text" class="form-control" name="position" value="{{ old('position', $menu->position) }}">
                                @if ($errors->has('position'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                            <label for="active" class="col-md-4 control-label">Active</label>
                            <div class="col-md-6">
                                <input type="checkbox" name="active" id="active" @if($menu->active == 1) checked="checked" @endif value="{{old('active', $menu->active)}}" >

                                @if ($errors->has('active'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <button type="submit" class="btn btn-default">Save</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </form>
                <!-- /.col-lg-12 (nested) -->
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

<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
    // Wysiwyg
    $('.textarea').ckeditor(); // if class is prefered.
</script>

@endsection