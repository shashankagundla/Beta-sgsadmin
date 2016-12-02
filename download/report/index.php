<?php
//GET
$sgs = $_GET['sgs'];
$site = $_GET['site'];
$state = $_GET['state'];
$job_type = $_GET['type'];

//get file path
$sgs_floor = floor($sgs);
$sgs_miom = substr($sgs_floor, 2, -3);
$sgs_50 = substr($sgs_floor, -2);
$sgs_4 = substr($sgs_floor, 0, -2);
$sgs_year = substr($sgs_floor, 0, -4);
if ($sgs_50 >= 50){
    $sgs_2 = '50';
}else{
    $sgs_2 = '00';
};

if ($job_type === 'Rigging') {
    foreach (glob('/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state . '/Rigging Plan/06 - Deliverables/*.pdf') as $filename) {
        $filename = basename($filename);
        $report = '/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state . '//Rigging Plan/06 - Deliverables/' . $filename;
    }
}else {
    foreach (glob('/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state . '/Inspection/Deliverables/*.pdf') as $filename) {
        $filename = basename($filename);
        $report = '/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state . '/Inspection/Deliverables/' . $filename;
    }
}

//create document
if ($filename){
header('content-type:application/'.end(explode('.',$report)));
Header("Content-Disposition: attachment; filename=" . $filename); //to set download filename
exit(file_get_contents($report));
}else{
    echo 'Report not found, check to ensure it is in the correct folder and a PDF document.';
}
?>