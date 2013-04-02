/**
 * Created with JetBrains PhpStorm.
 * User: Admin
 * Date: 02.02.13
 * Time: 17:49
 * To change this template use File | Settings | File Templates.
 */
jQuery(document).ready(function ($) {
    $("#add").click(function () {
        var amount = $("#amount").val();
        amount++;
        $("#amount").val(amount);
    });
    $("#rem").click(function () {
        var amount = $("#amount").val();
        if (amount > 1)
            amount--;
        $("#amount").val(amount);
    });

    $('#amount').bind("change blur", function(){
        var val = $(this).val();
        val = val.replace(/[^\d]/gi, '');
        $(this).val(val);
    });
});
