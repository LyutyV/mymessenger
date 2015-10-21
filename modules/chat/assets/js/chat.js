var stopUpdate = false;

function reloadchat(message, clearChat) {
    if (!stopUpdate)
    {
        var url = $(".btn-send-comment").data("url");
        var model = $(".btn-send-comment").data("model");
        var userfield = $(".btn-send-comment").data("userfield");
        var user2Name = $(".box-title").text();
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: {message: message, model: model, userfield: userfield, user2Name: user2Name},
            success: function (html) {
                if (clearChat == true){
                    $("#chat_message").val("");
                }
                $("#chat-box").html(html['chat']);
            },
            error: function (xhr, ajaxOptions, thrownError){
            }
        });
    };
}
setInterval(function () {
    reloadchat('', false);
}, 2000);
$(".btn-send-comment").on("click", function () {
    var message = $("#chat_message").val();
    reloadchat(message, true);
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$(document).on('mouseover','.item', function(){$(this).css("background-color", "#f0f0f0")});
$(document).on('mouseout','.item', function(){$(this).css("background-color", "#ffffff")});

$("li a").click(function() {
    stopUpdate = true;
    var url = 'chat\\default\\getnewchat';
    var model = $(".btn-send-comment").data("model");
    var user2 = $(this).text();
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: {user2: user2, model: model},
        success: function (html) {
            $("#chat-box").html(html['chat']);
            $(".box-title").text(html['user2']);
        },
        error: function (xhr, ajaxOptions, thrownError){
            var x = 0;
        }
    });
    stopUpdate = false;
});

$(document).on("click", "#deleteButton", function () {
    var url = 'chat\\default\\deletemessage';
    var model = $(this).data("id");
});

$(document).on("click", "#editButton", function () {
    var t = 0;
});