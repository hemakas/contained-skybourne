@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Facilities</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Facility Details
            </div>

    <!-- Current Facility -->
    @if (!$facility)
            <div class="error">
                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>
    @else
    
    <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $facility->name }}</td>
                        </tr>
                        <tr>
                            <td>Icon</td>
                            <td>
                                <?php 
                                if($facility->icon != '' && Storage::disk('public')->exists($imagepath['img_dir'].$facility->icon)){?>
                                    <div class="thumb_image"><img src="{{URL('upload/images/'.$imagepath['img_dir'].$facility->icon)}}" alt="{{$facility->name}}"/></div>
                                <?php }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Boostrap Icon</td>
                            <td>{{ $facility->boostrapicon }}
                            <?php
                            if($facility->boostrapicon != ''){
                                if(substr($facility->boostrapicon, 0, 2) == 'fa'){
                                    echo '<i class="fa '.$facility->boostrapicon.' fa-fw"></i>';
                                } elseif(substr($facility->boostrapicon, 0, 2) == 'gl') {
                                    echo '<i class="glyphicon '.$facility->boostrapicon.'"></i>';
                                } else {
                                    echo 'Unable to find icon '.$facility->icon;
                                }
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Order</td>
                            <td>{{ $facility->order }}</td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>{{ $facility->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $facility->updated_at }}</td>
                        </tr>
                        <tr><td></td>
                        <td>
                            <form action="/admin/facilities/{{ $facility->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}

                                <button>Edit Facility</button>
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
