<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
    #map {
        height: calc(100vh - 210px);
        width: 100%;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <p class="h4-custom"><?php echo $meta; ?></p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: new google.maps.LatLng(30.3422527, -95.4709183),
            mapTypeId: 'roadmap'
        });
        var infoWindow = new google.maps.InfoWindow;

        // var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var iconBase = '<?php echo base_url(); ?>new_assets/img/';
        var icons = {
            green_circle: {
                icon: iconBase + 'green_circle.png'
            },
            blue_circle: {
                icon: iconBase + 'blue_circle.png'
            }
        };
        var markers = '<?php print_r($markers); ?>';
        var markers = JSON.parse(markers);
        // console.log(markers);

        // Create markers.
        // $.each(markers, function(index, feature){
        Array.prototype.forEach.call(markers, function(feature) {
            var mark_color = '';
            // console.log(feature);

            var name = feature.name;
            name = name.replace("&quot", "'");
            var device = feature.device;
            // var type = feature.type;
            var point = new google.maps.LatLng(
                parseFloat(feature.latitude),
                parseFloat(feature.longitude)
            );

            var infowincontent = document.createElement('div');
            var strong = document.createElement('strong');
            strong.textContent = name;
            infowincontent.appendChild(strong);
            infowincontent.appendChild(document.createElement('br'));

            var text = document.createElement('text');
            text.textContent = device;
            infowincontent.appendChild(text);

            var marker = new google.maps.Marker({
                name: feature.name,
                position: new google.maps.LatLng(parseFloat(feature.latitude), parseFloat(feature.longitude)),
                icon: icons[feature.mark_color].icon,
                // type: 'library',
                // label: 'M',
                map: map
            });
            console.log(marker);
            marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
            });
            
        });
    }
</script>

<script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgi4r_8NVve2Nt9dqc7x8oO26Pzbbzb-8&callback=initMap">
</script>

<?php include_once'footer_button_dash.php'; ?>