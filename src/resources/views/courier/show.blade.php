@extends('layouts.app')

@section('content')
<div class="panel-body">
    
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Bootstrap Boilerplate... -->
    <h1>Courier.show</h1>
    


    <!-- Current Courier -->
    @if ($courier)
        <div class="panel panel-default">
            <div class="panel-heading">
                Courier Details
            </div>

            <div class="panel-body">
                <table class="table table-striped courier-table">
<!-- Table Headings -->
                    <thead>
                        <th>Courier</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $courier->name }}</div>
                                </td>

                                <td>
                                    <!-- Delete Button -->
                                    <td>
                                        <form action="/courier/{{ $courier->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button>Delete Courier</button>
                                        </form>
                                    </td>
                                </td>
                            </tr>
                            
                    </tbody>
                </table>
                    
                </div>
        </div>
    @endif
    
</div>    
@endsection