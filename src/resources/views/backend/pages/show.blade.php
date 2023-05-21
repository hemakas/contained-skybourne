@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Pages</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Page Details
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/pages') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

    @if (!$page)
            <div class="error">
                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>
    @else
    
            <!-- Display success message -->
            <div class="success">
            @include('common.success')
            </div>
    
    <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="title" class="col-md-2 control-label">Page Title</label>
                            <div class="col-lg-10">{!! $page->title !!}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="url" class="col-md-2 control-label">Menu Link</label>
                            <div class="col-lg-10">{!! $page->menu->menustring !!}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="url" class="col-md-2 control-label">Page Url</label>
                            <div class="col-lg-10">{!! $page->url !!}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="title" class="col-md-2 control-label">Page Content</label>
                            <div class="col-lg-10">{!! $page->content !!}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="title" class="col-md-2 control-label">Meta Keywords</label>
                            <div class="col-lg-10">{!! $page->metakeywords !!}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="title" class="col-md-2 control-label">Meta Description</label>
                            <div class="col-lg-10">{!! $page->metadesc !!}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group pull-left col-lg-12">
                            <label for="Active" class="col-md-2 control-label">Active</label>
                            <div class="col-lg-10">@if($page->active == 1) Active @else Inactive @endif</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <form action="/admin/pages/{{ $page->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <button>Edit Page</button>
                            </form>
                    </div>
                </div>
                
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
@endif

@endsection
