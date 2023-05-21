@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    <h1>Courier.index</h1>
    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Courier Form -->
        <form action="/couriers/create" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- courier Name -->
            <div class="form-group">
                <label for="courier" class="col-sm-3 control-label">Courier</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="courier-name" class="form-control">
                </div>
            </div>

            <!-- Add Courier Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Courier
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Current Courier -->
    @if (count($couriers) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Courier</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($couriers as $courier)
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $courier->name }}</div>
                                </td>

                                <td>
                                    <!-- Edit Button -->
                                    <td>
                                        <form action="/couriers/{{ $courier->id }}/update" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}

                                            <button>Edit Courier</button>
                                        </form>
                                    </td>
                                </td>
                                
                                <td>
                                    <!-- Delete Button -->
                                    <td>
                                        <form action="/couriers/{{ $courier->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button>Delete Courier</button>
                                        </form>
                                    </td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
        </div>
    @endif
@endsection