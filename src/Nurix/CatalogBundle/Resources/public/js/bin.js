$(function () {
    $('.button_buy').click(function () {
        var product_id = $(this).attr("product");
        var path = $(this).children("a:first").attr("href");
        $.ajax({
            url:path,
            data:{ id:product_id },
            error:function (data) {
                alert('ERROR1');
            },
            success:function (data) {
                alert(data.title + ' was added!!!');
            }
        });
    });
});