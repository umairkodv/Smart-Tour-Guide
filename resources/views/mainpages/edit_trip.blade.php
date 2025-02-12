@extends('layout.master')
@section('title', 'Edit Trip')
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
    </style>
@endpush
<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url({{ asset('assets/images/inner-banner.jpg') }});">
       <div class="container">
          <div class="inner-banner-content">
             <h1 class="inner-title">Edit Trip</h1>
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
        <form action="{{ route('update_trip', ['id'=>$trip->id]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label">Destination City</label>
                        <input id="city-input" name="destination" type="text" placeholder="Enter a city" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label">Start Date</label>
                        <input  name="start_date"  type="date" placeholder="Start Date" required value="{{$trip->start_date}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label">End Date</label>
                        <input name="end_date" type="date" placeholder="End Date"  required value="{{$trip->end_date}}">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="form-label h-label">Select Point of Interest</label>
                        <div class="point_of_interest" id="point_of_interest">

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="form-label h-label">Select Hotel</label>
                        <div class="point_of_interest" id="list_hotels">

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="form-label h-label">Select Food and Experices</label>
                        <div class="point_of_interest" id="foods">

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="button-primary">Edit Trip</button>
                </div>
            </div>
        </form>
    </div>
 </section>
@endsection

@push('scripts')
<script>
    const apiKey = "{{config('app.google_map_api_key')}}";
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_api_key')}}&libraries=places"></script>
<script>
    let selected_interest = "{{($trip->itineries()->where('key','point_of_interest')->first()->value)??''}}";
    if(selected_interest){
        selected_interest = selected_interest.split(',');
    }
    let selected_hotel = "{{($trip->itineries()->where('key','hotel')->first()->value)??''}}";
    if(selected_hotel){
        selected_hotel = selected_hotel.split(',');
    }
    let selected_food = "{{($trip->itineries()->where('key','foods')->first()->value)??''}}";
    if(selected_food){
        selected_food = selected_food.split(',');
    }
    $(document).ready(function(){
        initAutocomplete();
    });

    function searchPlaces(apiKey, query, type = null) {
        const baseUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json";

        let url = new URL(baseUrl);
        url.searchParams.append('key', apiKey);
        url.searchParams.append('query', query);
        // url.searchParams.append('type','point_of_interest');

        if (type) {
            url.searchParams.append('type', type);
        }

        return fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'OK') {
                    return data.results;
                } else {
                    console.error(`Error: ${data.status}`);
                    return null;
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                return null;
            });
    }

    // show point of interest
    function showPointOfInterest(apiKey,destination){
        const placesPromise = searchPlaces(apiKey, "Iconic places in "+destination,"point_of_interest");
        let html = 'No Resut Found';
        placesPromise.then(places => {
            if (places) {
                html = "";
                console.log('places',places);
                places.forEach(place => {
                    var photos = place.photos;
                    if(photos){
                        photos =  photos[0];
                    }
                    let rating_html = '';
                    let rating = place.rating;
                    if(rating){
                        rating = rating.toFixed(1);
                        let rating_split = rating.split('.')??[];
                        if(rating_split[0]){
                            let rating_0 = rating_split[0];
                            for (let index = 0; index < rating_0; index++) {
                                rating_html+=' <i class="fas fa-star"></i> ';
                            }
                        }
                        if(rating_split[1]){
                            if(rating_split[1]>0&&rating_split[1]<=9){
                                rating_html+=' <i class="fas fa-star-half-alt"></i> ';
                            }
                        }
                    }
                    let hotels_url = `{{route('hotels')}}`;
                    hotels_url = new URL(hotels_url);
                    hotels_url.searchParams.append('place', place.name);
                    let checked = false;
                    if(selected_interest.includes(place.name)){
                        checked =true;
                    }

                    html+=`<div class="card my-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="flexCheckDefault${place.name}" name="point_of_interest[]" value="${place.name}" ${checked?'checked':''}>
                                        <label class="form-check-label" for="flexCheckDefault${place.name}">
                                            ${place.name}
                                        </label>
                                        </div>
                                        <div><span>${rating}</span> ${rating_html} (${place.user_ratings_total})</div>
                                        <div class="address"> <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg> ${place.formatted_address}</div>
                                    </div>
                                    <div class="col-lg-4 text-lg-right">
                                        <img src="${photos?'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='+photos.photo_reference+'&sensor=false&key='+apiKey:''}" class="img-fluid" style="height: 140px">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
            }
            $(document).find('#point_of_interest').html(html);
        });
    }

    // show hotels
    function showHotels(apiKey,destination){
        const placesPromise = searchPlaces(apiKey, "hotels in "+destination,"point_of_interest");
        let html = 'No Resut Found';
        placesPromise.then(places => {
            if (places) {
                html = "";
                console.log('places',places);
                places.forEach(place => {
                    var photos = place.photos;
                    if(photos){
                        photos =  photos[0];
                    }
                    let rating_html = '';
                    let rating = place.rating;
                    if(rating){
                        rating = rating.toFixed(1);
                        let rating_split = rating.split('.')??[];
                        if(rating_split[0]){
                            let rating_0 = rating_split[0];
                            for (let index = 0; index < rating_0; index++) {
                                rating_html+=' <i class="fas fa-star"></i> ';
                            }
                        }
                        if(rating_split[1]){
                            if(rating_split[1]>0&&rating_split[1]<=9){
                                rating_html+=' <i class="fas fa-star-half-alt"></i> ';
                            }
                        }
                    }
                    let hotels_url = `{{route('hotels')}}`;
                    hotels_url = new URL(hotels_url);
                    hotels_url.searchParams.append('place', place.name);
                    let checked = false;
                    if(selected_hotel.includes(place.name)){
                        checked =true;
                    }

                    html+=`<div class="card my-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" id="flexCheckDefault${place.name}" name="hotel" value="${place.name}" ${checked?'checked':''}>
                                        <label class="form-check-label" for="flexCheckDefault${place.name}">
                                            ${place.name}
                                        </label>
                                        </div>
                                        <div><span>${rating}</span> ${rating_html} (${place.user_ratings_total})</div>
                                        <div class="address"> <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg> ${place.formatted_address}</div>
                                    </div>
                                    <div class="col-lg-4 text-lg-right">
                                        <img src="${photos?'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='+photos.photo_reference+'&sensor=false&key='+apiKey:''}" class="img-fluid" style="height: 140px">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
            }
            $(document).find('#list_hotels').html(html);
        });
    }

    // show foods
    function showFoods(apiKey,destination){
        const placesPromise = searchPlaces(apiKey, "foods in "+destination,"foods");
        let html = 'No Resut Found';
        placesPromise.then(places => {
            if (places) {
                html = "";
                console.log('places',places);
                places.forEach(place => {
                    var photos = place.photos;
                    if(photos){
                        photos =  photos[0];
                    }
                    let rating_html = '';
                    let rating = place.rating;
                    if(rating){
                        rating = rating.toFixed(1);
                        let rating_split = rating.split('.')??[];
                        if(rating_split[0]){
                            let rating_0 = rating_split[0];
                            for (let index = 0; index < rating_0; index++) {
                                rating_html+=' <i class="fas fa-star"></i> ';
                            }
                        }
                        if(rating_split[1]){
                            if(rating_split[1]>0&&rating_split[1]<=9){
                                rating_html+=' <i class="fas fa-star-half-alt"></i> ';
                            }
                        }
                    }
                    let hotels_url = `{{route('hotels')}}`;
                    hotels_url = new URL(hotels_url);
                    hotels_url.searchParams.append('place', place.name);
                    let checked = false;
                    if(selected_food.includes(place.name)){
                        checked =true;
                    }
                    html+=`<div class="card my-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="${place.name}" id="flexCheckDefault${place.name}" name="foods[]" ${checked?'checked':''}>
                                        <label class="form-check-label" for="flexCheckDefault${place.name}">
                                            ${place.name}
                                        </label>
                                        </div>
                                        <div><span>${rating}</span> ${rating_html} (${place.user_ratings_total})</div>
                                        <div class="address"> <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg> ${place.formatted_address}</div>
                                    </div>
                                    <div class="col-lg-4 text-lg-right">
                                        <img src="${photos?'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='+photos.photo_reference+'&sensor=false&key='+apiKey:''}" class="img-fluid" style="height: 140px">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
            }
            $(document).find('#foods').html(html);
        });
    }

// Example usage
const userQuery = $(document).find('input[name=place]').val();
function initAutocomplete() {
    let destination = "{{$trip->destination}}";
    showPointOfInterest(apiKey,destination);
        showHotels(apiKey,destination);
        showFoods(apiKey,destination);
    var input = document.getElementById('city-input');
    input.value=destination
    var autocomplete = new google.maps.places.Autocomplete(input, {
      types: ['(cities)'],
      componentRestrictions: { country: 'PK' }  // 'PK' is the ISO 3166-1 alpha-2 country code for Pakistan
    });

    // $(document).find('input[ name="destination"]').val("{{$trip->destination}}").trigger('place_changed');
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
        showPointOfInterest(apiKey,place.name);
        showHotels(apiKey,place.name);
        showFoods(apiKey,place.name);
    });

  }
</script>
@endpush
