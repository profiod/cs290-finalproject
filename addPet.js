function validateDog() {
  req = new XMLHttpRequest(); 

  var name = document.getElementsByName("name")[0].value;
  var breed = document.getElementsByName("breed")[0].value;
  var age = document.getElementsByName("age")[0].value;

  if(name === null || name === "") {
    alert("Name must be present"); 
    return false; 
  }

  if(!(/^[a-z]+$/i.test(name))) {
    alert("Name can only contain letters."); 
    return false; 
  }

  if(name.length > 100) {
    alert("Name cannot be larger than 100 characters"); 
  }

  if(breed === null || breed === "") {
    alert("Breed must be present"); 
    return false; 
  }

  if(!(/^[a-z]+$/i.test(breed))) {
    alert("Breed can only contain letters."); 
    return false; 
  }

  if(breed.length > 100) {
    alert("Breed cannot be larger than 100 characters"); 
  }

  if(age === null) {
    alert("Age must be present"); 
    return false; 
  }


  if (/\D/.test(age)) {
    alert("Age must be a positive integer. ");
    return false; 
  }

  if(age < 0 || age > 25) {
    alert("Please insert a legitimate age"); 
    return false; 
  }


  if (!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "addPet.php?action=addPet"); 
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("name=" + name + "&breed=" + breed + "&age=" + age);

  req.onreadystatechange = function() {
    if(req.readyState == 4 && req.status == 200) {
      if(this.responseText == "Success") {
        printAll(); 

      }
      else {
        var response = this.responseText; 
        alert(response); 
      }
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

  req.open("POST", "addPet.php?action=printAll");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send(); 

  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      document.getElementById("table_holder").innerHTML = this.responseText;
    }
  }
}

function deletePet(pet) {
  var parentId = pet.parentNode.parentNode;
  parentId = parentId.id;

  req = new XMLHttpRequest(); 

  if(!req)
    throw "Unable to create the Http Request"; 

  req.open("POST", "addPet.php?action=delete");
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
  req.send("id=" + parentId); 
  
  req.onreadystatechange = function() {
    if(this.readyState === 4) {
      printAll();
    }
  }
}

window.onload = printAll; 