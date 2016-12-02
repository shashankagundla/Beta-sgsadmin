<?php
include( "../init.php" );

$conn = new PDO('mysql:host=sgsdb.cxdcv7nlogaf.us-east-1.rds.amazonaws.com;dbname=sgsadmin','sgsadmin','8UWGozkMw3mpak');
# Build SQL SELECT statement including x and y columns
$sql = 'SELECT admin_jobs.id, sgs_num, site_name, site_num, state, date_eos, overall_status, job_type, overall_status, field_status, state, latitude, longitude, date_eos, tower_type, tower_height, crew_1, employee.color, display_name, DATEDIFF(CURDATE(),overall_status_date) AS go_days
        FROM admin_jobs
        LEFT JOIN employee
        ON admin_jobs.crew_1=employee.id
        LEFT JOIN admin_revisions_current
        ON admin_jobs.id=admin_revisions_current.admin_id
        WHERE (`overall_status` = "GO" AND `job_type` != "TIA")';

/*
* If bbox variable is set, only return records that are within the bounding box
* bbox should be a string in the form of 'southwest_lng,southwest_lat,northeast_lng,northeast_lat'
* Leaflet: map.getBounds().pad(0.05).toBBoxString()
*/
if (isset($_GET['bbox']) || isset($_POST['bbox'])) {
    $bbox = explode(',', $_GET['bbox']);
    $sql = $sql . ' WHERE x <= ' . $bbox[2] . ' AND x >= ' . $bbox[0] . ' AND y <= ' . $bbox[3] . ' AND y >= ' . $bbox[1];
}

# Try query or error
$rs = $conn->query($sql);
if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}

# Build GeoJSON feature collection array
$geojson = array(
    'type'      => 'FeatureCollection',
    'features'  => array()
);

# Loop through rows to build feature arrays
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $feature = array(
        'type' => 'Feature',
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array(
                $row['longitude'],
                $row['latitude']
            )
        ),
        'properties' => array('sgs' => floatval($row['sgs_num']),
            'id' => $row['id'],
            'jobType' => $row['job_type'],
            'towerType' => $row['tower_type'],
            'towerHeight' => $row['tower_height'],
            'siteNumber' => $row['site_num'],
            'siteName' => $row['site_name'],
            'crewName' => $row['display_name'],
            'crewId' => $row['crew_1'],
            'followUpDate' => $row['date_eos'],
            'overallStatus' => $row['overall_status'],
            'lat' => $row['latitude'],
            'long' => $row['longitude'],
            'dsg' => $row['go_days'],
            'fb' => filePath('quick',$row['sgs_num'],$row['site_num'],$row['state']),
            'marker-color' => $row['color'],
            'marker-size' => 'small',
            'marker-symbol' => strtolower($row['job_type'][0]),
        )
    );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}

header('Content-type: application/json');
echo json_encode($geojson, JSON_NUMERIC_CHECK);
$conn = NULL;

?>