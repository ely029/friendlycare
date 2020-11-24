$('document').ready(function(){
  $('#notification_schedule').hide();

  $('.schedule').change(function(){
      if($('.schedule').val() == 2) {
          $('#notification_schedule').show();
      } else {
          $('#notification_schedule').hide();
      }
  });
});