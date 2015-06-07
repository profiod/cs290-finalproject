<?php 
    $url = 'http://api.wunderground.com/api/';
    $key = 'dc6a289427a4e5f2';
    $query = '/forecast/conditions/alerts';
    $format = '/q/autoip.json?geo_ip='; 
    $visitor_ip = $_SERVER['REMOTE_ADDR']; 
    $req = curl_init(); 
    curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($req, CURLOPT_URL, $url . $key . $query . $format . $visitor_ip);
    $result = curl_exec($req); 
    curl_close($req); 
    $result = json_decode($result);

    if ($result) {
        // current conditions
      $city = $result->current_observation->display_location->city;
      $state = $result->current_observation->display_location->state;
      $city_state = $city . "+" . $state; 
      $current_temp = $result->current_observation->temp_f; 
      $current_condition = $result->current_observation->weather; 
      $current_condition_img = $result->current_observation->icon_url; 
      echo "<div class='text-center'>
        <span><strong>Current Weather</strong></span>
        <div>
          <img style='width:100px;height:100px' src='$current_condition_img' alt='$current_condition'>
        </div>
        <span>$city, $state<br>$current_temp&#8457 - $current_condition</span>        
      </div><br/><br/>";
    }
?>

<?php 
echo "<div id='map' class='text-center'>
        <span><strong>Parks Near You</strong></span>
        <iframe
        width='400'
        height='225'
        frameborder='0' style='border:0'
        src='https://www.google.com/maps/embed/v1/search?key=AIzaSyCLS0RSxSG0ksNULSMXqJWA574oJSfhY-Y&q=parks+in+" . $city_state . "'>
        </iframe> </div>"; 
?>