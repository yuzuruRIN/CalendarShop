function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#blah')
        .attr('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function showAlert(title, text, icon) {
  swal({
    title: title,
    text: text,
    icon: icon,
  });
}

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

function refreshPage() {
    window.location.reload();
}

function filterProducts() {
  var category_id = document.getElementById("category").value;
  window.location.href = 'index.php?category_id=' + category_id;
}



