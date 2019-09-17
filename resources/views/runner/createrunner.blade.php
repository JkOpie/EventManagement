@extends('layouts.app')

@section('content')

  <section id="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('runner')}}">Runner</a></li>
        <li class="breadcrumb-item" aria-current="page">Create</li>
      </ol>
      @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>

          @endforeach
        </ul>
      </div>
    @endif
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
                <form  method="post" action="{{ route('runner_store') }}"  id="create" autocomplete="off">
                    @csrf

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>UserName</label>
                      <input type="text" class="form-control" placeholder="Enter Username Here" name="name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" placeholder="Enter Email Here" name="email" required>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pnumber">Phone Number</label>
                      <input type="text" class="form-control" placeholder="Enter P.Number Here" name="phone" required>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date">Date Joined</label>
                      <input type='text' data-timepicker="true" data-language='en' data-time-format='hh:ii:AA' data-date-format="yyyy mm dd"  class="datepicker-here form-control" name="date_join" placeholder="Enter Date Joined"  required>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pass">Password</label>
                      <div class="input-group mb-3">
                          <input type="password" class="form-control" placeholder="Enter Password Here" id="password" name="password" required>
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="password_toogle()"><i class="fas fa-eye" id="p_eye"></i></button>
                          </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pass">Confirm Password</label>
                      <div class="input-group mb-3">
                          <input type="password" class="form-control" placeholder="Enter Password Here" id="confirm_password" name="confirmpassword" required>
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="confirm_password_toogle()"><i class="fas fa-eye" id="cp_eye"></i></button>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                  </div>
                  <div class="col-md-6">
                    <div class="form-group text-right">
                      <input type="submit" class="btn btn-danger" style="width:200px;" value="Register" required>
                    </div>
                  </div>
                </div>
                <form>
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

      var myForm = $("form#create");
      myForm.submit(function(e) {
          e.preventDefault();
          $.ajax({
              type: 'post',
              url: myForm.attr('action'),
              data: myForm.serialize(),
              success: function(data) {
                Swal.fire(
                  'Good job!',
                  'User Created Successfully!',
                  'success'
                ).then((result) => {
                window.location.href = "{{route('runner')}}";
            })
          },
              error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire(
                  'Error!',
                  'User Name Already IN Database!',
                  'error'
                ).then((result) => {
                location.reload();
            })
              }
          });
      });

    });

    function confirm_password_toogle() {
      var x = document.getElementById("confirm_password");
      var p = $('#cp_eye');
      if (x.type === "password") {
        x.type = "text";
        p.removeClass('fas fa-eye');
        p.addClass('fas fa-eye-slash');
      } else {
        x.type = "password";
        p.removeClass('fas fa-eye-slash');
        p.addClass('fas fa-eye');
      }
    }

    function password_toogle() {
      var x = document.getElementById("password");
      var p = $('#p_eye');
      if (x.type === "password") {
        x.type = "text";
        p.removeClass('fas fa-eye');
        p.addClass('fas fa-eye-slash');
      } else {
        x.type = "password";
        p.removeClass('fas fa-eye-slash');
        p.addClass('fas fa-eye');
      }
    }


    </script>
@endsection
