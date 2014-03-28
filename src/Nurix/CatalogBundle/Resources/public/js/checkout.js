
$(function(){

    function showDeliveryBlock() {
        $("#chechout-delivery").find(".checkout-content").show();
        $("#chechout-delivery").find('.icon-caret-right').removeClass().addClass('icon-caret-down');
    }
    function hideDeliveryBlock() {
        $("#chechout-delivery").find(".checkout-content").hide();
        $("#chechout-delivery").find('.icon-caret-down').removeClass().addClass('icon-caret-right');
    }

    if ($("#bin_clients_delivery").is(':checked')){
        $("#chechout-delivery").find(".checkout-content").css("display", "block");
    }
    $('#chechout-delivery').find('.checkout-header a').click(function(){
        var deliveryCheckbox =$("#bin_clients_delivery");
        deliveryCheckbox.prop('checked', !deliveryCheckbox.is(':checked'));
        if (deliveryCheckbox.is(':checked')) {
            showDeliveryBlock();
        } else {
            hideDeliveryBlock();
        }
        return false;
    });
});