$(function () {
    function refreshWidget() {
        var widget_path = Routing.generate('nurix_bin_main_widget')//+"/bin/widget";//TODO:Перевести на js_router
        $.ajax({
            url:widget_path,
            success:function (data) {
                $("#bin_widget").html(data);
            }
        });
    }

    $(document).on('click','.button_buy,.button_buy_bin',function () {
        var id = $(this).attr("data-id");
        var path = Routing.generate("nurix_bin_ajax_add_item", { "id" : id });
        var $amount = 1, productPage = false;
        if ($(this).hasClass('button_buy_bin')){
            $amount = parseInt($('#item-amount').val());
            productPage = true;
        }
        $.ajax({
            url:path,
            data:{ amount : $amount, productPage : productPage  },
            success:function (data) {
                noty({
                    text: 'Товар добавлен в корзину',
                    type: 'success',
                    layout: 'topCenter',
                    timeout: 1200
                });
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

    $(document).on('click', ".remove-item", function(){
        var id = $(this).data('id'),
            url = Routing.generate("nurix_bin_delete_good", { "id" : id });
        noty({
            text: 'Вы действительно хотите удалить товар?',
            layout: 'center',
            killer: true,
            animation: {
                open: {height: 'toggle'},
                close: {height: 'toggle'},
                easing: 'swing',
                speed: 250
            },
            buttons: [
                {
                    addClass: 'btn btn-primary', text: 'Да', onClick: function($noty) {

                    $.ajax({
                        url:url,
                        error:function(){
                            alert('Что то не так!!!');
                        },
                        success:function (data) {
                            $("#"+id).remove();
                            calculate();
                            refreshWidget();
                        }
                    });

                    $noty.close();
                }
                },
                {
                    addClass: 'btn btn-danger', text: 'Нет', onClick: function($noty) {
                    $noty.close();
                }
                }
            ]
        });
    });

    $('.quantity-input').bind("change blur", function(){
        var val = $(this).val();
        val = val.replace(/[^\d]/gi, '');
        $(this).val(val);
        goodTotal($(this), val);
    });
});