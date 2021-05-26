{{-- <script data-cfasync="false" src="../../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
<script src="{{ asset('web_assets/js/backend-bundle.min.js') }}"></script>
    
<!-- Flextree Javascript-->
<script src="{{ asset('web_assets/js/flex-tree.min.js') }}"></script>
<script src="{{ asset('web_assets/js/tree.js') }}"></script>

<!-- Table Treeview JavaScript -->
<script src="{{ asset('web_assets/js/table-treeview.js') }}"></script>

<!-- Masonary Gallery Javascript -->
<script src="{{ asset('web_assets/js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('web_assets/js/imagesloaded.pkgd.min.js') }}"></script>

<!-- Mapbox Javascript -->
<script src="{{ asset('web_assets/js/mapbox-gl.js') }}"></script>
<script src="{{ asset('web_assets/js/mapbox.js') }}"></script>

<!-- Fullcalender Javascript -->
<script src='{{ asset('web_assets/vendor/fullcalendar/core/main.js') }}'></script>
<script src='{{ asset('web_assets/vendor/fullcalendar/daygrid/main.js') }}'></script>
<script src='{{ asset('web_assets/vendor/fullcalendar/timegrid/main.js') }}'></script>
<script src='{{ asset('web_assets/vendor/fullcalendar/list/main.js') }}'></script>

<!-- SweetAlert JavaScript -->
<script src="{{ asset('web_assets/js/sweetalert.js') }}"></script>

<!-- Vectoe Map JavaScript -->
<script src="{{ asset('web_assets/js/vector-map-custom.js') }}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('web_assets/js/customizer.js') }}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('web_assets/js/chart-custom.js') }}"></script>

<!-- slider JavaScript -->
<script src="{{ asset('web_assets/js/slider.js') }}"></script>

<!-- app JavaScript -->
<script src="{{ asset('web_assets/js/app.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myModal').on('hide.bs.modal', function (e) {
            $('.select_status').prop('selectedIndex',0);
    });
})
</script>