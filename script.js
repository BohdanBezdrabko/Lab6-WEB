function submitForm() {
    var formData = new FormData(document.getElementById("myForm"));
  
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
  
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById("result").innerHTML = xhr.responseText;
      }
    };
  
    xhr.send(formData);
  }
  