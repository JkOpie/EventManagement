@extends('layouts.app')

@section('content')

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>

        <div class="alert alert-danger" role="alert">
          You cant participate in this page!
          Go to Dashboard.
        </div>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <ul class="list-group shadow-lg">
              <li class="list-group-item d-flex justify-content-between align-items-center ">
                  <a class="" href="/userdash">Dashboard</a>
                <span class="badge badge-primary badge-pill">{{$event_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center  main-color-bg">
                  <a class="left-menu" href="{{route('user_get_history')}}">Participation History</a>
                <span class="badge badge-primary badge-pill">{{$user_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center ">
                <a class="" href="/userprofile">Profile</a>
              </li>
            </ul>
          </div>
          <div class="col-md-10">
              <div class="card bottom shadow-lg ">
                <div class="card-header main-color-bg">
                  <h3 class="card-title">Participation History</h3>
                </div>
                <div class="card-body">
                  @foreach ($history as $key => $historys)
                    <div class="card mb-3" style="max-width: 100%;">
                      <div class="row no-gutters">
                        <div class="col-md-6">
                          <img src="{{url('uploads/'.$historys->filename)}}" class="card-img" alt="">
                        </div>
                        <div class="col-md-6 text-center">
                          <div class="card-body">
                            <h5 class="card-title">{{$historys->event_name}}</h5>
                            <p class="card-text">{{$historys->event_des}}</p>
                            <p>Starting From : {{$historys->start_point}}</p>
                            <p>End at : {{$historys->end_point}}</p>
                            <p>This Event Start at {{$historys->event_date}}</p>
                            <input type="hidden" name="id" id="event_id" value="{{$historys->id}}">
                            <button type="button" class="event btn btn-danger" value="{{$historys->id}}">Register Now!</button>

                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Copyright NoProblem, &copy; 2019</p>
    </footer>

    <script type="text/javascript">
    $(document).ready(function() {
      var register_button = document.getElementById("regisbut");
      var event_id = new Array();

      $(".event").attr('disabled', 'true');


      @foreach ($user as $key => $users)
          event_id = {{$users ->event_id}}
          $(".event").each(function(){
            var value = this.value;
            if(value == event_id){
              this.innerHTML = "";
              this.innerHTML = "U have participate in" + " {{$users->date_regis}}" ;
            }
          })
      @endforeach

      $(".event").click(function () {
        var updateId = this.value;
          //console.log(updateId);
        Swal.fire({
            imageUrl: 'img/PosterDesign.jpg',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            animation: false,
            title: 'Are you sure want to register for this event?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, register!'
          }).then((result) => {

            if (result.value) {
              $.ajax({
                    type: 'post',
                    url: '{{route('user_event_register')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": updateId,
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
                        swal.fire({
                            title: "Oops!",
                            text: "An error occurred",
                        });
                    }
                });
            }
          })
      });
    });




    </script>

@endsection
