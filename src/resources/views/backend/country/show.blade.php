@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Countries</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Country Details
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/countries') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

    <!-- Current Country -->
    @if (!$country)
            <div class="error">
                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>
    @else
    
    <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $country->name }}</td>
                        </tr>
                        <tr>
                            <td>Url</td>
                            <td>{{ $country->url }}</td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>{{ $country->title }}</td>
                        </tr>
                        <tr>
                            <td>Title2</td>
                            <td>{{ $country->title2 }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!!$country->description!!}</td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>{{ $country->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $country->updated_at }}</td>
                        </tr>
                        <tr><td></td>
                        <td>
                            <form action="/admin/countries/{{ $country->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}

                                <button>Edit Country</button>
                            </form>
                        </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
@endif

@endsection
