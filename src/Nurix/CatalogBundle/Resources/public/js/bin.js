$(function () {
    function refreshWidget() {
        var widget_path = base_url+"/bin/widget";//TODO:Перевести на js_router
        $.ajax({
            url:widget_path,
            success:function (data) {
                $("#bin_widget").html(data);
            }
        });
    }

    $(document).on('click','.button_buy,.button_buy_bin',function () {
        var path = $(this).attr("id");
        var $amount = 1, productPage = false;
        if ($(this).hasClass('button_buy_bin')){
            $amount = parseInt($('#amount').val());
            productPage = true;
        }
        $.ajax({
            url:path,
            data:{ amount : $amount, productPage : productPage  },
            success:function (data) {
                alert("Товар добавлен в корзину");
                refreshWidget();
            }
        });
    });

    $(".itemAdd").click(function () {
        var input = $(this).prev('.quantity-input');
        var amount = input.val();
        amount++;
        input.val(amount);
        goodTotal(input, amount);

    });
    $(".itemSub").click(function () {
        var input = $(this).next('.quantity-input');
        var amount = input.val();
        if (amount > 1)
            amount--;
        input.val(amount);
        goodTotal(input, amount);
    });

    function goodTotal(input, amount){
        var price = $('#price_' + input.attr('id')),
            goodTotal = $('#goodTotal_' + input.attr('id'));


        var dol = price.find(".value").html();

        dol = parseFloat(dol.replace(/[^\d\.]/gi, ''));

        goodTotal.find(".value").html(dol * amount);
        calculate();
    }

    function calculate() {
        var sumUSD = 0;
        $('.bin-table').find('tr[id]').each(function (i, el) {
            value = $(this).find('.tDollar > .value').html();
            sumUSD += parseFloat(value);
        });

        $('.bin_itemTotalPrice > .value').html(sumUSD.toString());
    }

    $(".remove-item").click(function(){
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

    $('.quantity-input').bind("change blur", function(){
        var val = $(this).val();
        val = val.replace(/[^\d]/gi, '');
        $(this).val(val);
        goodTotal($(this), val);
    });
});