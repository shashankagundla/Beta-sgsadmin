<?php
/*
 * Page Setup
 */
require_once("../../includes/init.php");
echo $template->header();

/*
 * Init schedule class and get required info
 */
$schedule = New Schedule();

$mainTable = $schedule->mainTable();

if ($_SESSION['mobile']){ ?>
<style>
.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
   padding: 3;
}
</style>
<?php } ?>
<style>
    html, body {
        height: 90%;
        margin: 0;
        padding: 0;
    }
    #map {
        height: 100%;
    }
</style>
    <div class="row">
        <div class="col-xs-6">
            <h4>Schedule - ATC</h4><h6>
        </div>
        <div class="col-xs-6">
            <div class="pull-right">
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
                    <li role="presentation" class="active"><a href="#map" aria-controls="profile" role="tab" data-toggle="tab">Map</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="list">
            <div class="row">
                <table class="table table-condensed table-dash table-hover table-bordered table-responsive small">
                    <thead>
                    <tr>
                        <th>SGS#</th>
                        <th class="col-xs-2">Site Name</th>
                        <th>Site#</th>
                        <th>Job Type</th>
                        <th>Status</th>
                        <th>State</th>
                        <th class="col-xs-2">Crew</th>
                        <?php if(!$_SESSION['mobile']){ ?>
                            <th class="col-xs-2">Est Date on Site</th>
                            <th class="col-xs-2">Latitude</th>
                            <th class="col-xs-2">Longitude</th>
                            <th>DSG</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center" colspan="11">
                            Sites Assigned to You
                        </td>
                    </tr>
                    <?php foreach($mainTable as $row){
                        if ($row['crew_1'] === $_SESSION['user']['id']){
                            ?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <?php if($_SESSION['mobile']){ ?>
                                    <td><?=substr($row['site_name'],0,10)?></td>
                                <?php }else{ ?>
                                    <td><?=$row['site_name']?></td>
                                <?php } ?>
                                <td><?=$row['site_num']?></td>
                                <td><?=$row['job_type']?></td>
                                <td><?=$row['overall_status']?></td>
                                <td><?=$row['state']?></td>
                                <td><?=$row['crew_1']?></td>
                                <?php if(!$_SESSION['mobile']){ ?>
                                    <td><?=$row['date_eos']?></td>
                                    <td><?=$row['latitude']?></td>
                                    <td><?=$row['longitude']?></td>
                                    <td>-</td>
                                <?php } ?>
                            </tr>

                        <?php }} ?>
                    <tr>
                        <td class="text-center" colspan="11">
                            All Other Sites
                        </td>
                    </tr>
                    <?php foreach($mainTable as $row){
                        if ($row['crew_1'] != $_SESSION['user']['id']){
                            ?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <?php if($_SESSION['mobile']){ ?>
                                    <td><?=substr($row['site_name'],0,10)?></td>
                                <?php }else{ ?>
                                    <td><?=$row['site_name']?></td>
                                <?php } ?>
                                <td><?=$row['site_num']?></td>
                                <td><?=$row['job_type']?></td>
                                <td><?=$row['overall_status']?></td>
                                <td><?=$row['state']?></td>
                                <td><?=$row['crew_1']?></td>
                                <?php if(!$_SESSION['mobile']){ ?>
                                    <td><?=$row['date_eos']?></td>
                                    <td><?=$row['latitude']?></td>
                                    <td><?=$row['longitude']?></td>
                                    <td>-</td>
                                <?php } ?>
                            </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane active" id="map">
            <div id="map"></div>
        </div>
    </div>


<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>' . var_export($mainTable, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });
    });
</script>
<script>
    function initMap() {
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 39.50, lng: -98.35},
            scrollwheel: true,
            zoom: <?php if($_SESSION['mobile']){ echo '3'; }else{ echo '5';}; ?>
        });
        var infowindow = new google.maps.InfoWindow;
        var marker, i;

        <?php
        $i = 1;
        foreach($mainTable as $row){
            if ($row['latitude']){
                if (strpos($row['latitude'], ' ') !== FALSE){
                    $val_array = explode(' ', $row['latitude']);
                    $deg = intval($val_array[0]);
                    $min = intval($val_array[1]);
                    $sec = intval($val_array[2]);
                    $latitude = $deg+($min/60)+($sec/3600);
                    $row_array['latitude'] = $latitude;
                    $val_array = explode(' ', $row['longitude']);
                    $deg = intval($val_array[0]);
                    $min = intval($val_array[1]);
                    $sec = intval($val_array[2]);
                    $longitude = $deg-($min/60)-($sec/3600);
                    $row_array['longitude'] = $longitude;
                }else{
                    $latitude = $row['latitude'];
                    $longitude = $row['longitude'];
                }
                ?>
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?=$latitude?>, <?=$longitude?>),
                    map: map
                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent("<?=$row['sgs_num']?>");
                        infowindow.open(map, marker);
                    }
                })(marker, <?=$i?>));
        <?php
        $i = $i +1;
        }} ?>
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCt7dbOeMTuDdp5qpT9nKoM7W6tZ2r-ZSw&callback=initMap" async defer></script>