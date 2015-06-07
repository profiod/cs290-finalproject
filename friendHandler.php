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
  else if (empty($_SESSION["username"])) {
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
    if($_GET["action"] == "addFriend") {
      if (inDB($_SESSION["username"]) && inDB($_POST["name"])) {
        $username2 = $_POST["name"]; 

        if (strcmp($_SESSION["username"], $username2) == 0){
          echo "You cannot add yourself"; 
          die(); 
        }

        $mysqli = new mysqli("oniddb.cws.oregonstate.edu","profiod-db","YdvEBCHZy4pJfAwO","profiod-db"); 
        
        if (!$mysqli || $mysqli->connect_errno) 
          echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        $stmt = $mysqli->prepare("INSERT INTO friend_info (username1, username2) VALUES (?, ?)");

        $stmt->bind_param('ss', $_SESSION["username"], $username2); 

        $stmt->execute(); 

        if (!$stmt) 
          echo "Error with add: " . $stmt->error;
        else {
          echo "Friend Added"; 
        }
          $stmt->close(); 
          $mysqli->close(); 
      }
      else {
        echo "User not found"; 
      }
    }
    else if($_GET["action"] == "printAll") {
      $mysqli = new mysqli("oniddb.cws.oregonstate.edu","profiod-db","YdvEBCHZy4pJfAwO","profiod-db"); 

      if (!$mysqli || $mysqli->connect_errno) 
        echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error ;

      $stmt = $mysqli->prepare("SELECT username2, id FROM friend_info WHERE username1 = ?");

      $stmt->bind_param('s', $_SESSION["username"]); 

      $stmt->execute(); 

      if (!$stmt) 
        echo "Error with query: " . $stmt->error;

      $stmt->bind_result($name, $id); 

      while($stmt->fetch()) {
        echo "<tr id='". $id . "'>
            <td>" . $name . "</td>
            <td><button name='Delete' onclick='deleteFriend(this)'>X</button></td>
          </tr>"; 
      } 

      $stmt->close(); 

      $mysqli->close(); 
    }
    else if($_GET["action"] == "delete") {
      $id = $_POST["id"]; 

      $mysqli = new mysqli("oniddb.cws.oregonstate.edu","profiod-db","YdvEBCHZy4pJfAwO","profiod-db"); 

      if (!$mysqli || $mysqli->connect_errno) 
        echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error ;

      $stmt = $mysqli->prepare("DELETE FROM friend_info WHERE id = ?");

      $stmt->bind_param('i',$id); 

      $stmt->execute(); 

      if (!$stmt) 
        echo "Error with query: " . $stmt->error;

      $stmt->close(); 
      $mysqli->close(); 
    }
  }
?>