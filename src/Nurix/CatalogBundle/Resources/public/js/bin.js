$(function () {
    $('.button_buy').click(function () {
        var product_id = $(this).attr("product");
        var path = $(this).attr("href");
        $.ajax({
            url:path,
            data:{ id:product_id },
            error:function (data) {
                alert('ERROR');
            },
            success:function (data) {
                alert(data.title + ' добавлен в корзину');
            }
        });
    });

    $(".itemAdd").click(function () {
        var $input = $(this).next('.itemVvod');
        var amount = $input.val();
        amount++;
        $input.val(amount);

        goodTotal($input, amount);

    });
    $(".itemSub").click(function () {
        var $input = $(this).prev('.itemVvod');
        var amount = $input.val();
        if (amount > 1)
            amount--;
        $input.val(amount);

        goodTotal($input, amount);
    });

    function goodTotal($input, amount){
        var price = $('#price_' + $input.attr('id')),
            goodTotal = $('#goodTotal_' + $input.attr('id'));
        var Tsom = goodTotal.find('.Som'),
            Tdol = goodTotal.find('.Dollar');
        var som = price.find('.Som').html(),
            dol = price.find('.Dollar').html();
        som = parseFloat(som.replace(/[^\d]/gi, ''));
        dol = parseFloat(dol.replace(/[^\d]/gi, ''));

        Tsom.html(som * amount);
        Tdol.html(dol * amount);
    }

    $(".bin-remove-item").click(function(){
        var id = $(this).parents('tr').empty();
    });

    $('.itemVvod').bind("change blur", function(){
        var val = $(this).val();
        val = val.replace(/[^\d]/gi, '');
        $(this).val(val);

        goodTotal($(this), val);
    });
});