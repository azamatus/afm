$(function () {
    $(document).on('click','#showMoreRnd',function () {
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
                $new.show(1000);
            }
        });
        return false;
    });
});