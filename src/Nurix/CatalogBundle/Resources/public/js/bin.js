$(function () {

    function refreshWidget() {
        var widget_path = base_url+"bin/widget";
        $.ajax({
            url:widget_path,
            error:function (data) {
                alert('ERROR');
            },
            success:function (data) {
                $("#bin_widget").html(data);
            }
        });
    }

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
                $('#tovar-added').empty().html(data).dialog(
                        {
                            closeText: "",
                            minHeight: 300,
                            minWidth: 450
                        }
                    );
                refreshWidget();
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
        var Tsom = goodTotal.find('.Som > .value'),
            Tdol = goodTotal.find('.Dollar > .value');
        var som = price.find('.Som > .value').html(),
            dol = price.find('.Dollar > .value').html();
        som = parseFloat(som.replace(/[^\d]/gi, ''));
        dol = parseFloat(dol.replace(/[^\d]/gi, ''));

        Tsom.html(som * amount);
        Tdol.html(dol * amount);
        calculate();
    }

    function calculate() {
        var sumSom = 0;
        var sumUSD = 0;
        $('.bin-table').find('tr[id]').each(function (i, el) {
            var value = $(this).children('td:last').find('.Som > .value').html();
            sumSom += parseFloat(value);
            value = $(this).children('td:last').find('.Dollar > .value').html();
            sumUSD += parseFloat(value);
        });
        $('.bin_itemTotalPrice .Som > .value').html(sumSom.toString());
        $('.bin_itemTotalPrice .Dollar > .value').html(sumUSD.toString());
    }

    $(".bin-remove-item").click(function(){
        var tr = $(this).parents('tr');
        id = tr.attr('id');
        tr.parent().removeChild(tr);
        calculate();
    });

    $('.itemVvod').bind("change blur", function(){
        var val = $(this).val();
        val = val.replace(/[^\d]/gi, '');
        $(this).val(val);

        goodTotal($(this), val);
    });
});