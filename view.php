<?php
    include "conn.php";
    include "class.Talk.php";
    include "class.Label.php";
    include "class.Highlight.php";

    $slug = isset($_GET["slug"]) ? $_GET["slug"] : "";

    $conn->query("SET NAMES utf8");

    $stmt = $conn->prepare("SELECT * from talks WHERE slug=:slug");  
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Talk");  
    $stmt->execute(array('slug' => $slug));
    while($obj = $stmt->fetch()) {          
        $talk = $obj;
    }

    $stmt = $conn->prepare("SELECT * from labels WHERE talk_id=:id ORDER BY start_at ASC");  
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Label");
    $stmt->execute(array('id' => $talk->id));  
    $labels = array();
    while($obj = $stmt->fetch()) {          
        $labels[] = $obj;
    }  

    $stmt = $conn->prepare("SELECT * from highlights WHERE talk_id=:id ORDER BY start_at ASC");  
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Highlight");
    $stmt->execute(array('id' => $talk->id));  
    $highlights = array();
    while($obj = $stmt->fetch()) {          
        $highlights[] = $obj;
    }  

    // find out the domain:
    //$domain = $_SERVER['HTTP_HOST'];
    // find out the path to the current file:
    //$path = $_SERVER['SCRIPT_NAME'];
    //echo $path; // /talkscape/view.php
    //echo $_SERVER['DOCUMENT_ROOT']; // /Applications/MAMP/htdocs
    // An alternative way is to use REQUEST_URI instead of both
    // SCRIPT_NAME and QUERY_STRING, if you don't need them seperate:
    $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $talk->speaker . ": " . $talk->title . " | TalkScape"; ?></title>
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
                        <a class="brand" href="/talkscape/">TalkScape</a>
                        <!--
                        <div class="nav-collapse collapse"> 
                        <ul class="nav">
                            <li><a href="#">List</a></li>
                            <li><a href="#about">Add a talk</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                        </div>                    
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="container container-player">

            <div class="row player">    
                <div class="span8">
                <h3><?php echo $talk->title; ?></h3>
                <iframe id="player1" src="<?php echo $talk->video_link; ?>?api=1&player_id=player1" width="100%" height="400px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                </div>
                <div class="span4">

                    <!--
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_fblike_large' displayText='Facebook Like'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_email_large' displayText='Email'></span>
                    -->
                    <?php 
                        echo $talk->getHTML();
                    ?>
                    <br>
                    <span class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" style="vertical-align:top;zoom:1;*display:inline"></span>
                    <span>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-via="imjuhokim" data-hashtags="talkscape">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </span>                            
                </div>
            </div>
        </div>
        <div class="container container-features">
            <!-- Example row of columns -->
            <div class="row features">
                <div class="span4">
                    <h2>Highlights 
                        <a href="#" class="highlights-help" data-trigger="hover" data-content="Click the 'Add a highlight!' button to capture interesting moments in the video. Watch a highlight by clicking on it."><small>what is this?</small></a>
                    </h2>
                    <button class="btn btn-large" id="add-highlight-button"><i class="icon-star"></i> Add a highlight!</button>
                    <div class="add-highlight" data-talk_id="<?php echo $talk->id; ?>" data-video_local_link="<?php echo $talk->video_local_link; ?>">
                        <span class='thumb'><img src='' class='img-rounded'></span>
                        <span class='owner'><input type="text" placeholder="your name" class="input-xlarge" id="highlight-owner"></span>
                        <span class='title'><input type="text" placeholder="description for this highlight" class="input-xlarge" id="highlight-title"></span>
                        <br>
                        <button class="btn submit" id="save-highlight-button" data-talk_id="">Save</button> <button class="btn submit" id="cancel-highlight-button">Cancel</button>
                    </div>

                    <ul class="highlights nav nav-list nav-stacked ">
                        <?php 
                        foreach ($highlights as $highlight){
                            echo $highlight->getHTML();
                        }
                        ?>                    
                    </ul>
                </div>                
                <div class="span4">
                    <h2>Chapters
                        <a href="#" class="toc-help" data-trigger="hover" data-content="Watch any part you like in the talk. Click on a chapter to jump to that part."><small>what is this?</small></a>
                    </h2>
                    <ul class="pager">
                      <li class="previous">
                        <a href="#"><i class="icon-chevron-up"></i> Prev</a>
                      </li>
                      <li class="next">
                        <a href="#">Next <i class="icon-chevron-down"></i></a>
                      </li>
                    </ul>
                    <ul class="toc nav nav-list nav-stacked">
                        <?php 
                        foreach ($labels as $label){
                            echo $label->getHTML();
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="span4">
                    <h2>Discussion</h2>
                    <div class="fb-comments" data-href="<?php echo $currentUrl; ?>" data-num-posts="5" data-width="370" style="width:100%"></div>
                </div>
            </div>
            <hr>

            <footer>
                <p>TalkScape created by <a href="http://juhokim.com/">Juho Kim</a>. For feedback, comments, feature requests, and bug reports, please <a href="mailto:imjuhokim@gmail.com">email me</a>.</p>
            </footer>

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
        log.info(formatLog($("body").data("talk_id"), "anonymous", "view", "open", "page"));      
        $(".highlights-help").popover();
        $(".toc-help").popover();

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
