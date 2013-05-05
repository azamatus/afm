$(function () {
    function refreshWidget() {
        var widget_path = base_url+"bin/widget";
        $.ajax({
            url:widget_path,
            success:function (data) {
                $("#bin_widget").html(data);
            }
        });
    }

    $(document).on('click','.button_buy,.button_buy_bin',function () {
        var path = $(this).attr("href");
        var $amount = 1, productPage = false;
        if ($(this).hasClass('button_buy_bin')){
            $amount = parseInt($('#amount').val());
            productPage = true;
        }
        $.ajax({
            url:path,
            data:{ amount : $amount, productPage : productPage  },
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
        if (confirm("Вы действительно хотите удалить товар?")){
            var id = $(this).data('id'),
                url = Routing.generate("nurix_bin_delete_good", { "id" : id });
            $.ajax({
                url:url,
                error:function(){
                    alert('error');
                },
                success:function (data) {
                    $("#"+id).remove();
                    calculate();
                    refreshWidget();
                }
            });
        }
        return false;
    });

    $('.itemVvod').bind("change blur", function(){
        var val = $(this).val();
        val = val.replace(/[^\d]/gi, '');
        $(this).val(val);

        goodTotal($(this), val);
    });
});