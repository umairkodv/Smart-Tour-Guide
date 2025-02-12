@extends('layout.master')
@section('title', 'View Trip')
@section('content')
@push('styles')
    <style>
        .point_of_interest{
            max-height: 500px;
            overflow-y: auto;
        }
        .h-label{
            font-weight: 700;
            font-size: 28px;
        }
        .itinery-title{
            font-weight: 700;
            font-size: 16px;
            text-transform: capitalize;
        }
        .itinery-details{
            display: flex;
            flex-direction: column
        }
        .itinery-details a{
            padding: 10px;
            box-shadow: 2px 2px 10px #00000042;
            margin: 10px 0;
            border-radius: 8px;
            color: #8d8d8d;
        }
        .itinery-details a:hover{
            color: #0e0e0e;
            box-shadow: none;
            box-shadow: 2px 2px 8px #00000042;
        }
    </style>
@endpush
<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url({{ asset('assets/images/inner-banner.jpg') }});">
       <div class="container">
          <div class="inner-banner-content">
             <h1 class="inner-title">View Trip</h1>
          </div>
       </div>
    </div>
    <div class="inner-shape"></div>
 </section>
 <section class="inner-banner-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Trip Details</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {{-- map --}}
                <div id="map" style="height: 400px;"></div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mb-0">{{$trip->destination}}</h4>
                        <div class="dates">
                            {{Carbon\Carbon::parse($trip->start_date)->format('jS, M Y')}} <span style="font-weight: 700;font-size:14px">-</span> {{Carbon\Carbon::parse($trip->end_date)->format('jS, M Y')}}
                        </div>
                    </div>
                </div>
                <hr>
                @if ($trip->itineries)
                <div class="row">
                    @foreach ($trip->itineries as $itinery)
                        <div class="col-12">
                            <label for="" class="itinery-title">{{ str_replace("_", " ", $itinery->key)  }}</label>
                            @php
                                $values = explode(',',$itinery->value);
                            @endphp
                            <div class="itinery-details">
                                @foreach ($values as $value)
                                <a href="javascript:void(0)" class="show_route" data-end="{{$value}}">{{$value}}</a>
                            @endforeach
                            </div>
                            <hr>
                        </div>

                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
 </section>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_api_key')}}&libraries=places"></script>
<script>
var map;

// Function to initialize the map with the current location
function initMap() {
  // Default coordinates (for example, the center of Pakistan)
  var defaultLatLng = { lat: 30.3753, lng: 69.3451 };

  // Create a new map centered at the default coordinates
  map = new google.maps.Map(document.getElementById('map'), {
    center: defaultLatLng,
    zoom: 8  // Adjust the zoom level as needed
  });

  // Check if the browser supports geolocation
  if (navigator.geolocation) {
    // Request location permission
    navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
      if (result.state === 'granted') {
        // Permission granted, get current position
        navigator.geolocation.getCurrentPosition(function(position) {
          var currentLatLng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          // Center the map at the current location
          map.setCenter(currentLatLng);

          // Add a marker at the current location
          var marker = new google.maps.Marker({
            position: currentLatLng,
            map: map,
            title: 'Current Location'
          });
        }, function() {
          // Handle geolocation error
          console.error('Error: The Geolocation service failed.');
        });
      } else if (result.state === 'prompt') {
        // Permission not granted, but the user hasn't made a decision yet
        console.log('Waiting for user decision on geolocation permission.');
      } else {
        // Permission denied
        console.error('Error: Geolocation permission denied.');
      }
    });
  } else {
    // Browser doesn't support geolocation
    console.error('Error: Your browser doesn\'t support geolocation.');
  }
}

// Call the initMap function when the page loads
document.addEventListener('DOMContentLoaded', function() {
  initMap();
});

$(document).on('click', 'a.show_route', function() {
  // Directions service instance
  var directionsService = new google.maps.DirectionsService();
  var directionsRenderer = new google.maps.DirectionsRenderer();
  directionsRenderer.setMap(map);

  let end = $(this).data('end');
  // Get route between two points
  calculateAndDisplayRoute(directionsService, directionsRenderer, end);
});

// Function to calculate and display the route
function calculateAndDisplayRoute(directionsService, directionsRenderer, end) {
  // Try HTML5 geolocation
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var currentLatLng = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      // Set the starting point for directions
      var start = new google.maps.LatLng(currentLatLng.lat, currentLatLng.lng);

      // Replace the destination with your desired endpoint
      // var end = 'Lahore, Pakistan';

      directionsService.route(
        {
          origin: start,
          destination: end,
          travelMode: 'DRIVING' // You can also use 'WALKING', 'BICYCLING', or 'TRANSIT'
        },
        function(response, status) {
          if (status === 'OK') {
            directionsRenderer.setDirections(response);
          } else {
            console.error('Error:', status);
          }
        }
      );
    }, function() {
      // Handle geolocation error
      console.error('Error: The Geolocation service failed.');
      alert("The Geolocation service failed");
    });
  } else {
    // Browser doesn't support geolocation
    console.error('Error: Your browser doesn\'t support geolocation.');
  }
}
</script>

@endpush
