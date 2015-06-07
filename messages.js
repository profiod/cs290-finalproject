function validateMsg() {
  req = new XMLHttpRequest(); 

  var username = document.getElementsByName("name")[0].value;
  var message = document.getElementsByName("message")[0].value;

  if (username === null || username === "Select"){
    alert("Friend must be selected");
    return false; 
  }

  if(message === null || message === "") {
    alert("Message must be present"); 
    return false; 
  }

  if(message.length > 2000) {
    alert("Message cannot be larger than 2000 characters"); 
  }


  if (!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "msgHandler.php?action=sendMsg"); 
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("toUser=" + username + "&message=" + message);

  req.onreadystatechange = function() {
    if(req.readyState == 4 && req.status == 200) {
      var response = this.responseText; 
      alert(response);  
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

  req.open("POST", "msgHandler.php?action=printAll");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send(); 

  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      document.getElementById("table_holder").innerHTML = this.responseText;
    }
  }
}

function deleteMsg(msg) {
  var parentId = msg.parentNode.parentNode;
  parentId = parentId.id;

  req = new XMLHttpRequest(); 

  if(!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "msgHandler.php?action=delete");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("id=" + parentId); 
  
  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      printAll();
    }
  }
}

function printInfo() {
  req = new XMLHttpRequest(); 

  if(!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "info.php");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send(); 

  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      document.getElementById("info_placeholder").innerHTML = this.responseText;
    }
  }
}

window.onload = function () {
  printAll(); 
  printInfo(); 
} 