@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row"></div>
    <div class="col-lg-12">
        <?php if($response == 'fail'){             
            echo '<div class="has-error">'.$message.'</div>';
        } else {
            echo '<div class="has-success">'.$message.'</div>';
        }
        ?>
        <div class="clearfix"></div>

    </div>
    
</div>

</script>
@endsection
