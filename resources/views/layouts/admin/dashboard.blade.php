@extends('layouts.admin.app')

@push('styles')
    {{-- @TB: If you need custom styles for dashboard place it in assets/dashboard/css/ --}}
    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('assets/app/css/admin.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {{-- @TB: If you need custom scripts for dashboard place it in assets/dashboard/js/ --}}
    <script src="{{ asset('assets/app/js/app.js') }}"></script>
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
