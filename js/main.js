$(document).ready(function(){
    var iframe = $('#player1')[0],
    player = $f(iframe),
    status = $('.status');

    $("#player1").fitVids();

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

    });

    $("#cancel-highlight-button").click(function(){
        $(".add-highlight").hide("slow");
        $("#add-highlight-button").removeClass("disabled");       
    });   

    $(".highlights li a").click(function(){
        var seconds = Math.floor($(this).parent().data("start_at"));
        if (isInt(seconds))
            player.api("seekTo", seconds);
    }); 

    $(".highlights").on("mouseenter", "li a", function(event){    
        $(this).find(".overlay-play").show();
    });

    $(".highlights").on("mouseleave", "li a", function(event){   
        $(this).find(".overlay-play").hide();
    });

    $(".toc").on("click", "li .open-detail", function(){
        triggerDetail($(this), true);
        return false;
    });

    $(".toc").on("click", "li .close-detail", function(){
        triggerDetail($(this), false);
        return false;
    });   

    $(".toc li a").click(function(){
        var seconds = Math.floor($(this).parent().data("start_at"));
        if (isInt(seconds))
            player.api("seekTo", seconds);
    }); 

    $("#get-time-button").click(function(){
        player.api('getCurrentTime', function (value) {
            $("#form1 #start_at").val(Math.floor(value));
        });

    }); 

    $(".pager .previous").click(function(){
        var $active = $(".toc li.active").first();
        $active.prev().find("a").trigger("click");
    });

    $(".pager .next").click(function(){
        var $active = $(".toc li.active").first();
        if ($active.length == 0) // if nothing is active, activate the first one.
            $(".toc li").first().find("a").trigger("click");
        else
            $active.next().find("a").trigger("click");
    });

    // When the player is ready, add listeners for pause, finish, and playProgress
    player.addEvent('ready', function() {
        //status.text('ready');
        
        //player.addEvent('pause', onPause);
        //player.addEvent('finish', onFinish);
        player.addEvent('playProgress', onPlayProgress);
        player.addEvent('seek', onSeek);
    });

    // Call the API when a button is pressed
    /*
    $('button').bind('click', function() {
        player.api($(this).text().toLowerCase());
    });
    
    function onPause(id) {
        status.text('paused');
        console.log('paused');
    }

    function onFinish(id) {
        status.text('finished');
    }
    */
    function onPlayProgress(data, id) {
        updateActive(Math.floor(data.seconds));
        /*
        status.text(data.seconds + 's played');
        var $current = $(".toc li.active").first();
        var $next = $current.next();
        //console.log($next.data("start_at"), Math.floor(data.seconds));
        if ($next.data("start_at") <= Math.floor(data.seconds) + 2){
            $current.removeClass("active");
            $next.addClass("active");
            $current.find("i").trigger("click");
            $next.find("i").trigger("click");
        }
        */
    }

    function onSeek(data, id) {
        updateActive(Math.floor(data.seconds));
    }
});

(function(){
})();