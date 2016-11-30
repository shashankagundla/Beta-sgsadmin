<?php

function timeAgo($datefrom, $dateto = -1)
{
    if ($datefrom <= 0) {
        return "A long time ago";
    }
    if ($dateto == -1) {
        $dateto = time();
    }
    $difference = $dateto - $datefrom;
    if ($difference < 60) {
        $interval = "s";
    } elseif ($difference >= 60 && $difference < 60 * 60) {
        $interval = "n";
    } elseif ($difference >= 60 * 60 && $difference < 60 * 60 * 24) {
        $interval = "h";
    } elseif ($difference >= 60 * 60 * 24 && $difference < 60 * 60 * 24 * 7) {
        $interval = "d";
    } elseif ($difference >= 60 * 60 * 24 * 7 && $difference < 60 * 60 * 24 * 30) {
        $interval = "ww";
    } elseif ($difference >= 60 * 60 * 24 * 30 && $difference < 60 * 60 * 24 * 365) {
        $interval = "m";
    } elseif ($difference >= 60 * 60 * 24 * 365) {
        $interval = "y";
    }
    switch ($interval) {
        case "m":
            $months_difference = floor($difference / 60 / 60 / 24 / 29);
            while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                $months_difference++;
            }
            $datediff = $months_difference;
            if ($datediff == 12) {
                $datediff--;
            }
            $res = ($datediff == 1) ? "$datediff month" : "$datediff months";
            break;
        case "y":
            $datediff = floor($difference / 60 / 60 / 24 / 365);
            $res = ($datediff == 1) ? "$datediff year" : "$datediff years";
            break;
        case "d":
            $datediff = floor($difference / 60 / 60 / 24);
            $res = ($datediff == 1) ? "$datediff day" : "$datediff days";
            break;
        case "ww":
            $datediff = floor($difference / 60 / 60 / 24 / 7);
            $res = ($datediff == 1) ? "$datediff week" : "$datediff weeks";
            break;
        case "h":
            $datediff = floor($difference / 60 / 60);
            $res = ($datediff == 1) ? "$datediff hour" : "$datediff hours";
            break;
        case "n":
            $datediff = floor($difference / 60);
            $res = ($datediff == 1) ? "$datediff minute" : "$datediff minutes";
            break;
        case "s":
            $datediff = $difference;
            $res = ($datediff == 1) ? "$datediff second" : "$datediff seconds";
            break;
    }
    return $res;
}

function checkMobile(){
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
        $mobile = 1;
    }else{
        $mobile = 0;
    }
    return $mobile;
}

function filePath($type, $sgs, $site, $state){
    $sgs_floor = floor($sgs);
    $sgs_50 = substr($sgs_floor, -2);
    $sgs_4 = substr($sgs_floor, 0, -2);
    $sgs_year = substr($sgs_floor, 0, -4);
    if ($sgs_50 >= 50){
        $sgs_2 = '50';
    }else{
        $sgs_2 = '00';
    };
    if ($type === 'quick'){
        $path = '/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state. '/';
    }elseif ($type === 'box'){
        $path = 'https://sgsbox.com/index.php/apps/files?dir=SGS WIP/' . $year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $site_state;
    }elseif ($type === 'server'){
        $path = 'file:///S:/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state;
    }

    return $path;
}

function fileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(",", "." , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

function reportSize($sgs, $site, $state){
    $sgs_floor = floor($sgs);
    $sgs_50 = substr($sgs_floor, -2);
    $sgs_4 = substr($sgs_floor, 0, -2);
    $sgs_year = substr($sgs_floor, 0, -4);
    if ($sgs_50 >= 50){
        $sgs_2 = '50';
    }else{
        $sgs_2 = '00';
    };
    foreach (glob('/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state . '/Inspection/Deliverables/*.pdf') as $filename) {
        $filename = basename($filename);
        $report = '/data/box/SGS WIP/' . $sgs_year . '/SGS WIP ' . $sgs_4 . $sgs_2 . '/' . $sgs_floor . ' - ' . $site . ' - ' . $state . '/Inspection/Deliverables/' . $filename;
    }
    $size = fileSizeConvert(filesize($report));

    return $size;

}


?>