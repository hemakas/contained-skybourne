@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profile</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Profile
                <div class="col-md-2 pull-right text-right">
                    <form action="/admin/profile" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}

                                <button>Edit Profile</button>
                            </form>
                </div>
            </div>
            
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="">
                    <tbody>
                        
                        <tr>
                            <td>User Type</td>
                            <td>{{ $user->type }}</td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>{{ $user->username }}</td>
                        </tr>
                        
                        <tr>
                            <td>First name</td>
                            <td>{{ $user->firstname }}</td>
                        </tr>
                        
                        <tr>
                            <td>Last name</td>
                            <td>{{ $user->lastname }}</td>
                        </tr>
                        
                        <tr>
                            <td>Email</td>
                            <td>{!! $user->email !!}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{!! $user->address !!}</td>
                        </tr>
                        <tr>
                            <td>last_login</td>
                            <td>{{ $user->last_login }}</td>
                        </tr>
                        
                        <tr>
                            <td>Created On</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $user->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            
        </div>
    </div>
</div>
     
@endsection