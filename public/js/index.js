var querylength = 2;
var navindex = 1;
var selection = {};
var submit_data = function(key) {
    var pharse = $("#pharse").val().trim();
    // console.log(key)
    if (key) {
        if (key.keyCode === 27) return $("#searchKeyLists").html(' ');
        var restrict = [17, 16, 18, 37, 39];
        if (restrict.indexOf(key.keyCode) > -1) return false;

        var nav = [38, 40];
        if (key.keyCode === 38) {
            $("#searchKeyLists").children().removeClass("highlight");
            $("#searchKeyLists").find($("#searchKeyLists").children()[navindex]).addClass("highlight");
            selection = JSON.parse($("#searchKeyLists").find($("#searchKeyLists").find($("#searchKeyLists").children()[navindex]).children()[0]).html());
            $("#pharse").val(selection.location);

            if (navindex <= 1) navindex = $("#searchKeyLists").children().length;
            if (navindex != 0) navindex--;
            return false;
        } else if (key.keyCode === 40) {
            $("#searchKeyLists").children().removeClass("highlight");
            $("#searchKeyLists").find($("#searchKeyLists").children()[navindex]).addClass("highlight");
            selection = JSON.parse($("#searchKeyLists").find($("#searchKeyLists").find($("#searchKeyLists").children()[navindex]).children()[0]).html());
            $("#pharse").val(selection.location);
            if (navindex >= $("#searchKeyLists").children().length - 1) navindex = 0;
            navindex++;
            return false;
        }

        if (pharse.length > querylength) {
            ajxCall({
                key: pharse,
                json: true

            });
        } else {
            $("#searchKeyLists").html(' ');
        }
    } else {
        window.top.location.href = "query.php?key=" + pharse + "&id=" + selection.id;
    }
}

$(document).ready(function() {
    $("#pharse").focus();
    $("#pharse").keyup(function(key) {
        submit_data(key);
    });
});

var ajxCall = function(options) {
    $("#searchKeyLists").html('');
    $("#loadingDiv").show();
    $.get('query.php', options, function(data) {
        oldphrase = null;
        var res = JSON.parse(data);
        if (res.success) {
            var results = JSON.parse(res.data);
            if (results.length > 0) {
                $("#searchKeyLists").html(' ');
                $("#searchKeyLists").append("<li class='list-group-item active' > Top " + results.length + " Results found for <b>'" + options.key + "'</b></li>")
                results.forEach(function(element, index) {
                    var obj = {
                        location: element.location,
                        slug: element.slug,
                        population: element.slug,
                        phrase: options.key,
                        id : element.id
                    }
                    $("#searchKeyLists").append("<li class='list-group-item'>  <label style='display:none;'>" + JSON.stringify(obj) + "</label> <a href=''> " + element.location.replace(options.key, '<mark>' + options.key + '</mark>') + "</a> <br/> Population: " + element.population + " <br/> State Code: " + element.slug.replace(options.key, '<mark>' + options.key + '</mark>') + "</li>");
                });
            } else {
                $("#searchKeyLists").html(' ');
                $("#searchKeyLists").append("<li class='list-group-item active' >  No any result found for <b>'" + options.key + "'</b> </li>")
            }
        } else {
            $("#searchKeyLists").html(' ');
        }
        $("#loadingDiv").hide();
    });
}