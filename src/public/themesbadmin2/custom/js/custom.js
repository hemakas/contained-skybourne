$(document).ready(function(){

    // DELETE confirmation
    $('.btndelete').click(function(){
        if (!confirm("Are you sure you want to delete this record?")){
            return false;
        }
    });
});