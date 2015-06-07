<?php 
  session_start(); 
  /* adapted from OSU CS 290 lecture PHP Sessions 
   http://eecs.oregonstate.edu/ecampus-video/player/player.php?id=66 */
  // if a user is already logged and not trying to log out redirect to content1
  if (empty($_SESSION["username"])) {
    // use explode to extract the filepath into an array without the filename
    $filePath = explode("/", $_SERVER["PHP_SELF"], -1); 
    // use implode to combine the array back together now that is lacks the filename
    $filePath = implode("/", $filePath); 
    // prepend http and append the file path onto the http host value creating a valid uri
    $redirect = "http://" . $_SERVER["HTTP_HOST"] . $filePath; 
    // set the http header equal to the redirect so that the file redirects
    header("Location: {$redirect}/welcome.php"); 
    // end further processing of the page
    die(); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">
  <script src="addPet.js"></script>
</head>
<body>
  <div class="container-fluid sec-bg-color">
    <div class="col-sm-8">
      <h1 class="color-white">doglife</h1>
    </div>
    <div class="col-sm-4">
      <h1></h1>
      <ul class="nav nav-pills">
        <li role="presentation"><a href="#" class="color-white">Home</a></li>
        <li role="presentation"><a href="friends.php" class="color-white">Friends</a></li>
        <li role="presentation"><a href="messages.php" class="color-white">Messages</a></li>
        <li role="presentation"><a href="welcome.php?action=logout" class="color-white">Logout</a></li>
      </ul>
    </div>
  </div>
  <div class="container">
    <div class="col-sm-7">
      <table class="table table-striped">
        <caption>My Dogs</caption>
        <thead>
          <tr>
            <th>Name</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody id="table_holder">
        </tbody>
      </table>
    </div>
    <div class="col-sm-offset-1 col-sm-4">
      <h2>Add Dog</h2>
      <form onsubmit='return validateDog()' method='post' class='form-horizontal'>
        <div class="form-group">
          <label for="name" class="control-label">Name </label>
          <input type="text" name="name" class="form-control" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="breed" class="control-label">Breed </label>
          <input type="text" name="breed" class="form-control" placeholder="Breed">
        </div>
        <div class="form-group">
          <label for="age" class="control-label">Age </label>
          <input type="number" name="age" class="form-control" placeholder="Age">
        </div>
        <button type="submit" class="btn btn-default">Add Pet</button>
      </form>
    </div>
  </div>
</body>
</html>