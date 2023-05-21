@extends('layouts.app')

@section('content')
<div class="panel-body">
    
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Bootstrap Boilerplate... -->
    <h1>Courier.store</h1>
    

    <div>
        @if($errors->has())
           @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
        @endif
    </div>

    <!-- Current Courier -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Courier Create
            </div>

            <div class="panel-body">
                <table class="table table-striped courier-table">
<!-- Table Headings -->
                    <thead>
                        <th>Courier</th>
                        <th>&nbsp;</th>
                    </thead>
                    <form action="/couriers/create" method="POST">
                    {{ csrf_field() }}
                    <!-- Table Body -->
                    <tbody>
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>Courier Name</div>
                                </td>

                                <td>
                                    <!-- Delete Button -->
                                    <td>
                                        <input name="name" value=""/>
                                    </td>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="Create"/> </td>
                            </tr>
                    </tbody>
                    </form>
                </table>
                    
                </div>
        </div>
    
    
</div>    
@endsection