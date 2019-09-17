@extends('layouts.app')

@section('content')

  <div id="page-container">
    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('event')}}">Event</a></li>
          <li class="breadcrumb-item" aria-current="page">Create</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <ul class="list-group shadow-lg">

              <li class="list-group-item d-flex justify-content-between align-items-center main-color-bg">
                <a class="left-menu" href="/event">Event</a>
                <span class="badge badge-primary badge-pill">{{$event_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a class="" href="/runner">Runner</a>
                <span class="badge badge-primary badge-pill">{{$user_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a class="" href="/runner/admin/1">Profile</a>
                <span class="badge badge-primary badge-pill"></span>
              </li>
            </ul>
          </div>

          <div class="col-md-10">
            <!-- Website Overview -->
            <div class="card bottom shadow-lg">
              <div class="card-header main-color-bg">
                <h3 class="card-title">Events</h3>
              </div>
              <div class="card-body">
                <form method="post" id="create" action="{{ route('event_create') }}" enctype="multipart/form-data" name="form">
                  @csrf
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Event Title</label>
                          <input type="text" class="form-control" placeholder="Please Enter Event Title Here" name="event_title" required>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="date_event">Date Event</label>
                          <input data-timepicker="true" id="datepicker" data-language='en' data-time-format='hh:ii:AA' data-date-format="yyyy mm dd" class="datepicker-here form-control" name="date_event" placeholder="Enter Event Date" required>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="quota">Quota</label>
                         <input class="form-control" type="number" value="0" id="quota" name="quota" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="ban">Event Banner </label>
                      <input type="file" class="form-control-file" id="file" onchange="readURL(this);" name="file_banner" required>
                      <img src="" class="img-fluid img-thumbnail" id="banner" alt="Responsive image">
                    </div>

                    <div class="form-group">
                      <label for="desc_event">Event Description</label>
                      <textarea class="form-control" id="desc_event" name="desc_event" rows="3" placeholder="Enter Event Description Here" required></textarea>
                    </div>


                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Start point</label>
                          <input type="text" class="form-control" name="start" id="start_point" placeholder="Enter Start Point" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>End point</label>
                          <input type="text" class="form-control" name="end" id="end_point" placeholder="Enter End Point" required>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Button</label>
                          <button type="button" class="btn btn-outline-danger" onclick="initMap()" required>Show Distance & Map</button>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Distance</label>
                      <textarea class="form-control" id="distance" rows="3" disabled></textarea>
                    </div>

                    <div class="form-group">
                      <div id="map" style="width:100%; height:500px;"></div>
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-danger btn-lg btn-block" value="Submit">
                    </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Copyright NoProblem, &copy; 2019</p>
    </footer>
  </div>

  <script type="text/javascript">

  $(document).ready(function() {
    var place = document.getElementById('start_point');
    var searchBox = new google.maps.places.SearchBox(place);

    var place2 = document.getElementById('end_point');
    var searchBox2 = new google.maps.places.SearchBox(place2);

    var map = new google.maps.Map(document.querySelector('#map'), {
      zoom: 8,
      center: {
        lat: 4.2105,
        lng: 101.9758
      }
      //disableDefaultUI: true,
    });

    $('#create').on('submit', function(event){
       event.preventDefault();
       $.ajax({
        url:"{{ route('event_create') }}",
        method:"POST",
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data){
          Swal.fire(
            'Good job!',
            'You register the event!',
            'success'
          ).then((result) => {
            window.location.href = "{{route('event')}}";
          })
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal.fire({
                title: "Oops!",
                text: "An error occurred",
            });
        }
       })
      });


  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#banner')
        .attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
    }
  };

  function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: {
        lat: 4.2105,
        lng: 101.9758
      },
      disableDefaultUI: true,
    });
    directionsDisplay.setMap(map);
    calculateAndDisplayRoute(directionsService, directionsDisplay);
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
      origins: [document.getElementById('start_point').value],
      destinations: [document.getElementById('end_point').value],
      travelMode: 'WALKING',
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false,
    }, callback);

    function callback(response, status) {
      if (status == 'OK') {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;

        for (var i = 0; i < origins.length; i++) {
          var results = response.rows[i].elements;
          for (var j = 0; j < results.length; j++) {
            var element = results[j];
            var distance = element.distance.text;
            var duration = element.duration.text;
            var from = origins[i];
            var to = destinations[j];
          }
        }
        var outputDiv = document.getElementById('distance');
        outputDiv.innerHTML += "Walking distance between " + document.getElementById('start_point').value + ' and' + document.getElementById('end_point').value +
        ': ' + distance + ' in ' +
        duration;
      }
    }
  };
  var service = new google.maps.DistanceMatrixService;
  function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    directionsService.route({
      origin: document.getElementById('start_point').value,
      destination: document.getElementById('end_point').value,
      travelMode: 'WALKING',
    }, function(response, status) {
      if (status === 'OK') {
        directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  };
</script>


@endsection
