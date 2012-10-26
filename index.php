<?php
    include "conn.php";
    include "class.Talk.php";
    include "class.Label.php";
   
    $conn->query("SET NAMES utf8");

    $stmt = $conn->prepare("SELECT * from talks");  
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Talk");  
    $talks = array();
    $labels = array();
    while($talk = $stmt->fetch()) {          
        $talks[] = $talk;

        $stmt2 = $conn->prepare("SELECT * from labels WHERE talk_id=:id");  
        $stmt2->setFetchMode(PDO::FETCH_CLASS, "Label");
        $stmt2->execute(array('id' => $talk->id));  
        while($label = $stmt2->fetch()) {          
            $labels[] = $label;
        }  
    }  

    
 
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/talkscape/css/bootstrap.min.css">
        <style>
            body {
                padding-top: 450px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="/talkscape/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="/talkscape/css/main.css">

        <script src="/talkscape/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=156951717782971";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>


        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <!--
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    -->
                    <div class="row">
                        <a class="brand" href="#">TalkScape</a>
                        <h4><?php echo $talk->title; ?></h4>
                    </div>
                    <!--<div class="nav-collapse collapse">-->

                        <div class="row">    
                            <div class="span9">
                            
                            </div>
                            <div class="span3">
                                <?php 
                                    echo $talk->getHTML();
                                ?>
                            </div>
                        </div>
                        <!--
                        <ul class="nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        -->

                </div>
            </div>
        </div>

        <div class="container">
            <hr>

            <footer>
                <p>TalkScape created by <a href="http://juhokim.com/">Juho Kim</a>. For feedback, comments, feature requests, and bug reports, please <a href="mailto:imjuhokim@gmail.com">email me</a>.</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/talkscape/js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

        <script src="/talkscape/js/vendor/bootstrap.min.js"></script>        
        <script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
        <script src="/talkscape/js/vendor/jquery.fitvids.js"></script>
        <script src="/talkscape/js/main.js"></script>

        <script>
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-1145660-2']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>
    </body>
</html>
