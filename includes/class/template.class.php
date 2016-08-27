<?php

class Template {

    function header($title, $theme) {
    //Head Tag
        $html = '
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$title.'</title>
    <link rel="stylesheet" href="/assets/css/theme/'.$theme.'.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
</head>
';
    //Nav Bar
        $html .= '
<body style="padding-top: 10px;">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" rel="home" href="#">Brand</a>
        </div>
        
        <div class="collapse navbar-collapse">
            
            <ul class="nav navbar-nav">
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
            </ul>
            <button type="button" class="btn btn-default navbar-btn">Button</button>
            <div class="col-sm-3 col-md-3 pull-right">
            <form class="navbar-form" role="search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search fa-2x"></i></button>
                </div>
            </div>
            </form>
            </div>
            
        </div>
    </div>
';
        return $html;
    }

    function footer() {
        return '
</body>
</html>';
    }

}
?>
