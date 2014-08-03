function topNavToSelect() {
	// building select menu
	$('<select class="upper-nav" />').appendTo('.upperHeader .container');

	// building an option for select menu
	$('<option />', {
		'selected': 'selected',
		'value' : '',
		'text': 'Choise Page...'
	}).appendTo('.upperHeader .container select');

	$('.upperHeader ul.inline li a').each(function(){
		var target = $(this);

		$('<option />', {
			'value' : target.attr('href'),
			'text': target.text()
		}).appendTo('.upperHeader .container select');
	});
	// on clicking on link
	$('.upperHeader .container select').on('change',function(){
		window.location = $(this).find('option:selected').val();
	});
}

// building select .navbar for mobile width only
function NavToSelect() {

	// building select menu
	$('<select />').appendTo('.navbar');

	// building an option for select menu
	$('<option />', {
		'selected': 'selected',
		'value' : '',
		'text': 'Choise Page...'
	}).appendTo('.navbar select');

	$('.navbar ul li a').each(function(){
		var target = $(this);

		$('<option />', {
			'value' : target.attr('href'),
			'text': target.text()
		}).appendTo('.navbar select');
	});
	// on clicking on link
	$('.navbar select').on('change',function(){
		window.location = $(this).find('option:selected').val();
	});

}


// bootstrap tooltip invocking
function showtooltip() {
	$('a[data-toggle=tooltip], button[data-toggle=tooltip], input[data-toggle=tooltip]')
	.tooltip({
		animation:false
	});
}

function cartContent() {
	var $cartContent = $('.cart-content');
	$cartContent.find('table').click(function(e){
		e.stopPropagation();
	});
}

// flexslider on home page
function flexSlideShow() {
	$('.flexslider').flexslider({
		 animation: "slide",
		 slideshowSpeed: 4000,
		 directionNav: false,
		 pauseOnHover: true,
		 directionNav: false
	});
}

// bootstrap carousel in caregories grid and list
function productSlider() {
	$('.carousel').carousel();
}


// link fancybox plugin on product detail
function productFancyBox() {
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});
}

// dropdown mainnav
function dropdownMainNav() {
	var navLis = $('div.navbar > ul.nav > li');
	navLis.hover(
		function () {
			// hide the css default behavir
			$(this).children('div').css('display', 'none');
			//show its submenu
			$(this).children('div').slideDown(150);
		}, 
		function () {
			//hide its submenu
			$(this).children('div').slideUp(350);		
		}
	);

}

// display your twiter feed here
function latestTweets() {
	
    $(".tweet").tweet({
        username: "seaofclouds",
        join_text: "auto",
        avatar_size: 0,
        count: 3,
        auto_join_text_default: "we said,", 
        auto_join_text_ed: "we",
        auto_join_text_ing: "we were",
        auto_join_text_reply: "we replied to",
        auto_join_text_url: "we were checking out",
        loading_text: "loading tweets..."
    });
}

// open and hide the side panel
function openSidePanel() {
	var widgetToggleLink = $('a.Widget-toggle-link'),
		$switcher = $(".switcher");

	widgetToggleLink.on('click', function(e){
		e.preventDefault();
		var left = $switcher.css('left');
		if(left <= '-170px'){
			$switcher.animate({
				left: 0
			}, 200, function(){
				$(this).find(widgetToggleLink).text('-');
			});
		}else{
			$switcher.animate({
				left: '-170px'
			}, 200, function(){
				$(this).find(widgetToggleLink).text('+');
			});
		}
	});
}






// range price product
function rangePriceSlider() {
	var $slideRange = $("#slider-range"),
		amount = $( "#amount" );
	$slideRange.slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        amount.val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    amount.val( "$" + $slideRange.slider( "values", 0 ) +
      " - $" + $slideRange.slider( "values", 1 ) );
}

function changeCatalogStyle(){
    $(".btn-group .change_catalog_view").click(function(){
        $(this).siblings().removeClass('active btn-primary');
        $(this).addClass('active btn-primary');
        $.cookie("cookieCatalogStyle", $(this).attr('id'), { expires: 3, path: '/' });
        location.reload();
    });
}

function changeCurrency(){
    $(".currency a").click(function(){

            $.cookie("currency", $(this).attr('id'), { expires: 3, path: '/' });
            location.reload();
    });
}
function sortable() {
    $('select[name=sortItem]').change(function () {
         location.href = $(this).val();
    });
}

function changeQuantityCatalog(){
    var quantity = localStorage.getItem('quantity');
    $("select[name=showItem] option[value="+quantity+"]").prop("selected", true);

    $('select[name=showItem]').change(function(){
        localStorage.setItem('quantity', $(this).val());
        $.cookie("cookieQuantity", $(this).val(), { expires: 3, path: '/' });
        location.reload();
    });
}
$(document).ready(function () {
    changeCatalogStyle();
    changeCurrency();
    topNavToSelect();
    NavToSelect();
    showtooltip();
    cartContent();
    flexSlideShow();
    productSlider();
    productFancyBox();
    dropdownMainNav();
    latestTweets();
    openSidePanel();
    rangePriceSlider();
    sortable();
    changeQuantityCatalog();
});