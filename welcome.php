<?php 
  session_start(); 
  /* adapted from OSU CS 290 lecture PHP Sessions 
   http://eecs.oregonstate.edu/ecampus-video/player/player.php?id=66 */
  // if a user is already logged and not trying to log out redirect to content1
  if (!empty($_SESSION["username"]) && !(isset($_GET["action"]) && $_GET["action"] == "logout")) {
    // use explode to extract the filepath into an array without the filename
    $filePath = explode("/", $_SERVER["PHP_SELF"], -1); 
    // use implode to combine the array back together now that is lacks the filename
    $filePath = implode("/", $filePath); 
    // prepend http and append the file path onto the http host value creating a valid uri
    $redirect = "http://" . $_SERVER["HTTP_HOST"] . $filePath; 
    // set the http header equal to the redirect so that the file redirects
    header("Location: {$redirect}/home.php"); 
    // end further processing of the page
    die(); 
  }
  // else if they are trying to log out 
  else if (isset($_GET["action"]) && $_GET["action"] == "logout"){
    // erase the session array and destroy the session 
    $_SESSION = array(); 
    session_destroy(); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">
  <script src="welcome.js"></script>
</head>
<body>
  <div class="container-fluid sec-bg-color">
    <div class="col-sm-8">
      <h1 class="color-white">doglife</h1>
      <span class="color-white">connect with your pup's pals</span>
    </div>
    <div class="col-sm-4">
      <h1></h1>
      <?php
      // use explode to extract the filepath into an array without the filename
      $filePath = explode("/", $_SERVER["PHP_SELF"], -1); 
      // use implode to combine the array back together now that is lacks the filename
      $filePath = implode("/", $filePath); 
      // prepend http and append the file path onto the http host value creating a valid uri
      $link = "http://" . $_SERVER["HTTP_HOST"] . $filePath; 
      echo "<form onsubmit='return validateLogin()' action='". $link . "/login.php?action=login' method='post' class='form-horizontal'>"
      ?>
        <div class="form-group col-md-5">
          <input type="text" name="username" class="form-control" placeholder="Username">
        </div>
        <div class="form-group col-md-5">
          <input type ="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-default">Login</button>
        </div>
      </form>
    </div>
  </div>
  <div class="container"> 
    <div class="col-sm-4 spacer-top-5per">
      <img src="dog.png" alt="Cute Dog" class="side-image">
    </div>
    <div class="col-sm-offset-4 col-sm-4 spacer-top-5per">
      <h2>Sign Up</h2>
      <?php
      // use explode to extract the filepath into an array without the filename
      $filePath = explode("/", $_SERVER["PHP_SELF"], -1); 
      // use implode to combine the array back together now that is lacks the filename
      $filePath = implode("/", $filePath); 
      // prepend http and append the file path onto the http host value creating a valid uri
      $link = "http://" . $_SERVER["HTTP_HOST"] . $filePath; 
      echo "<form onsubmit='return validateSignup()' action='". $link . "/login.php?action=signup' method='post' class='form-horizontal'>"
      ?>
        <div class="form-group">
          <label for="first_name" class="control-label">First Name </label>
          <input type="text" name="first_name" class="form-control" placeholder="First">
        </div>
        <div class="form-group">
          <label for="last_name" class="control-label">Last Name </label>
          <input type="text" name="last_name" class="form-control" placeholder="Last">
        </div>
        <div class="form-group">
          <label for="signup_username" class="control-label">Username </label>
          <input type="text" name="signup_username" class="form-control" placeholder="Username">
        </div>
        <div class="form-group">
          <label for="signup_Password" class="control-label">Password </label>
          <input type ="password" name="signup_password" class="form-control" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Sign Up</button>
      </form>
    </div>
  </div>
</body>
</html>
  