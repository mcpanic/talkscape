<?php
    include "conn.php";
    include "class.Talk.php";
    include "class.Label.php";
    
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
                padding-top: 500px;
                padding-bottom: 40px;
            }

            .form-horizontal .control-label{
                width: 100px;
            }
            .form-horizontal .controls {
                margin-left: 120px;
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
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    
                    <div class="row">
                        <a class="brand" href="#">TalkScape</a>
                        <div class="nav-collapse collapse"> 
                        <ul class="nav">
                            <li><a href="#">List</a></li>
                            <li><a href="#about">Add a talk</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                        </div>                    
                    </div>

                    <div class="row">    
                        <div class="span8">
                        <h4><?php echo $talk->title; ?></h4>
                        <iframe id="player1" src="<?php echo $talk->video_link; ?>?api=1&player_id=player1" width="100%" height="400px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        </div>
                        <div class="span4">
                            <!--
                            <span class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" style="vertical-align:top;zoom:1;*display:inline"></span>
                            <span>
                            <a href="https://twitter.com/share" class="twitter-share-button" data-via="imjuhokim" data-hashtags="talkscape">Tweet</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </span>
                            
                            <span class='st_facebook_large' displayText='Facebook'></span>
                            <span class='st_fblike_large' displayText='Facebook Like'></span>
                            <span class='st_twitter_large' displayText='Tweet'></span>
                            <span class='st_email_large' displayText='Email'></span>
                            -->
                            <?php 
                                echo $talk->getHTML();
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                <div class="span6">
                    <h2>Table of Content</h2>
                    <ul class="pager">
                      <li class="previous">
                        <a href="#"><i class="icon-chevron-up"></i> Prev</a>
                      </li>
                      <li class="next">
                        <a href="#">Next <i class="icon-chevron-down"></i></a>
                      </li>
                    </ul>
                    <ul class="nav nav-list nav-stacked toc">
                        <?php 
                        foreach ($labels as $label){
                            echo $label->getAdminHTML();
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="span6">
                    <h2 id="action-label">Add a New Label</h2>
                    <form id="form1" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="start_at">Starting Time</label>
                            <div class="controls">
                                  <input type="text" id="start_at" placeholder="starting time" class="input-small">
                                  <button class="btn btn-primary" id="get-time-button">Get current time</button>
                            </div>                                                
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="title">Title</label>
                            <div class="controls">
                              <input type="text" id="title" placeholder="label title" class="input-xlarge">
                            </div>
                        </div>
                    

                        <label>Details <small>(you can use the <a href="http://daringfireball.net/projects/markdown/basics">Markdown</a> syntax.)</small></label>                                       
                        <div id="epiceditor"></div>
                        <button class="btn btn-large btn-primary" id="save-button">Save</button>
                    </form>                    

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
        <!--<script src="/talkscape/js/vendor/jquery.fitvids.js"></script>-->
        <script src="/talkscape/js/vendor/epiceditor/js/epiceditor.min.js"></script>
        <script src="/talkscape/js/vendor/log4javascript.js"></script>
        <script src="/talkscape/js/utils.js"></script>
        <script src="/talkscape/js/main.js"></script>
        <script>
            var opts = {
              container: 'epiceditor',
              basePath: '/talkscape/js/vendor/epiceditor',
              clientSideStorage: true,
              localStorageName: 'epiceditor',
              parser: marked,
              file: {
                name: 'epiceditor',
                defaultContent: '',
                autoSave: 100
              },
              theme: {
                base:'/themes/base/epiceditor.css',
                preview:'/themes/preview/preview-dark.css',
                editor:'/themes/editor/epic-dark.css'
              },
              focusOnLoad: false,
              shortcut: {
                modifier: 18,
                fullscreen: 70,
                preview: 80,
                edit: 79
              }
            }        
            var editor = new EpicEditor(opts).load();
            editor.importFile("epiceditor", ""); 
                        
            /* attach a submit handler to the form */
            //$("#form1").submit(function(event) {
            $(document).on("click", "#save-button", function(){
                /* stop form from submitting normally */
                event.preventDefault(); 
                
                var detail = editor.exportFile();
                //var detail = $(editor.getElement('previewer').body).find("div").html();
                
                $.post("/talkscape/crud.Label.php", { 
                    action: "create",
                    talk_id: "<?php echo $talk->id; ?>",
                    title: $("#form1 #title").val(),
                    start_at: $("#form1 #start_at").val(),
                    detail: detail
                  },
                  function( data ) {
                    var obj = JSON.parse(data);
                    if (obj.success) {
                        var $current = findCurrentLabel(parseInt(obj.start_at), 0);
                        if ($current.length > 0)
                            $(obj.html).insertAfter($current).highlight();                    
                        else
                            $(obj.html).appendTo($(".toc")).highlight(); 

                        recoverCreateMode();
                    }  
                  }
                );
            });

            // when 'delete' is clicked
            $(document).on("click", ".delete-link", function(e){
                var $li = $(this).parent();
                var id = $li.data("id");

                $.post("/talkscape/crud.Label.php", { 
                    action: "delete",
                    id: id
                  },
                  function( data ) {
                    var obj = JSON.parse(data);
                    if (obj.success){
                        var $li = findLabelById(id);
                        $li.hide('slow', function(){$li.remove(); });
                    }
                  }
                );
                return false;  
            });

            // when 'edit' is clicked
            $(document).on("click", ".update-link", function(e){
                var $li = $(this).parent();
                var id = $li.data("id");
                
                $("#action-label").text("Edit a Label");
                $("#form1 #title").val($li.find(".title").text());
                $("#form1 #start_at").val($li.data("start_at"));
                $("#save-button").attr("id", "update-save-button");
                $("#update-save-button").data("label-id", id);
                editor.importFile("epiceditor", $li.find(".detail-raw").html());
                if ($("#update-cancel-button").length == 0)
                    $("<button class='btn btn-large' id='update-cancel-button'>Cancel</button>").insertAfter("#update-save-button");
                return false;
            });

            function recoverCreateMode(){
                $("#action-label").text("Add a New Label");
                $("#form1 #title").val("");
                $("#form1 #start_at").val("");
                $("#update-save-button").attr("id", "save-button");
                $("#update-cancel-button").remove();
                editor.importFile("epiceditor", "");     
            }

            // when 'edit - save' is clicked
            $(document).on("click", "#update-save-button", function(e){
                //var $li = $(this).parent();
                var id = $(this).data("label-id");
                var detail = editor.exportFile();
                $.post("/talkscape/crud.Label.php", { 
                    action: "update",
                    id: id,
                    title: $("#form1 #title").val(),
                    start_at: $("#form1 #start_at").val(),
                    detail: detail                  
                  },
                  function( data ) {
                    var obj = JSON.parse(data);
                    if (obj.success){
                        var $li = findLabelById(id);
                        $li.replaceWith(obj.html);                         
                        // find again to highlight. since it's replaced, just running highlight will not work.
                        $li = findLabelById(id);
                        $li.highlight(); 
                        recoverCreateMode();
                    }                 
                  }      
                );    
                return false;
            });

            // when 'edit - cancel' is clicked, go back to the "add new" mode.
            $(document).on("click", "#update-cancel-button", function(e){
                recoverCreateMode();             
                return false;
            });            
        </script>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-35846694-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </body>
</html>
