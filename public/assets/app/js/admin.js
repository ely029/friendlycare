$('document').ready(function(){
    
    $('#role').change(function(){
        window.location.href = $('#role').val();
    });

    $('.password_btn').on('click', 'button', function(){
         alert('working');
    });
});