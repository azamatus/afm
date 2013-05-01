$(function () {
    $('#showMoreRnd').click(function () {
        var path = $(this).attr("href");
        $.ajax({
            url: path,
            type: "GET",
            error: function (data) {
                alert('ERROR');
            },
            success: function (data) {
                var $new = $(data);
                $('#all-catalog .navigation').remove();
                $('#all-catalog').append($new);
                $new.show('slow');
            }
        });
        return false;
    });
});