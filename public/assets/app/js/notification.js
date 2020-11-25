$('document').ready(function(){
  $('#notification_schedule').hide();

  $('.add-section').click(function(){
     $('.sections').after("<div class=\"row\"><div class=\"col-md-12\"><span>Section Title</span></div><div class=\"row\"><div class=\"col-md-12\"><input type=\"text\" name=\"title[]\" class=\"form-control\"></div><div class=\"row\"><div class=\"col-md-12\"><span>Content</span></div></div><div class=\"row\"><textarea name=\"content[]\" style=\"width:500px;height:200px;\"></textarea></div>");
  });

  $('.schedule').change(function(){
      if($('.schedule').val() == 2) {
          $('#notification_schedule').show();
      } else {
          $('#notification_schedule').hide();
      }
  });
});
