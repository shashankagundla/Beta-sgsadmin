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

$form = new Form();
$allSelect = $form->allSelectFields();
?>
<link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<style>
    #map {
        height: 85%;
    }
</style>
<div class="row">
    <div class="col-xs-6">
        <h4>Schedule - Main</h4><h6>
    </div>
</div>
<div class="row">
    <div id="map"></div>
</div>
<form class='form-horizontal' role='form' method='post' action='' id='quickEditForm'>
    <div class='modal fade' id='quickedit_status_form' tabindex='-1' role='dialog' aria-labeledby='fitslabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Quick Edit</h4>
                </div>
                <div class='modal-body'>
                    <div class="row">
                        <div class="form-group">
                            <label for="crew" class="col-md-4 control-label">Crew:</label>
                            <div class="col-md-8">
                                <select id="crew" name="crew" class="form-control">
                                    <option value="null"></option>
                                    <?php
                                    foreach($form->selectCrew() as $key => $val){ ?>
                                    <option value="<?php echo $val['id']; ?>">
                                        <?php echo $val['name']; ?></option><?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="input_fwc" class="col-md-4 control-label">Estimated Date on Site:</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="edos" name="edos" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="overallStatus" class="col-md-4 control-label">Job Status:</label>
                            <div class="col-md-8">
                                <select id="jobStatus" name="jobStatus" class="form-control">
                                    <?php
                                    foreach($allSelect as $key => $val){
                                        if ($val['field'] === 'overallStatus'){;
                                            ?>
                                        <option value="<?php echo $val['selectID']; ?>"
                                            <?php if($val['selectID'] === 'Pending' || $val['selectID'] === 'Cancel' || $val['selectID'] === 'Paid' AND $_SESSION['user']['role'] > '4'){ echo 'disabled'; }?>>
                                            <?php echo $val['selectField']; ?></option><?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="submit" value="updateJobStatus">
                    <button class='btn btn-primary' type='button' onclick='event.preventDefault(); quickEdit()'>Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class='modal fade' id='commentModal' tabindex='-1' role='dialog' aria-labeledby='fitslabel' aria-hidden='true'>
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Job Comments</h4>
            </div>
            <div class='modal-body'>
                <div id="currentComments"></div>
                <form class="form-horizontal" name="addComment" id="addComment" role="form" method="post" action="/includes/class/form.class.php">
                    <textarea class="form-control" rows="4" name="comment" id="comment" placeholder="Add Comment"></textarea>
                    <div class="form-group">
                        <input type="hidden" name="admin_id" id="admin_id">
                        <input type="hidden" name="submit" value="addCommentForm">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class='btn btn-primary' type='button' onclick='event.preventDefault(); quickEdit2()'>Add Comment</button>
            </div>
        </div>
    </div>
</div>
<?php
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
<script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script>
    function quickEdit(){
        $.ajax({
            type: 'POST',
            url: "/includes/class/form.class.php",
            data: $('#quickEditForm').serialize(),
            success: function() {
                $('#quickedit_status_form').modal('hide');
                map.removeLayer(locations);
                loadMarkers();
            },
            error: function() {
                alert("There was an error updating this job");
            }
        });
    }
    function quickEdit2(){
        $.ajax({
            type: 'POST',
            url: "/includes/class/form.class.php",
            data: $('#addComment').serialize(),
            success: function() {
                $('#commentModal').modal('hide');
                document.getElementById("comment").value = null;
            },
            error: function() {
                alert("There was an error submitting comment");
            }
        });
    }
    function addComment(){
        $.ajax({
            type: 'POST',
            url: "/includes/class/form.class.php",
            data: $('#addComment').serialize(),
            success: function() {
                $('#addComment').modal('hide');
            },
            error: function() {
                alert("There was an error submitting comment");
            }
        });
    }
    function comments(uid){
        $.get('/modal/comments.php?id=' + uid, function(html){
            $('#currentComments').html(html);
            $('#commentModal').modal('show', {backdrop: 'static'});
        });
    }

    function upload(uid){
        $.get('/partials/modal/upload.php?id=' + uid, function(html){
            $('#uploadModal .modal-body').html(html);
            $('#uploadModal').modal('show', {backdrop: 'static'});
        });
    }
    L.mapbox.accessToken = 'pk.eyJ1IjoiYmV5ZXJhIiwiYSI6ImNpbWxoYmI3NTA1ZnF0cWx2eTA0b2Ztd2QifQ.fnGoJA1Vv4Coaz2ieC7NMQ';
    var map = L.mapbox.map('map', 'mapbox.streets')
        .setView([39.50, -98.35], <?php if($_SESSION['mobile']){ echo '3'; }else{ echo '5';}; ?>);

    var locations;
    function loadMarkers(){
        locations = L.mapbox.featureLayer().loadURL('/includes/queries/main.map.php').addTo(map);
        locations.on('ready', function() {
            locations.eachLayer(function(locale) {

                // Shorten locale.feature.properties to just `prop` so we're not
                // writing this long form over and over again.
                var prop = locale.feature.properties;

                // Each marker on the map.
                var popup = '<b>SGS#:</b>  ' + prop.sgs + '<br>'
                    + '<b>Job Type:</b>  ' + prop.jobType + '<br>'
                    + '<b>Crew:</b>  ' + prop.crewName + '<br>'
                    + '<b>Site ID:</b>  ' + prop.siteNumber + '<br>'
                    + '<b>Site Name:</b>  ' + prop.siteName + '<br>'
                    + '<b>Lat:</b>  ' + prop.lat + '<br>'
                    + '<b>Long:</b>  ' + prop.long + '<br>'
                    + '<b>Tower:</b>  ' + prop.towerType + '/ ' + prop.towerHeight + '<br>'
                    + '<b>DSG:</b>  ' + prop.dsg + '<br>'
                    + '<div class="btn-group"><button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>'
                    + '<ul class="dropdown-menu">'
                    + '<li><a data-toggle="modal" data-target="#quickedit_status_form">Quick Edit</a></li>'
                    + '<li><a onclick="event.preventDefault(); comments(' + prop.id + ')">Job Comments</a> </li>'
                    + '<li><a href="/fm/?root=' + prop.fb + '" target="SGS Admin - File Browser">File Browser</a></li>'
                    + '<li><a href="/job/?sgs=' + prop.sgs + '">Edit Job</a></li>'
                    + '</ul></div>';

                // Marker interaction
                locale.on('click', function(e) {
                    // 1. center the map on the selected marker.
                    document.getElementById("id").value = locale.feature.properties.id;
                    document.getElementById("admin_id").value = locale.feature.properties.id;
                    document.getElementById("crew").value = locale.feature.properties.crewId;
                    document.getElementById("edos").value = locale.feature.properties.followUpDate;
                    document.getElementById("jobStatus").value = locale.feature.properties.overallStatus;
                    map.panTo(locale.getLatLng());

                });
                locale.bindPopup(popup);
            });
        });
    }
    loadMarkers();
</script>