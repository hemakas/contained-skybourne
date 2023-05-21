@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Payment Request</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<div class="error">
    <!-- Display Validation Errors -->
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
                Payment Request
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/payments') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        
                            <h3>Transaction</h3>
                            
                            <div class="form-group col-lg-12 {{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="col-lg-6 control-label">Status</label>
                                <div class="col-lg-6">
                                    {{ $payreq->status }}
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-12 {{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="col-lg-6 control-label">Amount</label>
                                <div class="col-lg-6">
                                    {{ $payreq->amount }}
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-12 {{ $errors->has('reference') ? ' has-error' : '' }}">
                                <label for="reference" class="col-lg-6 control-label">Invoice/Reference</label>
                                <div class="col-lg-6">
                                    {{ $payreq->reference }}
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-12 {{ $errors->has('expiredin') ? ' has-error' : '' }}">
                                <label for="expiredin" class="col-lg-6 control-label">Expired On</label>
                                <div class="col-lg-6">
                                    {{ $payreq->expiredon }}
                                </div>
                            </div>
                            
                            <h3>Customer Details</h3>
                            <div class="form-group col-lg-12 {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-lg-6 control-label">Title</label>
                                <div class="col-lg-6">
                                    {{ $payreq->title }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label for="firstname" class="col-lg-6 control-label">Firstname</label>
                                <div class="col-lg-6">
                                    {{ $payreq->firstname }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label for="lastname" class="col-lg-6 control-label">Lastname</label>
                                <div class="col-lg-6">
                                    {{ $payreq->lastname }}
                                </div>
                            </div>

                            <h3>Billing Address</h3>
                            <div class="form-group col-lg-12 {{ $errors->has('adrsline1') ? ' has-error' : '' }}">
                                <label for="adrsline1" class="col-lg-6 control-label">Address Line 1</label>
                                <div class="col-lg-6">
                                    {{ $payreq->adrsline1 }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('adrsline2') ? ' has-error' : '' }}">
                                <label for="adrsline2" class="col-lg-6 control-label">Address Line 2</label>
                                <div class="col-lg-6">
                                    {{ $payreq->adrsline2 }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('town') ? ' has-error' : '' }}">
                                <label for="town" class="col-lg-6 control-label">Town</label>
                                <div class="col-lg-6">
                                    {{ $payreq->town }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('postcode') ? ' has-error' : '' }}">
                                <label for="postcode" class="col-lg-6 control-label">Postcode</label>
                                <div class="col-lg-6">
                                    {{ $payreq->postcode }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('county') ? ' has-error' : '' }}">
                                <label for="county" class="col-lg-6 control-label">County</label>
                                <div class="col-lg-6">
                                    {{ $payreq->county }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('country') ? ' has-error' : '' }}">
                                <label for="country" class="col-lg-6 control-label">Country</label>
                                <div class="col-lg-6">
                                    {{ $payreq->country }}
                                </div>
                            </div>

                            <div class="form-group col-lg-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="col-lg-6 control-label">Phone</label>
                                <div class="col-lg-6">
                                    {{ $payreq->phone }}
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-lg-6 control-label">Email</label>
                                <div class="col-lg-6">
                                    {{ $payreq->email }}
                                </div>
                            </div>                  
                            
                            <div class="form-group col-lg-12 {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-lg-6 control-label">Description</label>
                                <div class="col-lg-6">
                                    {{ $payreq->description }}
                                </div>
                            </div>  
                            
                            
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
                
                <div class="row">
                    <div class="cardDetails">
                        @include('includes.incpaymentdetails')
                        <div class="row"></div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

@endsection