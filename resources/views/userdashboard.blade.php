@extends('layouts.app')

@section('content')

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <ul class="list-group shadow-lg">
              <li class="list-group-item d-flex justify-content-between align-items-center main-color-bg">
                  <a class="left-menu" href="/userdash">Dashboard</a>
                <span class="badge badge-primary badge-pill">{{$event_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                  <a class="" href="{{route('user_get_history')}}">Participation History</a>
                <span class="badge badge-primary badge-pill">{{$user_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a class="" href="/userprofile">Profile</a>
              </li>
            </ul>
          </div>
          <div class="col-md-10">
              <div class="card bottom shadow-lg">
                <div class="card-header main-color-bg">
                  <h3 class="card-title">Latest Event</h3>
                </div>
                <div class="card-body">
                  @foreach ($event as $key => $events)
                    <div class="card mb-3" style="max-width: 100%;">
                      <div class="row no-gutters">
                        <div class="col-md-6">
                          <img src="{{url('uploads/'.$events->filename)}}" class="card-img" alt="">
                        </div>
                        <div class="col-md-6 text-center">
                          <div class="card-body">
                            <h5 class="card-title">{{$events->event_name}}</h5>
                            <p class="card-text">{{$events->event_des}}</p>
                              <input type="hidden" name="id" id="event_id" value="{{$events->id}}">
                              <p>Starting From : {{$events->start_point}}</p>
                              <p>End at : {{$events->end_point}}</p>

                              <button type="button" class="event btn btn-danger" value="{{$events->id}}" >Register Now!</button>
                              <button type="button" class="btn btn-danger delete display" id="delete{{$events->id}}" value="{{$events->id}}">Im Out!</button>
                            <p class="card-text"><small class="text-muted">This Event Start at {{$events->event_date}}</small></p>
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

      @foreach ($user as $key => $users)
        var del_but = document.getElementById("delete{{$users->event_id}}");
          event_id = {{$users ->event_id}};
          user_id = {{$users->user_id}};
          $(".event").each(function(){
            var value = this.value;
            if(value == event_id){
              this.innerHTML = "";
              this.innerHTML = "Already Registered!" ;
              $(this).attr('disabled', 'true');
            }
          })

          $(".delete").each(function(){
            var value2 = this.value;
            if(value2 == event_id){
              this.style.display = "inline";
            }
          })

          $( "#delete{{$users->event_id}}" ).click(function() {
            var val = {{$users->id}};
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to unregister!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, unregister me!'
            }).then((result) => {
              if(result.value){
                $.ajax({
                  type: 'post',
                  url: '{{route('user_unregister')}}',
                  data: {
                    "_token": "{{ csrf_token() }}",
                    "id": val,
                  },
                  success: function (data) {
                    swal.fire({
                      title: "Success!",
                      text: "Event deleted!",
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
            });
          });
      @endforeach



      $(".event").click(function () {
        var updateId = this.value;
          //console.log(updateId);
        Swal.fire({
            type: "info",
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
