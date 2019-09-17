@extends('layouts.welcome')

@section('website_content')
  <div class="container" style="margin-top:7%;">
    <div class="row">
      <div class="col-md-6">
        <div>
          <img src="{{url('uploads/'.$event->filename)}}"  class="img_wrapper rounded">
        </div>
      </div>
      <div class="col-md-6 text-center">
        <div style="padding:20px;">
          <h3 style="font-size: 2.25rem">{{$event->event_name}}</h3>
        </div>
        <div class="des text-center" style="padding:0 0 10px 40px;">
          <p class="mb-0" style="font-size: 1.2rem"><span class="abit "><i class="far fa-calendar-alt fa-lg"></i></span>  {{$event->event_date}}</p>
          <hr>
          <p class="mb-0" style="font-size: 1.2rem"><span class="abit"> <i class="fas fa-map-marker-alt"></i> </span>Start: {{$event->start_point}}</p>
          <hr>
          <p class="mb-0" style="font-size: 1.2rem"><span class="abit"> <i class="fas fa-map-marker-alt"></i> </span>End: {{$event->end_point}}</p>
          <hr>
          <p class="mb-0" style="font-size: 1.2rem"><span class="abit"> <i class="fas fa-pencil-alt"></i> </span>{{$event->event_des}}</p>
          <hr>
          <button type="button" name="button" class="btn btn-danger btn-lg btn-block regis" id="regis{{$event->id}}" value="{{$event->id}}">REGISTER NOW!</button>

        </div>
      </div>
    </div>
    <hr>

    <div class="row" style="margin-bottom:1%">
      <div class="col-md-6 col-sm-12">
        <div class="bgmig text-center">
          <h1>Event Happening In</h1>
          <hr style="margin: auto;width: 100%;border: 1.5px solid #000000; width:30%">
          <p id="demo" style="font-size: 2rem"></p>

        </div>
      </div>
      <div class="col-md-6">
        <div id="map" style="width:100%; height:40vh;" class="rounded"></div>
      </div>
    </div>
  </div>


  <script type="text/javascript">

  @if(Auth::user()){

    @if( !empty($user)){
      var event_id = {{$user->event_id}}
      var value = $('#regis{{$event->id}}').val();

      if(value == event_id){
        $("#regis{{$event->id}}").html('You already registered');
        $('#regis{{$event->id}}').attr('disabled', 'disabled');
      }
    }
    @endif
  }
  @endif



  $('#regis{{$event->id}}').click(function(){
    Swal.fire(
      'Alert!',
      'You must register or login 1st!',
      'info'
    ).then((result) => {
      @guest
        window.location.href = "/login";
      @else
      @if(Auth::user()->hasAnyRole(['user']))
        if (result.value) {
          $.ajax({
                type: 'post',
                url: '{{route('user_event_register')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": {{$event->id}},
                    "user_id" : {{ Auth::user()->id  }}
                  },
                success: function (data) {
                    swal.fire({
                        title: "Success!",
                        text: "Event has been register! Horray",
                        type: "success",
                        confirmButtonColor:'#3085d6',
                    }).then((result)=>{
                      if(result.value){
                        location.reload();
                      }else{
                        location.reload();
                      }
                    })
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  Swal.fire(
                    'Yahoo!',
                    'Successfully Registered!',
                    'success'
                  )
                }
            });

            $("#regis{{$event->id}}").html('You already registered');
            $('#regis{{$event->id}}').attr('disabled', 'disabled');
        }


      @endif
      @if(Auth::user()->hasAnyRole(['admin']))
      Swal.fire(
        'Error!',
        'Admin cant participate in the event!',
        'error'
      )
      @endif
      @endguest

    })
  });
  var countDownDate = new Date("{{$event->event_date}}").getTime();
  var now_now = new Date().getTime();

  if (now_now >   countDownDate ){
    $("#regis{{$event->id}}").html('ClOSED');
    $('#regis{{$event->id}}').attr('disabled', 'disabled');
  }
  var expired = new Date("{{$expired}}").getTime();

  if (expired >  countDownDate ){
    $("#regis{{$event->id}}").html('ClOSED');
    $('#regis{{$event->id}}').attr('disabled', 'disabled');
  }


  var countDownFunction = setInterval(function(){
    var now = new Date().getTime();
    var distance = countDownDate - now;

    var days = Math.floor(distance/(1000 * 60 * 60 * 24));
    var hours = Math.floor((distance%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
    var minutes = Math.floor((distance%(1000 * 60 * 60))/(1000 * 60));
    var seconds = Math.floor((distance)%(1000 * 60))/(1000);

    document.getElementById("demo").innerHTML = days +" "+ "D " + hours +" "+"H " + minutes +" "+"M " + " "+seconds.toFixed(0) + "S ";

    if(distance<0){
      clearInterval(countDownFunction);
      document.getElementById("demo").innerHTML = "EXPIRED";
    }
  },1000);

  var markerArray = [];
  var directionsService = new google.maps.DirectionsService;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8,
    center: {
      lat: 4.2105,
      lng: 101.9758
    },
    disableDefaultUI: true,
  });

  var directionsDisplay = new google.maps.DirectionsRenderer({map: map});
  var stepDisplay = new google.maps.InfoWindow;

  calculateAndDisplayRoute(directionsDisplay, directionsService, markerArray, stepDisplay, map);

  function calculateAndDisplayRoute(directionsDisplay, directionsService,markerArray, stepDisplay, map) {
    // First, remove any existing markers from the map.
    for (var i = 0; i < markerArray.length; i++) {
      markerArray[i].setMap(null);
    }

    // Retrieve the start and end locations and create a DirectionsRequest using
    // WALKING directions.
    directionsService.route({
      origin: '{{$event->start_point}}',
      destination: '{{$event->end_point}}',
      travelMode: 'WALKING'
    }, function(response, status) {
      // Route the directions and pass the response to a function to create
      // markers for each step.
      if (status === 'OK') {
        //document.getElementById('warnings-panel').innerHTML ='<b>' + response.routes[0].warnings + '</b>';
        directionsDisplay.setDirections(response);

      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  }
</script>

@endsection
