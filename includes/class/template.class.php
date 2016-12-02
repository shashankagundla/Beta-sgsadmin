<?php

class Template {

    function header($page = null, $subtitle = null) {
    $_SESSION['user']['lpage'] = $_SERVER['REQUEST_URI'];
    if ($subtitle){
        $subtitle = '<small>'.$subtitle.'</small>';
    }

    //Head Tag
        $html = '
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$page.'</title>
    <link rel="stylesheet" href="/assets/css/theme/'.$_SESSION['user']['theme'].'.css">
    <link rel="stylesheet" href="/assets/css/datatables.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/theme/custom.css">
    <link rel="stylesheet" href="/assets/css/animate.min.css">
</head>
';
    //debug notice
   if ($_SESSION['user']['debug'] != 0){
$html .= '
<div class="alert alert-danger text-center alert-no-pad">
<strong>Oh snap!</strong> Site Debug Mode is Enabled!</div>';
}
    //TODO: Add Profile Image and Padding CSS class for right nav bar
    //Nav Bar

        $html .= '
<body>
    <div class="navbar navbar-default navbar-static-top" role="navigation">
        
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" rel="home" href="#">SGS Admin</a>
        </div>
        
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dashboards <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/dashboard/inspection/">Inspections</a></li>
                    <li><a href="/dashboard/engineering/">Engineering</a></li>
                    <li><a href="/dashboard/atc/">ATC</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Schedule <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/schedule/main/">Main</a></li>
                    <li><a href="/schedule/tia/">TIA</a></li>
		            <li role="separator" class="divider"></li>
                    <li><a href="/schedule/color/">Change Crew Colors</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jobs <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/list/active/">Active</a></li>
                    <li><a href="/list/history/">History</a></li>
		            <li role="separator" class="divider"></li>
                    <li><a href="/job/add/">Add Job</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bids <b class="caret"></b></a>
                  <ul class="dropdown-menu">
		            <li role="separator" class="divider"></li>
                    <li><a href="/bid/add/">Add Bid</a></li>
                  </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          <span class="glyphicon glyphicon-user" aria-hidden="true"></span>'. $_SESSION['user']['fname'] . ' <span class="caret"></span> </a>
		          <ul class="dropdown-menu dropdown-menu">
		            <li><a onclick="window.open(\'https://speedtest.sgsadmin.com\',\'Connection Test\',\'width=750,height=2000\')">Test Connection</a></li>
					<li role="separator" class="divider"></li>
		            <li><a href="/account/logout/">Logout</a></li>
		          </ul>
		        </li>
	      </ul>
          <div class="col-sm-3 col-md-3 pull-right">
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search SGS Admin">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" style="padding-top: 12px; padding-bottom: 10px;"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">';
        if ($page){
        $html .='
        <div class="page-header">
            <h4>'.$page.'</h4>'.$subtitle.'
        </div>';
        }
        return $html;
    }

    function footer() {
        return '
</div>
</body>
<script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="/assets/js/bs.js"></script>
<script src="/assets/js/custom.js"></script>
<script src="/assets/js/bootstrap-notify.min.js"></script>
<script src="/assets/js/moment.js"></script>
<script src="/assets/js/mt.min.js"></script>
<script src="/assets/js/shortcuts.js"></script>
';
    }

    function notify(){
        if ($_SESSION['notify']){
            $notification = '<script>$.notify({message: "'.$_SESSION["notify"]["message"].'"}, {type: "'.$_SESSION["notify"]["type"].'"});</script>';
            unset($_SESSION['notify']);
            return($notification);
        };
    }
}
?>
