var SERVER_URL = 'https://torpparintaival.stadi.ninja/logger.php';
var WAIT_TIME = 5000;

function get_refresh() {
  const metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('http-equiv') === "refresh") {
      return metas[i].getAttribute('content');
    }
  }

  return '';
}

function get_refresh_url() {
  var refresh_value = get_refresh();

  console.log(refresh_value);

  var re = /url=(.*)/;
  var urls = re.exec(refresh_value);
  if (urls.length > 1) {
    return urls[1];
  }

  return "";
}

function send_data (server_url, data) {
  // construct an HTTP request
  var xhr = new XMLHttpRequest();
  xhr.open('POST', server_url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // send the collected data as JSON
  xhr.send("data="+JSON.stringify(data));

  xhr.onloadend = function () {
    console.log("Logging data was sent");
  };
}

function goto_target (target_url) {
  window.open(target_url, "_self");
}

function on_load () {
  var target_url = get_refresh_url();

  var data = {
    'href': window.location.href,
    'referrer': document.referrer,
    'target': target_url
  };

  send_data(SERVER_URL, data);

  setTimeout(function () { goto_target(target_url); }, WAIT_TIME);
}
