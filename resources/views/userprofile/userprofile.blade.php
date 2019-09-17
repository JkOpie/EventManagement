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
              <li class="list-group-item d-flex justify-content-between align-items-center ">
                  <a class="" href="/userdash">Dashboard</a>
                <span class="badge badge-primary badge-pill">{{$event_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                  <a class="" href="{{route('user_get_history')}}">Participation History</a>
                <span class="badge badge-primary badge-pill">{{$user_count}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center  main-color-bg">
                <a class="left-menu" href="/userprofile">Profile</a>
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
                <br>
                <table class="table">
                  <thead class="thead-dark">
                    <tr>

                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Date Join</th>
                      <th>Button</th>
                    </tr>
                  </thead>
                  <tr>
                    <td>{{ Auth::user()->name  }}</td>
                    <td>{{ Auth::user()->email }}</td>
                    <td>{{ Auth::user()->phone}}</td>
                    <td>{{ Auth::user()->date_join}}</td>
                    <td><a class="btn btn-secondary" href="/userprofile/edit/{{Auth::user()->id}}">Edit</a></td>
                  </tr>
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


@endsection
