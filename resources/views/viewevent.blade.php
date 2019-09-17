@extends('layouts.welcome')

@section('website_content')

  <section class="my-5">
    <div class="container">
      <div class="row">
        <div class="text-justify">
          <h1 class="text-center display-3" style="margin-top: 8%;">Event List</h1>
          <hr style="width:50%" class="divider">
          <br>
          <hr class="hidden">
          <h5>Registration Open</h5>
          <hr>
          <div class="row ">

            @foreach ($events_open as $key => $eo)
              <div class="col-md-6" style="padding-bottom:30px;">
                <a class="portfolio-item" href="/website/event/{{$eo->id}}">
                  <span class="caption">
                    <span class="caption-content">
                      <h2><span class="abit"><i class="far fa-calendar-alt fa-lg"></i></span>  {{$eo->event_date}}</h2>
                      <p class="mb-0"><span class="abit"><i class="fas fa-running "></i></span> {{$eo->event_name}}</p>
                      <p class="mb-0"><span class="abit"> <i class="fas fa-map-marker-alt"></i> </span>{{$eo->start_point}}</p>
                    </span>
                  </span>
                  <img class="img-fluid" src="{{url('uploads/'.$eo->filename)}}" alt="" style="width: 100%;height: 18rem;">
                </a>
              </div>
            @endforeach
          </div>
          <br>
          <h5>Registration Closed</h5>
          <hr>
            <div class="row ">
              @foreach ($events_closed as $key => $ec)
                <div class="col-md-6" style="padding-bottom:30px;">
                  <a class="portfolio-item" href="/website/event/{{$ec->id}}">
                    <span class="caption">
                      <span class="caption-content">
                        <h2><span class="abit"><i class="far fa-calendar-alt fa-lg"></i></span>  {{$ec->event_date}}</h2>
                        <p class="mb-0"><span class="abit"><i class="fas fa-running "></i></span> {{$ec->event_name}}</p>
                        <p class="mb-0"><span class="abit"> <i class="fas fa-map-marker-alt"></i> </span>{{$ec->start_point}}</p>
                      </span>
                    </span>
                    <img class="img-fluid" src="{{url('uploads/'.$ec->filename)}}"  style="width: 100%;height: 18rem;">
                  </a>
                </div>
              @endforeach
        </div>
      </div>
    </div>


  </section>

@endsection
