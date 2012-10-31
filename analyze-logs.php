<?php
    include "conn.php";
    include "class.Talk.php";
    include "class.Label.php";
    include "class.Highlight.php";

    $conn->query("SET NAMES utf8");

    $stmt = $conn->prepare("SELECT * from logs WHERE time_added > '2012-10-25 23:00:00' ORDER BY time_added ASC");  
    //$stmt->setFetchMode();
    $stmt->execute();  
    $logs = array();
    while($obj = $stmt->fetch()) {          
        $logs[] = $obj;
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
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="/talkscape/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="/talkscape/css/main.css">

        <script src="/talkscape/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body data-talk_id="<?php echo $talk->id;?>">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <div class="container">
            <?php 
                foreach ($logs as $log){
                    $entry = json_decode($log["message"], true);
                    echo $log["id"] . ", " . $log["url"] . ", " . $log["time_added"] . ", " . $entry["talk_id"] . ", " . $entry["action"] . ", " . $entry["target"] . ", " . $entry["obj"] . "<br>";
                }
            ?>
        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/talkscape/js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

        <script src="/talkscape/js/vendor/bootstrap.min.js"></script>        
        <script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
        <script src="/talkscape/js/vendor/log4javascript.js"></script>
        <!--<script src="/talkscape/js/vendor/jquery.fitvids.js"></script>-->
        <script src="/talkscape/js/utils.js"></script>
        <script src="/talkscape/js/main.js"></script>

        <script type="text/javascript">


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