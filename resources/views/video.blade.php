@extends('layouts.welcome')

@section('website_content')

  <header class="masthead text-white" style="margin-top:77px" >
    <div class="overlay"></div>
    <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-12 text-center">
          <h1 style="font-weight:bolder;font-size:80px;" >RUN</h1>
          <h1 style="font-weight:bolder;font-size:80px;">JUST <i> <small>KEEP</small> </i></h1>
          <h1 style="font-weight:bolder;font-size:80px;">RUNNING</h1>
          <p class="lead">10,000 step a day keep doctor a way</p>
          <a  class="btn btn-danger btn-lg" href="/website/event">View Event</a>
        </div>
      </div>
    </div>
  </header>

<div class="sta_wrapper">
  <div class="container ">
      <div class="row">
          <br />
          <div class="col-md-12 text-center" style="margin-top:5%">
            <h1 class="display-3">Statistics</h1>
              <hr  class="divider" style="width:50%">
                <br>
          </div>
      </div>
      <div class="row text-center">

          <div class="col-md-4 my-2">
              <div class="counter ">
                <i class="fas fa-running fa-2x"></i>
                  <h2 class="timer count-title count-number" data-to="{{$runner_count}}" data-speed="1500"></h2>
                  <hr>
                  <p class="count-text lead mb-0 ">Runners Registered</p>
              </div>
          </div>
          <div class="col-md-4 my-2">
              <div class="counter">
                  <i class="fas fa-calendar-check fa-2x"></i>
                  <h2 class="timer count-title count-number" data-to="{{$event_count}}" data-speed="1500"></h2>
                  <hr>
                  <p class="count-text lead mb-0">Event Created</p>
              </div>
          </div>
          <div class="col-md-4 my-2">
              <div class="counter">
                  <i class="fas fa-eye fa-2x"></i>
                  <h2 class="timer count-title count-number" data-to="100" data-speed="1500"></h2>
                  <hr>
                  <p class="count-text lead mb-0">Website View</p>
              </div>
          </div>

      </div>
  </div>
</div>


<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="text-justify">
                <h1 class="text-center display-3">Newest Event</h1>
                <hr style="width:50%" class="divider">
                <a href="/website/event" class="float-right" style="color: #000;font-weight: bold;font-size:16px;line-height:24px;">View More <i class="fas fa-angle-double-right"></i></a>
                <br>
                <hr class="hidden">
                <div class="row no-gutters" id="event">
                    @foreach ($events as $key => $events)
                    <div class="col-lg-6">
                        <a class="portfolio-item"  href="/website/event/{{$events->id}}">
                            <span class="caption">
                                <span class="caption-content">
                                    <h2><span class="abit"><i class="far fa-calendar-alt fa-lg"></i></span> {{$events->event_date}}</h2>
                                    <p class="mb-0"><span class="abit"><i class="fas fa-running "></i></span> {{$events->event_name}}</p>
                                    <p class="mb-0"><span class="abit"> <i class="fas fa-map-marker-alt"></i> </span>{{$events->start_point}}</p>
                                </span>
                            </span>
                            <img class="img-fluid" src="{{url('uploads/'.$events->filename)}}" alt="" style="width: 100%;height: 18rem;">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<div class="sta_wrapper_background">
<div class="overlay"></div>
  <section id="contact" >
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 class="display-3 my-5">Let's Get In Touch!</h2>
            <hr class="divider my-4">
            <p class="lead mb-0">If you have any question or want to start your next running event with us? Give us a call or send us an email and we will get back to you as soon as possible!</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
            <i class="fas fa-phone fa-3x mb-3 "></i>
            <div class="lead mb-0">03-8921 2020</div>
          </div>
          <div class="col-lg-4 mr-auto text-center">
            <i class="fas fa-envelope fa-3x mb-3 "></i>
            <!-- Make sure to change the email address in anchor text AND the link below! -->
            <a class="d-block lead mb-0" href="mailto:contact@Noproblem.com">contact@Noproblem.com</a>
          </div>
        </div>
      </div>
    </section>
</div>



<script type="text/javascript">
ScrollReveal().reveal('#event', { delay: 500 });
ScrollReveal().reveal('#contact', { delay: 600 });
//ScrollReveal().reveal('.sta_wrapper_background', { delay: 500 });
(function ($) {
  $.fn.countTo = function (options) {
    options = options || {};

    return $(this).each(function () {
      // set options for current element
      var settings = $.extend({}, $.fn.countTo.defaults, {
        from: $(this).data('from'),
        to: $(this).data('to'),
        speed: $(this).data('speed'),
        refreshInterval: $(this).data('refresh-interval'),
        decimals: $(this).data('decimals')
      }, options);

      // how many times to update the value, and how much to increment the value on each update
      var loops = Math.ceil(settings.speed / settings.refreshInterval),
      increment = (settings.to - settings.from) / loops;

      // references & variables that will change with each update
      var self = this,
      $self = $(this),
      loopCount = 0,
      value = settings.from,
      data = $self.data('countTo') || {};

      $self.data('countTo', data);

      // if an existing interval can be found, clear it first
      if (data.interval) {
        clearInterval(data.interval);
      }
      data.interval = setInterval(updateTimer, settings.refreshInterval);

      // initialize the element with the starting value
      render(value);

      function updateTimer() {
        value += increment;
        loopCount++;

        render(value);

        if (typeof(settings.onUpdate) == 'function') {
          settings.onUpdate.call(self, value);
        }

        if (loopCount >= loops) {
          // remove the interval
          $self.removeData('countTo');
          clearInterval(data.interval);
          value = settings.to;

          if (typeof(settings.onComplete) == 'function') {
            settings.onComplete.call(self, value);
          }
        }
      }

      function render(value) {
        var formattedValue = settings.formatter.call(self, value, settings);
        $self.html(formattedValue);
      }
    });
  };

  $.fn.countTo.defaults = {
    from: 0, // the number the element should start at
    to: 0, // the number the element should end at
    speed: 1000, // how long it should take to count between the target numbers
    refreshInterval: 100, // how often the element should be updated
    decimals: 0, // the number of decimal places to show
    formatter: formatter, // handler for formatting the value before rendering
    onUpdate: null, // callback method for every time the element is updated
    onComplete: null // callback method for when the element finishes updating
  };

  function formatter(value, settings) {
    return value.toFixed(settings.decimals);
  }
}(jQuery));


jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });

  // start all the timers
  $('.timer').each(count);

  function count(options) {
    var $this = $(this);
    options = $.extend({}, options || {}, $this.data('countToOptions') || {});
    $this.countTo(options);
  }
});




</script>
@endsection
