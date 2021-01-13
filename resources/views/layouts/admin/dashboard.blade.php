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
   $('.rateYo').rateYo({
    normalFill: "#F0F0F0",
    ratedFill: "#B964C4",
    readOnly: true,
    rating: $('.provider_rate').val()
   });
   $('#rateYo').rateYo({
    normalFill: "#F0F0F0",
    ratedFill: "#B964C4",
    readOnly: true,
    rating: $('#rate').val()
   });
   $("#dropzoneDragArea").dropzone({ url: "/file/post" });
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
   $('.js-add-section1').click(function(){
       $('#js-consent-form2').show();
   });

   //load the provinces upon page loading
//    $.ajax({
//             type: "GET",
//             url: "{{ route('provider.province')}}",
//             data: { region: $('#region').val()}
//         })
//         .done(function( data ) {
//             $("#province").empty();
//             jQuery.each(data, function(index, item) {
//                $('#province').append('<option value='+item.id+'>'+item.name+'</option>');
//             });
//         });
});
</script>

<script type="text/javascript">
$('document').ready(function(){
$.ajax({
            type: "GET",
            url: "{{ route('provider.province')}}",
            data: { region: $('#region').val()}
        })
        .done(function( data ) {
            $("#province").empty();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.id+'>'+item.name+'</option>');
            });
        });


        $('#region').on('change', function(){
    $.ajax({
            type: "GET",
            url: "{{ route('provider.province')}}",
            data: { region: $('#region').val()}
        })
        .done(function( data ) {
            if ($('#region').val() == '13') {
                $('#barangay').hide();
                $('#province').hide();
                $('.province-label').hide();
                $('.barangay-label').hide();
                $("#city").empty();
            jQuery.each(data, function(index, item) {
               $('#city').append('<option value='+item.name+'>'+item.name+'</option>');
            });
            }  else {
                $("#province").empty();
                $("#city").empty();
                $("#barangay").empty();
                $('#barangay').show();
                $('#province').show();
                $('.province-label').show();
                $('.barangay-label').show();
            jQuery.each(data, function(index, item) {
               $('#province').append('<option value='+item.id+'>'+item.name+'</option>');
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
               $('#city').append('<option value='+item.id+'>'+item.name+'</option>');
            });
                    $.ajax({
                    type: "GET",
                    url: "{{ route('provider.barangay')}}",
                    data: { barangay: $('#city').val()}
                })
                .done(function( data ) {
                    $("#barangay").empty();
                    jQuery.each(data, function(index, item) {
                    $('#barangay').append('<option value='+item.id+'>'+item.name+'</option>');
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
               $('#barangay').append('<option value='+item.code+'>'+item.name+'</option>');
            });
        });      
   });

   $('#export_booking').on('click', function(eee){
        eee.preventDefault();
        var ely = confirm('The reports are already generated');
    if (ely == true) {
         window.location.href = "{{ route('booking.export')}}?date_from="+$('#date-from').val()+"&date_to="+$("#date-to").val()+"&clinic="+$("#clinic_id").val()+"&status="+$("#status").val()+"";
       }
   });
});
</script>
@endpush
