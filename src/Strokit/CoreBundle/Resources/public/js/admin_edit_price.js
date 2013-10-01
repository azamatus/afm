/**
 * Created with JetBrains PhpStorm.
 * User: azamat
 * Date: 18.05.13
 * Time: 15:00
 * To change this template use File | Settings | File Templates.
 */
$(function () {

        jQuery('.sonata-int-edit-inline').live('click', function (event) {
            event.preventDefault();
            var subject = jQuery(this);
            value = subject.parents(".admin_edit_price").find(".admin_edit_price_input").val();
            jQuery.ajax({
                url:subject.attr('href'),
                data:{"value":value},
                type:'POST',
                success:function (json) {
                    if (json.status === "OK") {
                        var elm = jQuery(subject);
                        var root = elm.parent().parent();
                        // fix issue with html comment ...
                        root.html(jQuery(json.content.replace(/<!--[\s\S]*?-->/g, "")).html());
                        root.children(".admin_edit_price").hide();
                        root.children(".admin_price").show();
                        root.effect("highlight", {'color':'#57A957'}, 2000);
                    } else {
                        jQuery(subject).parent().effect("highlight", {'color':'#C43C35'}, 2000);
                    }
                }
            });
        });

        jQuery('.admin_price').live('click', function (event) {
            var subject = jQuery(this);
            subject.hide();
            subject.parent().children(".admin_edit_price").show();
        });

        jQuery('.sonata-int-cancel-inline').live('click', function (event) {
            var subject = jQuery(this).parents(".admin_edit_price");
            subject.hide();
            subject.parent().children(".admin_price").show();
        });
    }
);
