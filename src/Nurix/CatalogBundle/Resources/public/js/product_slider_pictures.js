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
});
