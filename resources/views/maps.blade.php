<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />

    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>

    <title>Document</title>
</head>

<body>
    <div>
        <!-- Menggunakan form dengan metode POST -->
        <!-- Menggunakan form dengan metode POST -->
        <form action="{{ route('maps') }}" method="POST">
            @csrf
            <input type="text" name="subsidiary" value="{{ $subsidiary }}">

            <button type="submit">Kirim</button>
        </form>

    </div>
    <div id="map" style="height: 400px;"></div>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        const coordinates = <?php echo json_encode($coordinates); ?>;

        const map = L.map('map').setView([coordinates.latitude, coordinates.longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        L.marker([coordinates.latitude, coordinates.longitude]).addTo(map);
    </script>

</body>

</html>