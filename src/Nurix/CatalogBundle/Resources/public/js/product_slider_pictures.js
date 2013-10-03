$(window).bind("load", function () {
    $("div#my-folio-of-works").slideViewerPro({

        thumbs:3,
        galBorderWidth:1,
        thumbsBorderWidth: 2,
        buttonsTextColor: "#bbb",
        galBorderColor: "#dddddd",
        thumbsBorderOpacity:0.1,
        thumbsActiveBorderOpacity:0.5,
        thumbsActiveBorderColor:"none",
        thumbsPercentReduction:30,
        buttonsWidth: 7,
        leftButtonInner: "<", //could be an image "<img src='images/larw.gif' />" or an escaped char as "&larr";
        rightButtonInner: ">" //could be an image or an escaped char as "&rarr";
    });
    $('.slideViewer img').elevateZoom({cursor: 'pointer'});
    $(".slideViewer a.fancybox-thumb").fancybox();
});
/*
//initiate the plugin and pass the id of the div containing gallery images
jQuery(document).ready(function ($) {
$("#zoom_1").elevateZoom(
    {
        gallery:'gallery_01',
        cursor: 'pointer',
        galleryActiveClass: 'active',
        imageCrossfade: true,
        loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'}
);
    $("#zoom_1").bind("click", function(e) {
        var ez =   $('#zoom_1').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
    });
});

 */