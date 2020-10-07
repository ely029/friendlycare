$('document').ready(function(){
    
    $('#role').change(function(){
        window.location.href = $('#role').val();
    });
});

function myFunction()
{
    var x = document.getElementById("confirm_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}