function validateSignup() {
	req = new XMLHttpRequest(); 

  var username = document.getElementsByName("signup_username")[0].value;
  var password = document.getElementsByName("signup_password")[0].value;
  var first_name = document.getElementsByName("first_name")[0].value;  
  var last_name = document.getElementsByName("last_name")[0].value; 

  if(username === null || username === "") {
    alert("Username must be present"); 
    return false; 
  }

  if(!(/^[a-z0-9]+$/i.test(username))) {
    alert("Username can only be letters and numbers."); 
    return false; 
  }

  if(username.length > 255) {
    alert("Username cannot be larger than 255 characters"); 
  }

  if(password === null || password === "") {
    alert("Password must be present"); 
    return false; 
  }

  if(!(/^[a-z0-9]+$/i.test(password))) {
    alert("Password can only be letters and numbers."); 
    return false; 
  }

  if(first_name === null || first_name === "") {
    alert("First name must be present"); 
    return false; 
  }

  if(!(/^[a-z]+$/i.test(first_name))) {
    alert("First name can only be letters."); 
    return false; 
  }

  if(first_name.length > 50) {
    alert("First name cannot be larger than 50 characters");
    return false; 
  }

  if(last_name === null || last_name === "") {
    alert("Last name must be present"); 
    return false; 
  }

  if(!(/^[a-z]+$/i.test(last_name))) {
    alert("Last name can only be letters."); 
    return false; 
  }

  if(last_name.length > 50) {
    alert("Last name cannot be larger than 50 characters");
    return false; 
  }

	if (!req)
		throw "Unable to create the Http Request"; 

	req.open("POST", "login.php?action=signup"); 
	req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("signup_username=" + username + "&signup_password=" + password + "&first_name=" + first_name + "&last_name=" + last_name);

  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      if(this.responseText == "Success") {
        window.location.assign("/~profiod/home.php"); 
      }
      else {
        var response = this.responseText; 
        alert(response);
      }
    }
  }

  return false; 
}

function validateLogin() {
  req = new XMLHttpRequest(); 

  var username = document.getElementsByName("username")[0].value;
  var password = document.getElementsByName("password")[0].value;

  if(username === null || username === "") {
    alert("Username must be present"); 
    return false; 
  }

  if(!(/^[a-z0-9]+$/i.test(username))) {
    alert("Username can only be letters and numbers."); 
    return false; 
  }

  if(username.length > 255) {
    alert("Username cannot be larger than 255 characters"); 
  }

  if(password === null || password === "") {
    alert("Password must be present"); 
    return false; 
  }

  if(!(/^[a-z0-9]+$/i.test(password))) {
    alert("Password can only be letters and numbers."); 
    return false; 
  }

  if (!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "login.php?action=login"); 
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("username=" + username + "&password=" + password);

  req.onreadystatechange = function() {
    if(req.readyState == 4 && req.status == 200) {
      if(this.responseText == "Success") {
        window.location.assign("/~profiod/home.php"); 
      }
      else {
        var response = this.responseText; 
        alert(response); 
      }
    }
  }

  return false; 
}