
$(document).on("click",".js-add-section1",function() {

    let lastJsContent = $('.js-consent-form').last();
    let cloned = lastJsContent.clone();
    cloned.find('.js-delete-section2').removeClass('content-delete');
    cloned.find('.form__input').val('');
    cloned.insertAfter(lastJsContent);
     
});

$(document).on("click",".js-delete-section2", function() {
    $(this).parent().parent().parent().remove();
});