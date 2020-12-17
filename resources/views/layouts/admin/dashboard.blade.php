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
    $('.add-response-option').hide();

   $('#add-response-chatbot').click(function(){
       $('.add-response-option').show();
   });
    $('#provider_information_checkbox').change(function(){
      if(this.checked) {
        $.ajax({
            type: "GET",
            url: "{{ route('provider.enableProvider')}}",
            data: { id: $('#provider_id').val()}
        })
        .done(function( msg ) {
            console.log('deactivated')
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
});
</script>

<script type="text/javascript">
            
            var my_handlers = {

                fill_provinces:  function(){

                    var region_code = $(this).val();
                    $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
                    
                },

                fill_cities: function(){

                    var province_code = $(this).val();
                    $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
                },


                fill_barangays: function(){

                    var city_code = $(this).val();
                    $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
                }
            };

            $(function(){
                $('#region').on('change', my_handlers.fill_provinces);
                $('#province').on('change', my_handlers.fill_cities);
                $('#city').on('change', my_handlers.fill_barangays);

                $('#region').ph_locations({'location_type': 'regions'});
                $('#province').ph_locations({'location_type': 'provinces'});
                $('#city').ph_locations({'location_type': 'cities'});
                $('#barangay').ph_locations({'location_type': 'barangays'});

                $('#region').ph_locations('fetch_list');
            });
        </script>
@endpush
