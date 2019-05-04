var map = null;
var geo_watch_id;
var geo_location_circle = null;

var MARKERS = {
  '1': [60.265326935, 24.949261050],
  '2': [60.268234233, 24.949079078],
  '3': [60.268744727, 24.931038393]
}

function map_init () {
  map = new L.Map('map', {
      zoomControl: true
  });

  L.tileLayer('https://tiles.kartat.kapsi.fi/peruskartta/{z}/{x}/{y}.png', {
      attribution: '&copy; Karttamateriaali <a href="http://www.maanmittauslaitos.fi/avoindata">Maanmittauslaitos</a>',
      maxZoom: 18,
      minZoom: 0,
  }).addTo(map);
}

function add_markers (markers) {
  for (var key in markers) {
    if (!markers.hasOwnProperty(key)) continue;

    var latlon = markers[key];

    L.marker(latlon, {title: key}).addTo(map);
  }
}

function draw_route (markers) {
  var route_points = [];

  for (var key in markers) {
    if (!markers.hasOwnProperty(key)) continue;

    route_points.push(markers[key]);
  }

  var polyline = L.polyline(route_points, {color: 'red'}).addTo(map);
  map.fitBounds(polyline.getBounds());
}

function follow_my_location () {
  var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 5000
  };

  geo_watch_id = navigator.geolocation.watchPosition(location_update, location_error);
}

function location_update(pos) {
  if (geo_location_circle != null) {
    geo_location_circle.remove();
  }

  var radius = pos.coords.accuracy / 2;

  if (radius < 20) {
    radius = 20;
  }

  if (radius < 500) {
    geo_location_circle = L.circle([pos.coords.latitude, pos.coords.longitude], radius);
    geo_location_circle.addTo(map);
  }
}

function location_error(error) {
  console.log("Location error");
}

function on_load () {
  map_init();

  if (navigator.geolocation) {
    follow_my_location();
  }
  else {
    console.log("Geolocation is not supported by the browser");
  }

  add_markers(MARKERS);
  draw_route(MARKERS);
}
