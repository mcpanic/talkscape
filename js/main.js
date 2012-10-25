var iframe = $('#player1')[0],
player = $f(iframe),
status = $('.status');

var log = log4javascript.getLogger();
var ajaxAppender = new log4javascript.AjaxAppender("/talkscape/ajax-add-log.php");
log.addAppender(ajaxAppender);

$(document).ready(function(){
    //$("#player1").fitVids();

    $("#add-highlight-button").click(function(){
        $(".add-highlight").show("slow");
        $(".add-highlight #highlight-title").val("");
        $(this).addClass("disabled");

        player.api('getCurrentTime', function (value) {
            $(".add-highlight").data("start_at", Math.floor(value));
            console.log($(".add-highlight").data("start_at"));
            console.log(Math.floor(value));
            $.ajax({
            url: "/talkscape/make-thumbnail.php",        
            type: "POST",
            data: {
                tm: $(".add-highlight").data("start_at"),
                filepath: $(".add-highlight").data("video_local_link")
            }}).done(function(data){
                $(".add-highlight img").attr("src", "/talkscape/" + data);                             
            }).fail(function(){
                $(".add-highlight img").html("capture failed."); 
            }).always(function(){
            });  
        });        
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "add-highlight-button", ""));      
    });

    $("#save-highlight-button").click(function(){
        $.post("/talkscape/crud.Highlight.php", { 
            action: "create",
            talk_id: $(".add-highlight").data("talk_id"),
            title: $(".add-highlight #highlight-title").val(),
            owner: $(".add-highlight #highlight-owner").val(),
            start_at: $(".add-highlight").data("start_at"),
            thumbnail_link: $(".add-highlight img").attr("src")
          },
          function( data ) {
            var obj = JSON.parse(data);
            if (obj.success) {
                var $current = findCurrentHighlight(parseInt(obj.start_at), 0);
                if ($current.length > 0)
                    $(obj.html).insertAfter($current).highlight();                    
                else
                    $(obj.html).appendTo($(".highlights")).highlight();                    
            }  
          }
        );    
        $(".add-highlight").hide("slow");
        $("#add-highlight-button").removeClass("disabled");
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "save-highlight-button", ""));      
    });

    $("#cancel-highlight-button").click(function(){
        $(".add-highlight").hide("slow");
        $("#add-highlight-button").removeClass("disabled");       
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "cancel-highlight-button", ""));      
    });   

    $(".highlights li a").click(function(){
        var seconds = Math.floor($(this).parent().data("start_at"));
        if (isInt(seconds))
            player.api("seekTo", seconds);

        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "highlight", $(this).parent().data("id")));      
    }); 

    $(".highlights").on("mouseenter", "li a", function(event){    
        $(this).find(".overlay-play").show();
    });

    $(".highlights").on("mouseleave", "li a", function(event){   
        $(this).find(".overlay-play").hide();
    });

    $(".toc").on("click", "li .open-detail", function(){
        triggerDetail($(this), true);
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "toc-open-detail", $(this).parent().data("id")));      
        return false;
    });

    $(".toc").on("click", "li .close-detail", function(){
        triggerDetail($(this), false);
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "toc-close-detail", $(this).parent().data("id"))); 
        return false;
    });   

    $(".toc li a").click(function(){
        var seconds = Math.floor($(this).parent().data("start_at"));
        if (isInt(seconds))
            player.api("seekTo", seconds);
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "toc", $(this).parent().data("id"))); 
    }); 

    $("#get-time-button").click(function(){
        player.api('getCurrentTime', function (value) {
            $("#form1 #start_at").val(Math.floor(value));
        });

    }); 

    $(".pager .previous").click(function(){
        var $active = $(".toc li.active").first();
        $active.prev().find("a").trigger("click");
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "toc-previous", "")); 
    });

    $(".pager .next").click(function(){
        var $active = $(".toc li.active").first();
        if ($active.length == 0) // if nothing is active, activate the first one.
            $(".toc li").first().find("a").trigger("click");
        else
            $active.next().find("a").trigger("click");
        log.info(formatLog($("body").data("talk_id"), "anonymous", "click", "toc-next", ""));
    });

    // When the player is ready, add listeners for pause, finish, and playProgress
    player.addEvent('ready', function() {
        player.addEvent('play', onPlay);
        player.addEvent('pause', onPause);
        player.addEvent('finish', onFinish);
        player.addEvent('playProgress', onPlayProgress);
        player.addEvent('seek', onSeek);
    });

    function onPlay(id) {
        log.info(formatLog($("body").data("talk_id"), "anonymous", "pause", "player", ""));
    }

    function onPause(id) {
        log.info(formatLog($("body").data("talk_id"), "anonymous", "pause", "player", ""));
    }

    function onFinish(id) {
        log.info(formatLog($("body").data("talk_id"), "anonymous", "finish", "player", ""));
    }
    
    function onPlayProgress(data, id) {
        updateActive(Math.floor(data.seconds));
    }

    function onSeek(data, id) {
        updateActive(Math.floor(data.seconds));
        log.info(formatLog($("body").data("talk_id"), "anonymous", "seek", "player", ""));
    }
});

(function(){
})();