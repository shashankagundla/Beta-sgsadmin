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
    <script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
</head>
';
    //Nav Bar
        $html .= '
<body>
    <div class="container-fluid">
        <div class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <a href="../" class="navbar-brand">Bootswatch</a>
              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
                  <ul class="dropdown-menu" aria-labelledby="themes">
                    <li><a href="../default/">Default</a></li>
                    <li class="divider"></li>
                    <li><a href="../cerulean/">Cerulean</a></li>
                    <li><a href="../cosmo/">Cosmo</a></li>
                    <li><a href="../cyborg/">Cyborg</a></li>
                    <li><a href="../darkly/">Darkly</a></li>
                    <li><a href="../flatly/">Flatly</a></li>
                    <li><a href="../journal/">Journal</a></li>
                    <li><a href="../lumen/">Lumen</a></li>
                    <li><a href="../paper/">Paper</a></li>
                    <li><a href="../readable/">Readable</a></li>
                    <li><a href="../sandstone/">Sandstone</a></li>
                    <li><a href="../simplex/">Simplex</a></li>
                    <li><a href="../slate/">Slate</a></li>
                    <li><a href="../spacelab/">Spacelab</a></li>
                    <li><a href="../superhero/">Superhero</a></li>
                    <li><a href="../united/">United</a></li>
                    <li><a href="../yeti/">Yeti</a></li>
                  </ul>
                </li>
                <li>
                  <a href="../help/">Help</a>
                </li>
                <li>
                  <a href="http://news.bootswatch.com">Blog</a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Cyborg <span class="caret"></span></a>
                  <ul class="dropdown-menu" aria-labelledby="download">
                    <li><a href="http://jsfiddle.net/bootswatch/q0gdqa1q/">Open Sandbox</a></li>
                    <li class="divider"></li>
                    <li><a href="./bootstrap.min.css">bootstrap.min.css</a></li>
                    <li><a href="./bootstrap.css">bootstrap.css</a></li>
                    <li class="divider"></li>
                    <li><a href="./variables.less">variables.less</a></li>
                    <li><a href="./bootswatch.less">bootswatch.less</a></li>
                    <li class="divider"></li>
                    <li><a href="./_variables.scss">_variables.scss</a></li>
                    <li><a href="./_bootswatch.scss">_bootswatch.scss</a></li>
                  </ul>
                </li>
              </ul>
    
              <ul class="nav navbar-nav navbar-right">
                <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
                <li><a href="https://wrapbootstrap.com/?ref=bsw" target="_blank">WrapBootstrap</a></li>
              </ul>
    
            </div>
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
