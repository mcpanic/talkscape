// Return a label that is closest to the given 'seconds'
function findCurrentLabel(seconds, tolerance){
    var $current = $();
    $(".toc > li").each(function(i, element){
        if ($(element).data("start_at") <= seconds + tolerance)
            $current = $(element);
        else
            return false;
    });
    return $current;
}

function findCurrentHighlight(seconds, tolerance){
    var $current = $();
    $(".highlights > li").each(function(i, element){
        if ($(element).data("start_at") <= seconds + tolerance)
            $current = $(element);
        else
            return false;
    });
    return $current;
}

function findLabelById(id){
    var $current = $();
    $(".toc > li").each(function(i, element){
        if ($(element).data("id") == id) {
            $current = $(element);
            return false;
        }
    });
    return $current;
}

// Update the active label so that it accurately reflects the player progress.
function updateActive(seconds){
    var $current = findCurrentLabel(seconds, 3);
    var $old = $(".toc li.active").first();
    //console.log($current != $old, $current.data("start_at") != $old.data("start_at"), $current, $old);
    if ($current.data("start_at") != $old.data("start_at")){
        $old.removeClass("active");
        $current.addClass("active");
        triggerDetail($old.find(".close-detail"), false);
        triggerDetail($current.find(".open-detail"), true);
        //$old.find(".close-detail").trigger("click");
        //$current.find(".open-detail").trigger("click");

    }
}

function isInt(n) {
   return typeof n === 'number' && n % 1 == 0;
}

jQuery.fn.highlight = function() {
    var obj = $(this[0]) // It's your element
    var orig = obj.css("background-color");
    obj.css("background-color", "rgb(255, 255, 166)");
    setTimeout(function(){
        obj.css("background-color", orig);
    }, 5000);
};


// Show or hide details of a TOC label
function triggerDetail(element, isShow) {
    if (isShow){
        element.parent().find(".detail").show();
        element.removeClass("open-detail");
        element.addClass("close-detail");
        element.removeClass("icon-chevron-down");
        element.addClass("icon-chevron-up");
    } else {
        element.parent().find(".detail").hide();
        element.removeClass("close-detail");
        element.addClass("open-detail");
        element.removeClass("icon-chevron-up");
        element.addClass("icon-chevron-down");       
    }
}