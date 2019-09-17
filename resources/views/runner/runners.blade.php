@extends('layouts.app')

@section('content')

  <section id="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="active">Runner</li>
      </ol>
    </div>
  </section>

  <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <ul class="list-group shadow-lg">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a class="" href="/event">Event</a>
                <span class="badge badge-primary badge-pill">{{$event_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center  main-color-bg">
                  <a class="left-menu" href="/runner">Runner</a>
                <span class="badge badge-primary badge-pill">{{$user_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a class="" href="/runner/admin/1">Profile</a>
              </li>
            </ul>
          </div>
          <div class="col-md-10">
            <!-- Website Overview -->
            <div class="card bottom shadow-lg">
              <div class="card-header main-color-bg">
                <h3 class="card-title">Users</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-10">
                    <input class="form-control" type="text" placeholder="Filter Users..." id="search_input" onkeyup="seacrhFunction()">
                  </div>

                  <div class="col-md-2">
                    <a class="btn btn-danger" href="/runner/create">AddUser</a>
                  </div>
                </div>
                <br>
                <table class="table table-borderless  table-striped table-hover" id="user_table">
                  <thead class="thead-dark">
                    <tr>
                      <th>Name</th>
                      <th>Email</th>

                      <th>Date Joined</th>
                      <th>Button</th>

                    </tr>
                  </thead>
                  @foreach ($runner as $key => $runners)
                  <tr>
                    <td>{{ $runners->name }}</td>
                    <td>{{ $runners->email }}</td>
                    <td>{{ $runners->created_at }}</td>
                    <td><a class="btn btn-secondary" href="/runner/edit/{{$runners->id}}">Edit</a>
                      <button class="btn btn-danger" id="delete{{$runners->id}}" value="{{$runners->id}}" >Delete</button></td>
                  </tr>
                @endforeach

                </table>
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


    @foreach ($runner as $key => $runners)
    $( "#delete{{$runners->id}}" ).click(function() {
      var val = $("#delete{{$runners->id}}").val();
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
            url: '{{route('runner_delete')}}',
            data: {
              "_token": "{{ csrf_token() }}",
              "id": val,
            },
            success: function (data) {
              swal.fire({
                title: "Success!",
                text: "Event deleted!",
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
          });

    function seacrhFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search_input");
      filter = input.value.toUpperCase();
      table = document.getElementById("user_table");
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


@endsection
