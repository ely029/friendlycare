@extends('layouts.admin.app')

@push('styles')
    {{-- @TB: If you need custom styles for dashboard place it in assets/dashboard/css/ --}}
    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('assets/app/css/admin.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {{-- @TB: If you need custom scripts for dashboard place it in assets/dashboard/js/ --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script src="{{ asset('assets/app/js/app.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('assets/app/js/main.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('assets/app/js/admin.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('assets/app/js/notification.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<!-- <script src="https://cdn.tiny.cloud/1/yjtil7vjw9cus6nrlnbphyor2ey71lojenzvv4yqmy0luh43/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
$('document').ready(function(){
    $('#user-filter').change(function(){
        window.location.href = $('#user-filter').val();
    });
});
</script>
@if(Route::currentRouteName() == 'survey.create')
<script type="text/javascript">
$('document').ready(function(){
   $('#date_from').change(function(){
      $('#date-display').html($('#date_from').val());
   });
   $('#taym').change(function(){
      $('#time-display').html($('#taym').val());
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'ads.create')
<script type="text/javascript">
$('document').ready(function(){
   $('#start_date').change(function(){
      $('#date-display').html($('#start_date').val());
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'patientManagement.filter' || Route::currentRouteName() == 'patientManagement.index')
<script type="text/javascript">
$('document').ready(function(){
    $('.export').on('click', function(eee){
        eee.preventDefault();
        var ely = confirm('The reports are already generated');
    if (ely == true) {
         window.open("{{ route('patientManagement.export')}}?start_date="+$('#start_date').val()+"&end_date="+$("#end_date").val()+"&age="+$("#age").val()+"","_self");
       }
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'familyPlanningMethod.thirdPage' || Route::currentRouteName() == 'familyPlanningMethod.secondPage')
<script type="text/javascript">
$('document').ready(function(){
    $('#back-fpm-page').click(function(e){
    e.preventDefault();
    window.history.back();
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'providerCreateThirdPage')
<script type="text/javascript">
$('document').ready(function(){
    $('#back-provider-page').click(function(e){
    e.preventDefault();
    window.history.back();
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'provider.reviews')
@foreach($details as $detail)
<script type="text/javascript">
$('document').ready(function(){
    $('#rateYo-{{$detail->id}}').rateYo({
    normalFill: "#F0F0F0",
    ratedFill: "#B964C4",
    readOnly: true,
    starWidth: "20px",
    rating: $('#review-{{ $detail->id }}').val()
   });
});
</script>
@endforeach
@endif
@if(Route::currentRouteName() == 'providerManagement')
@foreach ($clinics as $clinic)
<script type="text/javascript">
$('document').ready(function(){
   $('.rateYo-{{$clinic->id}}').rateYo({
    normalFill: "#F0F0F0",
    ratedFill: "#B964C4",
    readOnly: true,
    starWidth: "20px",
    rating: $('.provider_rate_{{ $clinic->id }}').val()
   });
});
</script>
@endforeach
@endif
@if(Route::currentRouteName() == 'chatbot.create')
<script type="text/javascript">
$('document').ready(function(){
   $('.js-add-response1').click(function(){
      $('#add-response-option').clone().appendTo($('#add-response-option1'));
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'chatbot.edit')
<script type="text/javascript">
$('document').ready(function(){
    $('.add-response-option2').hide();
   $('.add-response-chatbot').click(function(){
       $('#add-response-option-create').clone().appendTo($('#add-response-option-create1'));
   });
   $('.js-add-response1').click(function(){
      $('#add-response-option').clone().appendTo($('#add-response-option1'));
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'ads.index' || Route::currentRouteName() == 'ads.filter')
<script type="text/javascript">
$('document').ready(function(){
    $('.export').on('click', function(eee){
        eee.preventDefault();
        var ely = confirm('The reports are already generated');
    if (ely == true) {
         window.open("{{ route('ads.export')}}?start_date="+$('#start_date').val()+"&end_date="+$("#end_date").val()+"","_self");
       }
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'ads.create')
<script type="text/javascript">
$('document').ready(function(){
  var previewNode = document.querySelector("#gallery-container");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);
    $("#dropzoneDragArea").dropzone({
        url: "{{ route('ads.uploadImage')}}",
        maxFiles: 1,
        acceptedFiles: "image/*",
        thumbnailWidth: 300,
        thumbnailHeight: 100,
        headers: {
                  'x-csrf-token': "{{ csrf_token() }}",
        },
        previewTemplate: previewTemplate,
        previewsContainer: "#gallery-preview",
        clickable: ".gallery",
        init: function() {
            this.on("maxfilesexceeded", function(file){
              this.removeFile(file);
            });
          },
        success: function(file, response) {
                $('#ads-image-location').attr('value', response);
            }
        });
});
</script>
@endif
@if(Route::currentRouteName() == 'providerCreateFirstPage' || Route::currentRouteName() == 'editPage')
<script type="text/javascript">
$('document').ready(function(){
    $(".form").on("change", function(){
      var formData = new FormData(this);
      $.ajax({
         url  : "{{ route('provider.profPicUpload') }}",
         type : "POST",
         cache: false,
         contentType : false, 
         processData: false,
         data: formData,
         success:function(response){
              $('.form__image').attr('src', response);
              $('#pic_url').attr('value', response);
         }
      });
   });
   $('#back-provider-page').click(function(e){
    e.preventDefault();
    window.location.href = "{{ route('providerManagement')}}";
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'familyPlanningMethod.firstPage' || Route::currentRouteName() == 'familyPlanningMethod.edit')
<script type="text/javascript">
$('document').ready(function(){
    $(".form--method").on("change", function(){
      var formData = new FormData(this);
      $.ajax({
         url  : "{{ route('familyPlanningMethod.iconUpload') }}",
         type : "POST",
         cache: false,
         contentType : false, 
         processData: false,
         data: formData,
         success:function(response){
              $('.form__image--method').attr('src', response);
              $('#pic_url').attr('value', response);
         }
      });
   });

  var previewNode = document.querySelector("#gallery-container");

   $("#dropzoneDragArea").dropzone({
        url: "{{ route('familyPlanningMethod.updateGalleryUpload')}}",
        data: {id: $("#id").val(), },
        maxFiles: 5,
        parallelUploads: 1,
        uploadMultiple: true,
        thumbnailWidth: 80,
        thumbnailHeight: 60,
        acceptedFiles: "image/*",
        headers: {
                  'x-csrf-token': "{{ csrf_token() }}",
        },
        previewsContainer: "#gallery-preview",
        clickable: ".gallery",
        init: function() {
                this.on("sending", function(file, xhr, formData){
                        formData.append("fpm", $("#id").val());
                });
                this.on("maxfilesexceeded", function(file){
                  this.removeFile(file);
                });
            },

        success: function(file, response) {
            $("#service_gallery_pics").append($('<input type="hidden" ' + 'name="service_gallery_pics[]" ' + 'value="' + response + '">'));
        }
        });
});
</script>
@endif
@if(Route::currentRouteName() == 'familyPlanningMethod.thirdPage')
<script type="text/javascript">
$('document').ready(function(){
  var previewNode = document.querySelector("#gallery-container");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);
    $("#dropzoneDragArea").dropzone({
        url: "{{ route('familyPlanningMethod.galleryUpload')}}",    
        headers: {
                  'x-csrf-token': "{{ csrf_token() }}",
        },
        maxFiles: 5,
        parallelUploads: 1,
        uploadMultiple: true,
        thumbnailWidth: 80,
        thumbnailHeight: 60,
        previewTemplate: previewTemplate,
        previewsContainer: "#gallery-preview",
        clickable: ".gallery",
        init: function() {
                this.on("sending", function(file, xhr, formData){
                        formData.append("fpm", $("#id").val());
                });

                this.on("maxfilesexceeded", function(file){
                  this.removeFile(file);
                });
            }
        });
});
</script>
@endif
@if(Route::currentRouteName() == 'storeFirstPage')
<script type="text/javascript">
$(function(){
  var previewNode = document.querySelector("#gallery-container");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);
    $("#dropzoneDragArea1").dropzone({
        url: "{{ route('provider.galleryUpload')}}",
        data: {id: $("#id").val(), },
        maxFiles: 5,
        parallelUploads: 1,
        thumbnailWidth: 80,
        thumbnailHeight: 60,
        uploadMultiple: true,
        acceptedFiles: "image/*",
        headers: {
                  'x-csrf-token': "{{ csrf_token() }}",
        },
        previewTemplate: previewTemplate,
        previewsContainer: "#gallery-preview",
        clickable: ".gallery",
        init: function() {
                this.on("sending", function(file, xhr, formData){
                        formData.append("clinic", $("#id").val());
                });

                this.on("maxfilesexceeded", function(file){
                  this.removeFile(file);
                });
            }
        });

        $('#back-provider-page').click(function(e){
    e.preventDefault();
    window.history.back();
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'editPage')
<script type="text/javascript">
$(function(){
    $('input[name="days[]"]').change(function(){
        var e = $('input[name="days[]"]').val();
        alert(e);
        $('#deleted_hours').append('<input type="hidden" name="deleted_hours[]"value='+ e +'>');
    });
    $("#dropzoneDragArea").dropzone({
        url: "{{ route('provider.galleryUpload')}}",
        data: {id: $("#clinic_id").val(), },
        maxFiles: 5,
        parallelUploads: 1,
        thumbnailWidth: 80,
        thumbnailHeight: 60,
        uploadMultiple: true,
        acceptedFiles: "image/*",
        headers: {
                  'x-csrf-token': "{{ csrf_token() }}",
        },
        previewsContainer: "#gallery-preview",
        clickable: ".gallery",
        init: function() {
                this.on("sending", function(file, xhr, formData){
                        formData.append("clinic", $("#clinic_id").val());
                });
                this.on("maxfilesexceeded", function(file){
                  this.removeFile(file);
                });
            }
        });

        $('#city').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.barangay')}}",
            data: { barangay: $('#city').val()}
        })
        .done(function( data ) {
            $("#barangay").empty();
            jQuery.each(data, function(index, item) {
               $('#barangay').append('<option value='+item.barangay_code+'>'+item.barangay_description+'</option>');
            });
        });      
   });

        $.ajax({
            type: "GET",
            url: "{{ route('provider.province')}}",
            data: { 
                region: $('#region_string').val()
                }
        })
        .done(function( data ) {
            $("#province").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.province_code+'>'+item.province_description+'</option>');
        });
                    $.ajax({
                        type: "GET",
                        url: "{{ route('provider.getProvince')}}",
                        data: { 
                            selected_province: $('#province_string').val(),
                        }
                    })
                    .done(function( data ) {
                        jQuery.each(data, function(index, item) {
                        $('#province').append('<option value='+item.province_code+' selected>'+item.province_description+'</option>');
                        });
                    });
        });

        $.ajax({
            type: "GET",
            url: "{{ route('provider.city')}}",
            data: { province: $('#province_string').val()}
        })
        .done(function( data ) {
            $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#city').append('<option value='+item.city_municipality_code+'>'+item.city_municipality_description+'</option>');
            });
        });

        $.ajax({
                    type: "GET",
                    url: "{{ route('provider.barangay')}}",
                    data: { barangay: $('#city_string').val()}
                })
                .done(function( data ) {
                    $("#barangay").empty();
                    jQuery.each(data, function(index, item) {
                    $('#barangay').append('<option value='+item.barangay_code+'>'+item.barangay_description+'</option>');
                    });

                    $.ajax({
            type: "GET",
            url: "{{ route('provider.getBarangay')}}",
            data: { 
                selected_barangay: $('#barangay_string').val(),
            }
        })
        .done(function( data, item ) {
            jQuery.each(data, function(index, item) {
                    $('#barangay').append('<option value='+item.barangay_code+' selected>'+item.brgy_description+'</option>')
            });
        });
                });

        $.ajax({
            type: "GET",
            url: "{{ route('provider.getCity')}}",
            data: { 
                selected_city: $('#city_string').val(),
            }
        })
        .done(function( data, item ) {
            jQuery.each(data, function(index, item) {
                    $('#city').append('<option value='+item.city_code+' selected>'+item.city_description+'</option>').attr('selected', 'selected');
            });
        });

        $('#region').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.province')}}",
            data: { region: $('#region').val()}
        })
        .done(function( data ) {
            if ($("#region").val() === "13") {
                $("#province").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.province_code+'>'+item.province_description+'</option>');
            });
            $("#city").empty();

            $.ajax({
            type: "GET",
            url: "{{ route('provider.city')}}",
            data: { province: $('#province').val()}
        })
        .done(function( data ) {
            $("#city").empty();
            $("#barangay").empty();
            jQuery.each(data, function(index, item) {
               $('#city').append('<option value='+item.city_municipality_code+'>'+item.city_municipality_description+'</option>');
            });
        });
            } else {
                $("#province").empty();
                $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.province_code+'>'+item.province_description+'</option>');
            });
            }
            
        });      
   });

   $('#province').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.city')}}",
            data: { province: $('#province').val()}
        })
        .done(function( data ) {
            $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#city').append('<option value='+item.city_municipality_code+'>'+item.city_municipality_description+'</option>');
            });
                    $.ajax({
                    type: "GET",
                    url: "{{ route('provider.barangay')}}",
                    data: { barangay: $('#city').val()}
                })
                .done(function( data ) {
                    $("#barangay").empty();
                    jQuery.each(data, function(index, item) {
                    $('#barangay').append('<option value='+item.barangay_code+'>'+item.barangay_description+'</option>');
                    });
                }); 
        });      
   });
});
</script>
@endif
@if(Route::currentRouteName() == 'providerCreateFirstPage')
<script type="text/javascript">
$(function(){
    $('.add-response-option2').hide();
   $('.add-response-chatbot').click(function(){
       $('#add-response-option-create').clone().appendTo($('#add-response-option-create1'));
   });
   $('.js-add-response1').click(function(){
      $('#add-response-option').clone().appendTo($('#add-response-option1'));
   });
    $('#provider_information_checkbox').change(function(){
      if(this.checked) {
        $.ajax({
            type: "GET",
            url: "{{ route('provider.enableProvider')}}",
            data: { id: $('#provider_id').val()}
        })
        .done(function( msg ) {
            console.log('activated')
        }); 
      } else {
        $.ajax({
            type: "GET",
            url: "{{ route('provider.disableProvider')}}",
            data: { id: $('#provider_id').val()}
        })
        .done(function( msg ) {
            console.log('deactivated')
        }); 
      }
   });
    $('#js-consent-form').show();
    $('#js-consent-form2').hide();
   if($('#js-schedule-1').val() == 'Post Now') {
       $('.js-scheduled-content-1').hide();
   } else {
       $('.js-scheduled-content-1').show();
   }

   $('#js-schedule-1').change(function(){
       if($('#js-schedule-1').val() == 'Scheduled') {
        $('.js-scheduled-content-1').show();
       } else {
        $('.js-scheduled-content-1').hide();
       }
   });   
//    $('.js-add-section1').click(function(){
//        $('#js-consent-form2').show();
//    });

   //load the provinces upon page loading
   $.ajax({
            type: "GET",
            url: "{{ route('provider.province')}}",
            data: { region: $('#region').val()}
        })
        .done(function( data ) {
            $("#province").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.province_code+'>'+item.province_description+'</option>');
            });
        });
});
</script>
<script type="text/javascript">
$('document').ready(function(){


        $('#region').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.province')}}",
            data: { region: $('#region').val()}
        })
        .done(function( data ) {
            if ($("#region").val() === "13") {
                $("#province").empty();
                $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.province_code+'>'+item.province_description+'</option>');
            });

            $.ajax({
            type: "GET",
            url: "{{ route('provider.city')}}",
            data: { province: $('#province').val()}
        })
        .done(function( data ) {
            $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#city').append('<option value='+item.city_municipality_code+'>'+item.city_municipality_description+'</option>');
            });
                    $.ajax({
                    type: "GET",
                    url: "{{ route('provider.barangay')}}",
                    data: { barangay: $('#city').val()}
                })
                .done(function( data ) {
                    $("#barangay").empty();
                    jQuery.each(data, function(index, item) {
                    $('#barangay').append('<option value='+item.barangay_code+'>'+item.barangay_description+'</option>');
                    });
                }); 
        });
            } else {
                $("#province").empty();
                $("#city").empty();
                $("#barangay").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.province_code+'>'+item.province_description+'</option>');
            });
            }
            
        });      
   });

   $('#province').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.city')}}",
            data: { province: $('#province').val()}
        })
        .done(function( data ) {
            $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#city').append('<option value='+item.city_municipality_code+'>'+item.city_municipality_description+'</option>');
            });
                    $.ajax({
                    type: "GET",
                    url: "{{ route('provider.barangay')}}",
                    data: { barangay: $('#city').val()}
                })
                .done(function( data ) {
                    $("#barangay").empty();
                    jQuery.each(data, function(index, item) {
                    $('#barangay').append('<option value='+item.barangay_code+'>'+item.barangay_description+'</option>');
                    });
                }); 
        });      
   });

   $('#city').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.barangay')}}",
            data: { barangay: $('#city').val()}
        })
        .done(function( data ) {
            $("#barangay").empty();
            jQuery.each(data, function(index, item) {
               $('#barangay').append('<option value='+item.barangay_code+'>'+item.barangay_description+'</option>');
            });
        });      
   });
});
</script>
@else
<script type="text/javascript">
$(function(){
    $('.export_booking').on('click', function(eee){
        eee.preventDefault();
        var ely = confirm('The reports are already generated');
    if (ely == true) {
         window.location.href = "{{ route('booking.export')}}?date_from="+$('#date-from').val()+"&date_to="+$("#date-to").val()+"&clinic="+$("#clinic_id").val()+"&status="+$("#status").val()+"&service="+$('#service').val()+"";
       }
   });
    $('#provider_information_checkbox').change(function(){
      if(this.checked) {
        $.ajax({
            type: "GET",
            url: "{{ route('provider.enableProvider')}}",
            data: { id: $('#provider_id').val()}
        })
        .done(function( msg ) {
            console.log('activated')
        }); 
      } else {
        $.ajax({
            type: "GET",
            url: "{{ route('provider.disableProvider')}}",
            data: { id: $('#provider_id').val()}
        })
        .done(function( msg ) {
            console.log('deactivated')
        }); 
      }
   });
    $('#js-consent-form').show();
    $('#js-consent-form2').hide();
   $('.rateYo').rateYo({
    normalFill: "#F0F0F0",
    ratedFill: "#B964C4",
    readOnly: true,
    starWidth: "20px",
    rating: $('.provider_rate').val()
   });
   $('#rateYo').rateYo({
    normalFill: "#F0F0F0",
    ratedFill: "#B964C4",
    starWidth: "20px",
    readOnly: true,
    rating: $('#rate').val()
   });
   if($('#js-schedule-1').val() == 'Post Now') {
       $('.js-scheduled-content-1').hide();
   } else {
       $('.js-scheduled-content-1').show();
   }

   $('#js-schedule-1').change(function(){
       if($('#js-schedule-1').val() == 'Scheduled') {
        $('.js-scheduled-content-1').show();
       } else {
        $('.js-scheduled-content-1').hide();
       }
   });  
});
</script>
<script src="{{ asset('assets/dashboard/js/admin.js') }}"></script>
@endif
@endpush
