@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Menus</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Page Details
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/menus') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

            <div class="error">
                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>
    
            <!-- Display success message -->
            <div class="success">
            @include('common.success')
            </div>
    
    <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="menustring" class="col-md-2 control-label">Title</label>
                            <div class="col-lg-10">{!! $menu->menustring !!}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="menutype" class="col-md-2 control-label">Menu On</label>
                            <div class="col-lg-10">{{ $menu->menutype }}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="position" class="col-md-2 control-label">Position</label>
                            <div class="col-lg-10">{{ $menu->position }}</div>
                        </div>
                    </div>
                    
                    @if($menu->submenuof != 0)
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="submenuof" class="col-md-2 control-label">Submenu Of</label>
                            <div class="col-lg-10">{!! $menu->mainmenu->menustring !!}</div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="submenuof" class="col-md-2 control-label">Submenu Of</label>
                            <div class="col-lg-10">This is not a sub menu</div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="url" class="col-md-2 control-label">Link</label>
                            <div class="col-lg-10">{!! $menu->menuurl !!}</div>
                        </div>
                    </div>
                                        
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="Active" class="col-md-2 control-label">Active</label>
                            <div class="col-lg-10">@if($menu->active == 1) Active @else Inactive @endif</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <form action="/admin/menus/{{ $menu->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <button>Edit Menu</button>
                            </form>
                    </div>
                </div>
                
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->

@endsection
