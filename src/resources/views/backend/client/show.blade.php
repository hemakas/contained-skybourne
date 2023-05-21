@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Clients</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Client Details
            </div>

            <!-- Current Client -->
            <div class="error">
                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>


            <!-- Display success message -->
            <div class="success">
            @include('common.success')
            </div>
        
            @if($client)
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>{{ $client->title }}</td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>{{ $client->firstname }}</td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>{{ $client->lastname }}</td>
                        </tr>
                        <tr>
                            <td>Address Line 1</td>
                            <td>{{ $client->adrsline1 }}</td>
                        </tr>
                        <tr>
                            <td>Address Line 2</td>
                            <td>{{ $client->adrsline2 }}</td>
                        </tr>
                        <tr>
                            <td>Town</td>
                            <td>{{ $client->town }}</td>
                        </tr>
                        <tr>
                            <td>Postcode</td>
                            <td>{{ $client->postcode }}</td>
                        </tr>
                        <tr>
                            <td>County</td>
                            <td>{{ $client->county }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $client->country }}</td>
                        </tr>
                        <tr>
                            <td>Telephone</td>
                            <td>{{ $client->telephone }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $client->mobile }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $client->email }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>@if($client->status == 1){{ 'Active' }} @else {{ 'Inactive' }} @endif</td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>{{ $client->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $client->updated_at }}</td>
                        </tr>
                        <tr><td></td>
                        <td>
                            <form action="/admin/clients/{{ $client->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}

                                <button>Edit Client</button>
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
