<?php 
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);  
  session_start(); 
  $properEntry = true; 
  /* adapted from OSU CS 290 lecture PHP Sessions 
   http://eecs.oregonstate.edu/ecampus-video/player/player.php?id=66 */
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // use explode to extract the filepath into an array without the filename
    $filePath = explode("/", $_SERVER["PHP_SELF"], -1); 
    // use implode to combine the array back together now that is lacks the filename
    $filePath = implode("/", $filePath); 
    // prepend http and append the file path onto the http host value creating a valid uri
    $redirect = "http://" . $_SERVER["HTTP_HOST"] . $filePath; 
    // set the http header equal to the redirect so that the file redirects
    header("Location: {$redirect}/welcome.php"); 
    $properEntry = false;  
  }
  // else if 
  else if (empty($_POST["username"]) && empty($_POST["signup_username"])) {
    // use explode to extract the filepath into an array without the filename
    $filePath = explode("/", $_SERVER["PHP_SELF"], -1); 
    // use implode to combine the array back together now that is lacks the filename
    $filePath = implode("/", $filePath); 
    // prepend http and append the file path onto the http host value creating a valid uri
    $redirect = "http://" . $_SERVER["HTTP_HOST"] . $filePath; 
    // set the http header equal to the redirect so that the file redirects
    header("Location: {$redirect}/welcome.php"); 
    $properEntry = false;  
  }

  function inDB($username) {
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu","profiod-db","YdvEBCHZy4pJfAwO","profiod-db"); 
    if (!$mysqli || $mysqli->connect_errno) 
      echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error ;

    $stmt = $mysqli->prepare("SELECT username FROM user_info WHERE username = ? ORDER BY username");

    $stmt->bind_param('s', $username); 

    $stmt->execute(); 

    if (!$stmt) 
      echo "Error with query: " . $stmt->error;

    $stmt->bind_result($username); 

    while ($stmt->fetch()) {
      $stmt->close(); 
      $mysqli->close(); 
      return true; 
    }
    
    $stmt->close(); 
    $mysqli->close(); 
    return false;
  }

  if ($properEntry) {
    if($_GET["action"] == "signup") {
      if (!inDB($_POST["signup_username"])) {
        $user_password = md5($_POST["signup_password"]); 
        $frst_name = $_POST["first_name"]; 
        $last_name = $_POST["last_name"]; 
        $mysqli = new mysqli("oniddb.cws.oregonstate.edu","profiod-db","YdvEBCHZy4pJfAwO","profiod-db"); 
        
        if (!$mysqli || $mysqli->connect_errno) 
          echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        $stmt = $mysqli->prepare("INSERT INTO user_info (username, first_name, last_name, password) VALUES (?, ?, ?, ?)");

        $stmt->bind_param('ssss', $_POST["signup_username"], $frst_name, $last_name, $user_password); 

        $stmt->execute(); 

        if (!$stmt) 
          echo "Error with query: " . $stmt->error;
        else {
          $_SESSION["username"] = $_POST["signup_username"]; 
          echo "Success"; 
        }
        
        $stmt->close(); 
        $mysqli->close(); 
      }
      else {
        echo "Username already taken"; 
      }
    }
    else if($_GET["action"] == "login") {
      if (inDB($_POST["username"])) {
        $password = md5($_POST["password"]); 
        $mysqli = new mysqli("oniddb.cws.oregonstate.edu","profiod-db","YdvEBCHZy4pJfAwO","profiod-db"); 
        if (!$mysqli || $mysqli->connect_errno) 
          echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error ;

        $stmt = $mysqli->prepare("SELECT password FROM user_info WHERE username = ?");

        $stmt->bind_param('s', $_POST["username"]); 

        $stmt->execute(); 

        if (!$stmt) 
          echo "Error with query: " . $stmt->error;

        $stmt->bind_result($user_password); 
        $stmt->fetch(); 

        if (strcmp($password, $user_password) != 0)
          echo "incorrect password"; 
        else {
          $_SESSION["username"] = $_POST["username"]; 
          echo "Success";   

          $stmt->close(); 
          $mysqli->close(); 
        }
      }
      else {
        echo "Username does not exist"; 
      }
    }
  }
?>
