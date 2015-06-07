function validateUser() {
	req = new XMLHttpRequest(); 

  var username = document.getElementsByName("name")[0].value;

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

  if (!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "friendHandler.php?action=addFriend"); 
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("name=" + username);

  req.onreadystatechange = function() {
    if(req.readyState == 4 && req.status == 200) {
      var response = this.responseText; 
      alert(response);  
      printAll(); 
    }
  }
  return false; 
}

function deleteTable() {
  var div = document.getElementById("table_holder");

  for (var k = div.childNodes.length - 1; k >= 0; k--) {
    div.removeChild(div.childNodes[k]);
  }
}

function printAll() {
  if (document.getElementById("table_holder") != null)
    deleteTable(); 

  req = new XMLHttpRequest(); 

  if(!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "friendHandler.php?action=printAll");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send(); 

  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      document.getElementById("table_holder").innerHTML = this.responseText;
    }
  }
}

function deleteFriend(friend) {
  var parentId = friend.parentNode.parentNode;
  parentId = parentId.id;

  req = new XMLHttpRequest(); 

  if(!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "friendHandler.php?action=delete");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("id=" + parentId); 
  
  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      printAll();
    }
  }
}

window.onload = printAll; 