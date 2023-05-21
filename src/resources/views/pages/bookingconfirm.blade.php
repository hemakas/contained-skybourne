@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row"></div>
    <div class="col-lg-12">
        <?php if(!empty($error)){             
            echo '<div>'.$error[0].'</div>';
        } elseif($message != "") {
                echo '<div>'.$message.'</div>';
        } ?>
        <div class="clearfix"></div>

    </div>
    
</div>


<!-- AJAX request -->
<script type="text/javascript">
    $(document).ready(function(){
    $(".showFlightsDetails").click(function() {
    var oFdata = $(this).parents('.booking-item-flight-details').find('.flightsindetail');
    if (oFdata.hasClass("hideflightdetails")){
    oFdata.addClass('showflightdetails');
    oFdata.removeClass('hideflightdetails');
    } else {
    oFdata.addClass('hideflightdetails');
    oFdata.removeClass('showflightdetails');
    }
    });
    // Left side bar filter
    $('#ckNonDirect').change(function() {
    if (this.checked) { // show non-direct
    $('.nondirectflights').show();
    } else { // dont show non-direct
    $('.nondirectflights').hide();
    }
    });
    $('#ckDirect').change(function() {
    if (this.checked) { // show non-direct
    $('.directflights').show();
    } else { // dont show non-direct
    $('.directflights').hide();
    }
    });
    $('.filterfcode').change(function() {
    var cls = '.flightcode' + $(this).data('id');
    if (this.checked) { // show non-direct
    $(cls).show();
    } else { // dont show non-direct
    $(cls).hide();
    }
    });
    $("#filterSelectAll").click(function() {
    $('.flightitineraries').show();
    $('.filterfcode').prop('checked', true);
    });
    $("#filterClearAll").click(function() {
    $('.flightitineraries').hide();
    $('.filterfcode').prop('checked', false);
    });
    });
</script>
@endsection
