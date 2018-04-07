<?php
$username = ''; # Put your BMW username here
$password = ''; # Put your password here
$email = ''; # Put the email here you would like to send the status to.
$googleMapsKey = ''; # Put your google maps key here if you want to know where your car is (OPTIONAL)

$loginUrl = 'https://connecteddrive.bmwusa.com/cdp/release/internet/servlet/login';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $loginUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'timezoneOffset=420&actiontype=login&username='.$username.'&password='.$password);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$store = curl_exec($ch);

//set the URL to the protected file
curl_setopt($ch, CURLOPT_URL, 'https://connecteddrive.bmwusa.com/cdp/release/internet/servlet/dashboard');
$content = curl_exec($ch);

$string_offset = strpos($content, '<span class="symbolImage batterie"></span><span>');
$percentage = substr($content, $string_offset + 48, 4);

// Get the Battery Kappa and Geolocation
curl_setopt($ch, CURLOPT_URL, 'https://connecteddrive.bmwusa.com/cdp/release/internet/servlet/eNavigation');
$content = curl_exec($ch);
$string_offset = strpos($content, 'socMax = ');
$battery_kappa = substr($content, $string_offset + 10, 4);

$string_offset = strpos($content, '_lat = ');
$lat = substr($content, $string_offset + 8, 8);

$string_offset = strpos($content, '_lng = ');
$long = substr($content, $string_offset + 8, 8);

if (!empty($googleMapsKey)) {
  curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $long . '&key=' . $googleMapsKey);
  $content = curl_exec($ch);
  $content_json = json_decode($content);
  $address = $content_json->results[0]->formatted_address;
}
else {
  $address = 'Unknown';
}

if ($percentage == 'onte') {
  mail($email, 'BMW i3 Status', 'Vehicle in Motion. Battery Kappa: ' . $battery_kappa . '. Location: ' . $address);
}
else {
  mail($email, 'BMW i3 Status', 'Currently at ' . $percentage . '. Battery Kappa: ' . $battery_kappa . '. Location: ' . $address);
}
