<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Include Bootstrap CSS and JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <!-- Include Leaflet CSS for styling -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Add Restaurant</h2>
                <form>
                    <div class="form-group">
                        <label for="restaurantName">Name:</label>
                        <input type="text" class="form-control" id="restaurantName" required>
                        <small class="text-danger" id="nameError"></small>
                    </div>
                    <div class="form-group">
                        <label for="map">Select Location:</label>
                        <div id="map" style="height: 300px;"></div>
                        <small class="text-danger" id="latitudeError"></small>
                        <small class="text-danger" id="longitudeError"></small>
                    </div>
                    <div class="form-group">
                        <label for="range">Range (km):</label>
                        <input type="number" class="form-control" id="range" required>
                        <small class="text-danger" id="rangeError"></small>
                    </div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <button type="button" class="btn btn-primary" onclick="saveRestaurant()">Save Restaurant</button>
                </form>
            </div>
        </div>
    </div>


     <script>
        let map;

        function initMap() {
            map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker;

            map.on('click', function (e) {
                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker(e.latlng).addTo(map);
                $('#latitude').val(e.latlng.lat);
                $('#longitude').val(e.latlng.lng);

                $('#nameError').text('');
                $('#latitudeError').text('');
                $('#longitudeError').text('');
                $('#rangeError').text('');
            });

            navigator.geolocation.getCurrentPosition(function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                map.setView([userLat, userLng], 13);  

                L.marker([userLat, userLng]).addTo(map)
                    .bindPopup('Your Location')
                    .openPopup();
            });
        }

        function saveRestaurant() {
            const name = $('#restaurantName').val();
            const latitude = $('#latitude').val();
            const longitude = $('#longitude').val();
            const range = $('#range').val();

            $.ajax({
                type: 'POST',
                url: '{{ route("save-restaurant") }}',  
                data: {
                    name: name,
                    latitude: latitude,
                    longitude: longitude,
                    range: range,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.success); 

                    toastr.success(response.success) 
                    setTimeout(function () {
                        window.location.href = '/';
                    }, 2000);

                },
                error: function(xhr, status, error) {
                    const response = xhr.responseJSON;

                    $('#nameError').text(response.errors.name ? response.errors.name[0] : '');
                    $('#latitudeError').text(response.errors.latitude ? response.errors.latitude[0] : '');
                    $('#longitudeError').text(response.errors.longitude ? response.errors.longitude[0] : '');
                    $('#rangeError').text(response.errors.range ? response.errors.range[0] : '');
                }
            });
        }

        $(document).ready(function() {
            initMap();
        });
    </script>
</body>
</html>
