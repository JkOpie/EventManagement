@extends('layouts.app')

@section('content')

  <div id="page-container">
    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page">Event</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <ul class="list-group shadow-lg bg-white rounded">
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
              </li>
            </ul>
          </div>

          <div class="col-md-10 ">
            <!-- Website Overview -->
            <div class="card shadow-lg bg-white rounded" style="margin-bottom: 7%">
              <div class="card-header main-color-bg">
                <h3 class="card-title">Events</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-10">
                    <input class="form-control" type="text" id="search_input" placeholder="Filter Events by titles..." onkeyup="seacrhFunction()">
                  </div>
                  <div class="col-md-2">
                    <a class="btn btn-danger" href="event/create/1">Add Event</a>
                  </div>
                </div>
                <br>
                <table class="table table-borderless table-hover table-responsive table-striped" id="event_table">
                  <thead class="thead-dark">
                    <tr>
                      <th>Title</th>
                      <th>Banner</th>
                      <th>Description</th>
                      <th>Start Point</th>
                      <th>End Point</th>
                      <th>Date Created</th>
                      <th>Quota</th>
                      <th>Button</th>
                      <th>Runner</th>
                    </tr>
                  </thead >

                  @foreach ($event as $key => $events)
                    <tr>
                      <td>{{$events->event_name}}</td>
                      <td> <img src="{{url('uploads/'.$events->filename)}}" width="50px" height="50px"> </td>
                      <td style="max-width: 130px;">{{$events->event_des}}</td>
                      <td>{{$events->start_point}}</td>
                      <td>{{$events->end_point}}</td>
                      <td>{{$events->event_date}}</td>
                      <td>{{$events->quota}}</td>
                      <td><a class="btn btn-secondary" id="edit" href="/event/edit/{{$events->id}}">Edit</a>
                        <button class="btn btn-danger" id="delete{{$events->id}}" value="{{$events->id}}" href="#">Delete</i></button>
                      </td>
                      <td><button class="btn btn-danger view_runner" id="{{$events->id}}" value="{{$events->id}}" data-toggle="modal" data-target="#exampleModalLong">View Runner</button></td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>

            <br>

          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Runner Registered</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="append">

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>



  <footer id="footer">
    <p>Copyright NoProblem, &copy; 2019</p>
  </footer>

  <script type="text/javascript">
  $(document).ready(function() {
    @foreach ($event as $key => $events)

    $( "#{{$events->id}}" ).click(function(){
      var val = $("#{{$events->id}}").val()
      $.ajax({
        type: 'post',
        url: '/event/{{$events->id}}',
        data: {
          "_token": "{{ csrf_token() }}",
          "event_id": val,
        },
        success: function (data) {
            $('.append').html("");
          if(data.data.length == 0){

          }else{
            var tr_header = $('<tr>').append($('<th />', {text : 'Name'}))
            .append($('<th />', {text : 'Email'}))
            .append($('<th />', {text : 'Phone'}))
            .append($('<th />', {text : 'Date Joined'}))
            .append($('<th />', {text : 'Date Registered'}))
            .append($('<th />', {text : 'Edit'}));
            var thead = $('<thead>').attr({"class":"thead-dark"}).append(tr_header);
            var table = $("<table>").attr({"class":"table table-borderless table-hover table-responsive table-striped"}).append(thead);

            $('.append').append(table);
            $(data.data).each(function(){
              var button =  $("<a>").attr({"class":"btn btn-secondary","value":+this.id,"id":"useredit"+this.id, "href": "/runner/edit/"+this.id}).text("Edit");

              var tr_data = $('<tr>').append($('<td />', {text : this.name}))
              .append($('<td />', {text : this.email}))
              .append($('<td />', {text : this.phone}))
              .append($('<td />', {text : this.date_join}))
              .append($('<td />', {text : this.date_regis}))
              .append($('<td />', {html : button}));
              table.append(tr_data)
            })
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          swal.fire({
            title: "Oops!",
            text: "An error occurred",
          });
        }
      })
    });

    $( "#delete{{$events->id}}" ).click(function() {
      var val = $("#delete{{$events->id}}").val();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if(result.value){
          $.ajax({
            type: 'post',
            url: '{{route('event_delete')}}',
            data: {
              "_token": "{{ csrf_token() }}",
              "id": val,
            },
            success: function (data) {
              Swal.fire(
                  'Good job!',
                  'Event Deleted!',
                  'success'
                ).then((result)=>{
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
  });

  function seacrhFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search_input");
    filter = input.value.toUpperCase();
    table = document.getElementById("event_table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  </script>

</div>
@endsection
