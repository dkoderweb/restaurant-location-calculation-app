<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant Management</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12 text-right">
                <a href="{{ route('restaurants.create') }}" class="btn btn-primary">Add Restaurant</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Restaurant List (Current user login)</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th> 
                            <th>Range (km)</th>
                            <th>Distance from User (km)</th>
                            <th>Delivery Possibility</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($restaurants as $restaurant)
                            <tr>
                                <td>{{ $restaurant->name }}</td> 
                                <td>{{ $restaurant->range }}</td>
                                <td id="distance{{ $restaurant->id }}"></td>
                                <td id="delivery{{ $restaurant->id }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>

    function initMap() {
        getUserLocation().then(userLocation => {
            const restaurants = {!! json_encode($restaurants) !!};

            restaurants.forEach(restaurant => {
                const restaurantLocation = { lat: parseFloat(restaurant.latitude), lng: parseFloat(restaurant.longitude) };
                const distance = calculateDistance(userLocation, restaurantLocation);
                const deliveryPossible = isDeliveryPossible(distance, restaurant.range);

                $(`#distance${restaurant.id}`).text(distance.toFixed(2));
                $(`#delivery${restaurant.id}`).text(deliveryPossible ? 'Yes' : 'No');
            });
        });
    }

    function getUserLocation() {
        return new Promise((resolve, reject) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        resolve(userLocation);
                    },
                    error => {
                        console.error(error.message); 
                    }
                );
            } else {
                console.error('server error'); 
            }
        });
    }

    function calculateDistance(location1, location2) {
        const earthRadius = 6371;  
        const dLat = degToRad(location2.lat - location1.lat);
        const dLng = degToRad(location2.lng - location1.lng);

        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(degToRad(location1.lat)) * Math.cos(degToRad(location2.lat)) *
                  Math.sin(dLng / 2) * Math.sin(dLng / 2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        const distance = earthRadius * c;
        return distance;
    }

    function degToRad(deg) {
        return deg * (Math.PI / 180);
    }

    function isDeliveryPossible(distance, range) {
        return distance <= range;
    }

    $(document).ready(function() {
        initMap();
    });
</script>


</body>
</html>
