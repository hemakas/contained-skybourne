@extends('layouts.master')

@section('content')

<!--search area--->
<div class="container-full search_front_bg">
    <div class="container">
        <div class="row">
            
        <p><?php $ary = array("zdlfkvjzd", 'amount'=>234.33, array('a', 'b')); $ens = StringHelper::encryptString(json_encode($ary)); echo "Enc: ".$ens; ?></p>
        <p><?php echo "Dec: "; print_r(json_decode(StringHelper::dencryptedString($ens))); ?></p>
    </div>
  </div>
  </div>
@endsection
