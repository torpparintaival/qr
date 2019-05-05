var map = null;
var geo_watch_id;
var geo_location_circle = null;

var MARKERS = {
  '1': [60.264847781, 24.950164246],
  '2': [60.267410277, 24.952549631],
  '3': [60.267935274, 24.953977729],
  '4': [60.268370124, 24.959121669],
  '5': [60.270626505, 24.957729830],
  '6': [60.271850523, 24.956257539],
  '7': [60.272819158, 24.955466544],
  '8': [60.275452360, 24.950788242],
  '9': [60.274223949, 24.943139593],
  '10': [60.273932043, 24.937754449],
  '11': [60.272203046, 24.938159858],
  '12': [60.270431312, 24.939746858],
  '13': [60.270170307, 24.939828366],
  '14': [60.269374840, 24.940196621],
  '15': [60.266026266, 24.942504356]
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
