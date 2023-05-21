<!---booking search engine--->
<form action="{{ url('/flightresults/') }}" method="post" name="frm_findflight">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <div class="col-md-12 panel panel-body bkg_eng">
        <div class="row line-grey">
            <div class="form-check form-check-inline pull-left">
                <label class="form-check-label">
                    <input class="form-check-input rbtsearchtype" type="radio" name="rbtn_searchtype" id="inlineRadio1" checked="checked" @if(old('rbtn_searchtype') == "return") checked="checked" @endif value="return" > Return &nbsp;
                </label>
            </div>
            <div class="form-check form-check-inline  pull-left">
                <label class="form-check-label">
                    <input class="form-check-input rbtsearchtype" type="radio" name="rbtn_searchtype" id="inlineRadio2" @if(old('rbtn_searchtype') == "oneway") checked="checked" @endif value="oneway"> One way &nbsp;
                </label>
            </div>
            <!--<div class="form-check form-check-inline  pull-left">
                <label class="form-check-label">
                    <input class="form-check-input rbtsearchtype" type="radio" name="rbtn_searchtype" id="inlineRadio3" @if(old('rbtn_searchtype') == "multi") checked="checked" @endif value="multi"> Multicity
                </label>
            </div>-->
        </div>
        <div class="row">
            <div class="col-sm-6">
              <label>Flying from
              <div class="input-group">
                <span class="input-group-addon transparent"><span class="glyphicon glyphicon-map-marker"></span></span>
                  <input type="text" name="fromtag" class="form-control fly_from ajaxcity" value="{{ old('flying_from') }}" id="fromtag" autocomplete="off">
                  <div class="fromlist"><div class="loaderimg text-center"><img src="assets/img/ajax-loader-small.gif" title="loading..."/></div><ul></ul></div>
                  <input type="hidden" name="flying_from" value="{{ old('flying_from') }}" id="flying_from"/>
                </div>
            </label>
          </div>
          @if ($errors->has('flying_from'))
          <span class="help-block">
              <strong>{{ $errors->first('flying_from') }}</strong>
          </span>
          @endif
            <div class="col-sm-6">
              <label>Flying to
              <div class="input-group">
                <span class="input-group-addon transparent"><span class="glyphicon glyphicon-map-marker"></span></span>
                  <input class="form-control fly_to ajaxcity2" type="text" name="totag" id="totag" autocomplete="off" value="{{ old('flying_to') }}" required>
                  <div class="tolist"><div class="loaderimg text-center"><img src="assets/img/ajax-loader-small.gif" title="loading..."/></div><ul></ul></div>
                  <input type="hidden" name="flying_to" value="{{ old('flying_to') }}" id="flying_to"/>
                </div>
                @if ($errors->has('flying_to'))
                <span class="help-block">
                    <strong>{{ $errors->first('flying_to') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
              <label>Departure date
              <div class="input-group">
                <span class="input-group-addon transparent"><span class="glyphicon glyphicon-calendar"></span></span>
                  <input class="form-control left-border-none" placeholder="yyyy-mm-dd" value="{{ old('departure_date') }}" type="text" name="departure_date" id="depart_date" autocomplete="off">
                </div>
              </label>
                @if ($errors->has('departure_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('departure_date') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-sm-4">
                <label>Return date
                  <div class="input-group">
                    <span class="input-group-addon transparent"><span class="glyphicon glyphicon-calendar"></span></span>
                      <input class="form-control left-border-none" placeholder="yyyy-mm-dd" value="{{ old('return_date') }}" type="text" name="return_date" id="return_date" autocomplete="off">
                    </div>
              </label>
                @if ($errors->has('return_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('return_date') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-sm-4">
                <label>Class
                    <div class="form-group">
                        <select name="slct_class" class="form-control class_dt">
                            <option value="Y" @if(old('slct_class') == "Y") selected="selected" @endif >Economy</option>
                            <option value="S" @if(old('slct_class') == "S") selected="selected" @endif >Economy Premium</option>
                            <option value="C" @if(old('slct_class') == "C") selected="selected" @endif >Business</option>
                        </select>
                    </div>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 pull-left">
                <ul class="no_pax_select">
                    <li>
                        <div class="input-group">
                            <label>Adult</label>
                            <span id="qnty"> 1</span><input type="hidden" class="qnty_adult" name="adults" id="hadults" value="1"/>
                            @if ($errors->has('adults'))
                            <span class="help-block">
                                <strong>{{ $errors->first('adults') }}</strong>
                            </span>
                            @endif

                            <span class="input-group-btn">
                                <button class="btn btn-default bkgbtn" type="button" id="btn-minus"><span class="glyphicon glyphicon-minus"></span></button>
                            </span>
                            <span class="input-group-btn">
                                <button class="btn btn-default bkgbtn" type="button" id="btn-plus"><span class="glyphicon glyphicon-plus"></span></button>
                            </span>

                        </div>
                    </li><p class="mobilenone">( > 12 years)</p>
                    <li>
                        <div class="input-group">
                            <label>Child</label>
                            <span id="qnty" class="hchildqty"> 0</span>
                            <input type="hidden" name="child" id="hchild" value="0"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default bkgbtn child-minus" type="button" id="btn-plus"><span class="glyphicon glyphicon-minus"></span></button>
                            </span>
                            <span class="input-group-btn">
                                <button class="btn btn-default bkgbtn child-plus" type="button" id="btn-minus"><span class="glyphicon glyphicon-plus"></span></button>
                            </span>

                        </div>
                    </li>
                    <p class="mobilenone"> ( 2 to 11 years)</p>
                    <li>
                        <div class="input-group">
                            <label>Infant</label>
                            <input type="hidden" name="infant" id="hinfant" value="0"/>
                            <span id="qnty" class="infantqty"> 0</span>
                            <span class="input-group-btn">
                                <button class="btn btn-default bkgbtn infant-minus" type="button" id="btn-plus"><span class="glyphicon glyphicon-minus"></span></button>
                            </span>
                            <span class="input-group-btn">
                                <button class="btn btn-default bkgbtn infant-plus" type="button" id="btn-minus"><span class="glyphicon glyphicon-plus"></span></button>
                            </span>

                        </div>
                    </li>
                    <p class="mobilenone"> ( below 2 years)</p>
                </ul>

            </div>
            <div class="col-md-5 pull-left">
                <label>Airline
                    <div class="form-group">
                        <select class="form-control class_dt airline" name="slct_airline">
                            <option value="">Any Airline</option>
                            <!--<option value="UL">Sri Lankan Airline</option>
                            <option value="QA">Qatar Airways</option>
                            <option value="EK">Emirates</option>
                            <option value="AF">Air France</option>-->
                        </select>
                    </div>
                </label>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-check-label fnt_size_small_xx">
                            <input class="form-check-input" type="checkbox" name="rbtn_flexi" id="inlineRadio1" value="1"> + / - 3 days
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-check-label fnt_size_small_xx">
                            <input class="form-check-input" type="checkbox" name="rbtn_directonly" id="inlineRadio1" value="1"> Direct flights
                        </label>
                    </div>
                </div>
                <button type="submit" role="button" class="btn-search pull-left">Search Flights</button>

            </div>
        </div>
    </div>
</form>

<!-- AJAX request -->

<script type="text/javascript">

$(document).ready(function(){
    // hide textbox loading img
    $('.loaderimg').hide();

    // Disable return date if not return journey
    $('input[name="rbtn_searchtype"]').on('click', function() {
        if($(this).val() === 'return'){
            $('#return_date').removeProp("disabled");
        }
        else {
            $('#return_date').val('');
            $('#return_date').prop("disabled", "disabled");
        }
    });

    $(".fromlist").on("click", "li",function(){
        $('#flying_from').val($(this).data('id'));
        $('#fromtag').val($(this).data('val'));
        $('.fromlist').fadeOut();
        //alert($varName);
       });

    $(".tolist").on("click", "li", function(){
        $('#flying_to').val($(this).data('id'));
        $('#totag').val($(this).data('val'));
        $('.tolist').fadeOut();
    });

    /*$(".ajaxcity").focusout(function() {
        $('.fromlist').hide();
    });*/

    //-- AJAX request -->
    $('.ajaxcity').keyup(function(event){
        if($(this).val().length >= 2)
        {
            $(this).siblings('.fromlist').find('.loaderimg').show();
            $('.tolist').fadeIn();
                var token, url, data;
                token = $('input[name=_token]').val();
                strcity = $(this).val();
                url = "/ajax/cityairports";
                oThis = $(this);
                url = "{{ url('') }}"+url;
                data = {city: strcity};
                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token, 'method_field':"POST"},
                    data: data,
                    type: 'POST',
                    datatype: 'JSON',
                    success: function (resp) {
                        oThis.siblings('.fromlist').find('.loaderimg').hide();
                        var oAuul = oThis.siblings('.fromlist').find('ul');
                        oAuul.html("");
                        if ( resp.length != 0 ) {
                             oAuul.text("");
                            $.each(resp, function(key, val) {
                                oAuul.append("<li data-id=\"" + val.code+"\" data-val='" + val.code+ "-"+val.airport+ "'>" + val.code+ "-"+val.airport+ "<br/>"+val.city+"</li>");
                            });
                            $('.fromlist').fadeIn();
                        } else {
                            oAuul.append("<li data-id='' data-val=''>No airport found!</li>");
                            //alert("No airport found!");
                        }
                    },
                    error: function(){
                       alert("No airport found!");
                    }
                });
        }
    });

    /*
    $(".fly_from").focus(function(){
       $('.fromlist').fadeIn();
   });

    $(".ajaxcity").focusout(function(){
        $('.fromlist').fadeOut();
    });*/

    /*$(".ajaxcity2").focusout(function() {
        $('.tolist').hide();
    });*/

    // To list
    $('.ajaxcity2').keyup(function(event){
        if($(this).val().length >= 2)
        {
            $(this).find('.loaderimg').show();
            $('.tolist').fadeIn();
              var token, url, data;
              token = $('input[name=_token]').val();
              strcity = $(this).val();
              url = "/ajax/cityairports";
              oThis = $(this);
              url = "{{ url('') }}"+url;
              data = {city: strcity};
              $.ajax({
                  url: url,
                  headers: {'X-CSRF-TOKEN': token, 'method_field':"POST"},
                  data: data,
                  type: 'POST',
                  datatype: 'JSON',
                  success: function (resp) {
                      oThis.siblings('.tolist').find('.loaderimg').hide();
                        var oAuul = oThis.siblings('.tolist').find('ul');
                        oAuul.html("");
                      if ( resp.length != 0 ) {
                          oAuul.text("");
                          $.each(resp, function(key, val) {
                              oAuul.append("<li data-id=\"" + val.code+"\" data-val='" + val.code+ "-"+val.airport+ "'>" + val.code+ "-"+val.airport+ "<br/>"+val.city+"</li>");
                          });

                      } else {
                            oAuul.append("<li data-id='' data-val=''>No airport found!</li>");
                        }
                  },
                    error: function(){
                       alert("No airport found!");
                    }
              });
      }
   });

   /*
   $(".ajaxcity2").focusin(function(){
      $('.tolist').fadeIn();
   });

   $(".ajaxcity2").focusout(function(){
       $('.tolist').fadeOut();
   });

   format:'yyyy-mm-dd',
   orientation: "top",
   autoclose: true

   */

 $("#depart_date").datepicker({
       useCurrent: false,
       format: 'yyyy-mm-dd',
       firstDay: 1,
       orientation: 'top',
       autoclose: true,
   });

   $("#return_date").datepicker({
     format: 'yyyy-mm-dd',
     firstDay: 1,
     orientation: 'top',
     autoclose: true,
   });



   // Adults
   $('#btn-minus').on('click',function(){
       var count = parseInt($('#qnty').text())-1;
       if(count > 0){
           $('#qnty').text(count);
           $("#hadults").val(count);
       }/*
       if(count <= 0){
          count = 1;
          $("#hadults").val( parseInt($("#hadults").val(count)));

       }else{
         $('#qnty').text(count);
         $("#hadults").val( parseInt($("#hadults").val())-1);
       }*/
   });

   $('#btn-plus').on('click',function(){
       var count = parseInt($('#qnty').text())+1;
       if(count < 11){
           $('#qnty').text(count);
           $("#hadults").val(count);
       }
   });

   // Child
   $('.child-minus').on('click',function(){
       var count = parseInt($('.hchildqty').text())-1;
       if(count >= 0){
           $('.hchildqty').text(count);
           $("#hchild").val(count);
       }/*
       if(count <= 0){
          count = 0;
          $("#hchild").val( parseInt($("#hchild").val(count)));
       } else {
         $('.hchildqty').text(count);
         $("#hchild").val( parseInt($("#hchild").val())-1);
       }*/
   });

   $('.child-plus').on('click',function(){
       var count = parseInt($('.hchildqty').text())+1;
       if(count < 11){
           $('.hchildqty').text(count);
           $("#hchild").val(count);
       }
   });

   // Infant
   $('.infant-minus').on('click',function(){
       var count = parseInt($('.infantqty').text())-1;
       if(count >= 0){
           $('.infantqty').text(count);
           $("#hinfant").val(count);
       }/*
       if(count <= 0){
          count = 0;
          $("#hinfant").val( parseInt($("#hinfant").val(count)));
       }else{
         $('.infantqty').text(count);
         $("#hinfant").val( parseInt($("#hinfant").val())-1);
       }*/
   });

   $('.infant-plus').on('click',function(){
       var count = parseInt($('.infantqty').text())+1;
       if(count < 11){
           $('.infantqty').text(count);
           $("#hinfant").val(count);
       }
   });

});
</script>
