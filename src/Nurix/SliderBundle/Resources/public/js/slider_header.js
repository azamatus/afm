jQuery(function($)
{
    $("#carousel").rcarousel(
        {
            visible: 1,
            step: 1,
            speed: 500,
            auto:
            {
                enabled: true,
                interval: 4000
            },
            width: 700,
            height: 345,
            start: generatePages,
            pageLoaded: pageLoaded

        }
    );
    function generatePages()
    {
        var _total, i, _link;

        _total = $( "#carousel" ).rcarousel( "getTotalPages" );

        for ( i = 0; i < _total; i++ )
        {
            _link = $( "<a href='#'></a>" );

            $(_link)
                .bind("click", {page: i},
                function( event )
                {
                    $( "#carousel" ).rcarousel( "goToPage", event.data.page );
                    event.preventDefault();
                }
            )
                .addClass("bullet off" )
                .appendTo("#pages" );
        }

        $( "a:eq(0)", "#pages" )
            .removeClass("off" )
            .addClass("on" )
            .addClass("bullet2");
            //.css("background-image", "url('page-on.png')" );
    }
    function pageLoaded( event, data )
    {
        $( "a.on", "#pages" )
            .removeClass("on" )
            .removeClass("bullet2" )
            .addClass("bullet");
            //.css("background-image", "url('page-off.png')" );

        $( "a", "#pages" )
            .eq( data.page )
            .removeClass("bullet" )
            .addClass( "on" )
            .addClass("bullet2");
            //.css("background-image", "url('page-on.png')" );
    }



});