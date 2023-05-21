@extends('layouts.master')
@section('pageTitle',"Holidays to ".$country->title)
@section('pageMetaKeywords',"Holidays to ".$country->title)
@section('pageMetaDesc',"Holidays to ".$country->title)

@section('content')

<div class="container-full">
    @if(!empty($country))
    <div class="container">
        <p class="destCarousel_title">{!!$country->title!!}</p>
        <h1 class="destCarousel_h1">{!!$country->title2!!}</h1>
    </div>
    @endif

    @if(!empty($carousel) && count($carousel) > 0)
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $i = 0; ?>
            @foreach($carousel as $cimg)
                <li data-target="#myCarousel" data-slide-to="{{$i}}" <?php echo ($i ==0?' class="active"':''); ?>></li>
            <?php $i++; ?>
            @endforeach
        </ol>

        <div class="carousel-inner destinations">
            <?php $x = 0; ?>
            @foreach($carousel as $cimg)
            <div class="item <?php echo ($x ==0?'active':''); ?>">
                <?php
                if(Storage::disk('public')->exists('carousels/'.$cimg->carouselplace->place.'/'.$cimg->imagename)){?>
                    <div class="item <?php echo ($x == 0?"active":""); ?>" data-slide-number="{{$x}}">
                        <img src="{{URL('upload/images/carousels/'.$cimg->carouselplace->place.'/'.$cimg->imagename)}}" alt="{{$cimg->title}}">
                    </div>
                <?php
                }
                $x++;
                ?>
            </div>
            <?php $i++; ?>
            @endforeach
        </div>

        <a class="left carousel-control dest" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control dest" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    @endif

</div>
<div class="container">
    @if(!empty($country))
    <div class="row">
        <p></p>
        {!!$country->description!!}
    </div>
    @endif
</div>
<div class="clearfix">
</div>
<p></p>
<div class="container">
    <div class="col-sm-4 col-md-4">

        <form name="frm_holidays" id="frm_holidays" @if($countryUrl == '') {{'action="/holidays"'}} @else {{'action="/holidays/'.$countryUrl.'"'}} @endif method="POST" role="form">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <input type="hidden" name="s" id="i_stars" value="" />
        <input type="hidden" name="o" id="s_order" value="" />
        </form>
        <div class="filterpanel pull-left">
            <h1>Filter your results</h1>
            @if(count($countries)>0)
            <div class="form-group ">
                <label class="control-label " for="select">
                    Looking for...
                </label>
                <select class="select form-control" id="sel_country" name="sel_country">
                    <option value="">Tour in</option>
                @foreach($countries as $c)
                    <option value="{{$c->url}}" @if($countryUrl == $c->url) {{'selected="selected"'}} @endif >{{$c->name}}</option>
                @endforeach
                </select>
            </div>
            @endif

            <h3>Arrange by</h3>
            <hr/>
            <ul>
                <li>
                    <div class="checkbox">
                        <label class="checkbox">
                            <input name="rd_order" type="radio" class="chk_order" @if($order == 'p') checked="checked" @endif value="p"/>
                            Price
                        </label>
                    </div>
                </li>
                <li>
                    <div class="checkbox">
                        <label class="checkbox">
                            <input name="rd_order" type="radio" class="chk_order" @if($order == 't') checked="checked" @endif value="t"/>
                            A-Z
                        </label>
                    </div>
                </li>
                <li>
                    <div class="checkbox">
                        <label class="checkbox">
                            <input name="rd_order" type="radio" class="chk_order" @if($order == 'r') checked="checked" @endif value="r"/>
                            Recommended
                        </label>
                    </div>
                </li>
            </ul>

            <h3>Hotel Rating</h3>
            <hr/>
            <ul>
                <li>
                    <label class="checkbox">
                        <input name="rd_stars" type="radio" class="rd_stars" @if($stars == '5') checked="checked" @endif value="5"/>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                    </label>
                </li>
                <li>
                    <label class="checkbox">
                        <input name="rd_stars" type="radio" class="rd_stars" @if($stars == '4') checked="checked" @endif value="4"/>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </label>
                </li>
                <li>
                    <label class="checkbox">
                        <input name="rd_stars" type="radio" class="rd_stars" @if($stars == '3') checked="checked" @endif value="3"/>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </label>
                </li>
            </ul>

            <div class="col-lg-6">
                <button type="button" id="btn_filter" class="btn btn-default">Filter</button>
            </div>

        </div>
    </div>
    <div class="col-sm-8 col-md-8 pull-left">
        <?php //echo "<pre>"; print_r($itineraries->toArray()); echo "</pre>"; ?>
        @if(count($itineraries) > 0)

            @foreach($itineraries as $itinerary)
                <div class="row listing">
                    <?php
                        if(Storage::disk('public')->exists('itineraries/'.$itinerary->itineraryimage->itinerary_id.'/'.$itinerary->itineraryimage->imagename)){?>
                            <div class="col-sm-4">
                                <img class="img-responsive" src="{{URL('upload/images/itineraries/'.$itinerary->itineraryimage->itinerary_id.'/'.$itinerary->itineraryimage->imagename)}}" alt="{{$itinerary->title}}">
                            </div>
                        <?php
                        } else { ?>
                            <div class="col-sm-4">
                                <img class="img-responsive" src="{{URL('upload/images/itineraries/noimage.png')}}" alt="No image">
                            </div>

                    <?php
                        }
                    ?>
                    <div class="col-sm-8">
                        <div class="row offerlisting">
                            <span class="col-sm-8">
                                <h2>{!!$itinerary->title!!}</h2>
                                <div class="padding-left">
                                    <span class="">
                                    <?php for($i=1;$i<=$itinerary->stars;$i++){ ?>
                                    <span class="glyphicon glyphicon-star inline"></span>
                                    <?php }
                                    $i = (5 - ($i));
                                    for($x=0;$x<=$i;$x++){ ?>
                                    <span class="glyphicon glyphicon-star-empty inline"></span>
                                    <?php } ?>
                                    </span>
                                </div>
                                {!!$itinerary->summary!!}
                            </span>
                            <span class="col-sm-4">
                                <span id="offertag">
                                    <h5>{{$itinerary->nights}} Nights from</h5>
                                    <h3 style="margin-top:-7px;">&pound;{!!$itinerary->price!!}pp</h3>
                                    <a href="{{ url('/itinerary/'.$itinerary->url) }}" title="{{$itinerary->title}}"><button type="button" class="btn btn-primary pull-right viewoffer">view offer</button></a>
                                </span>
                            </span>

                        </div>

                    </div>
                </div>
                <br/>
            @endforeach
        <div>{{ $itineraries->links() }}</div>
        @endif

        <p></p>



    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var c = "";
        var o = "";
        var s = "";
        $('#btn_filter').on('click', function () {
            c = $('#sel_country').val();
            o = $("[name=rd_order]:checked").val();
            s = $("[name=rd_stars]:checked").val();

            if(c == ''){
                $('#frm_holidays').attr("action", "/holidays");
            } else {
                $('#frm_holidays').attr("action", "/holidays/"+c);
            }
            $('#s_order').val(o);
            $('#i_stars').val(s);
            $('#frm_holidays').submit();
        });
    });
</script>
@endsection
