/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
    	$(".menu > li").click(function(e){
		switch(e.target.id){
			case "characteristic":
				//change status & style menu
				$("#characteristic").addClass("active");
				$("#review").removeClass("active");
				$("#pfeedbacks").removeClass("active");
                $("#video").removeClass("active");
				//display selected division, hide others
				$("div.characteristic").fadeIn();
				$("div.review").css("display", "none");
				$("div.pfeedbacks").css("display", "none");
                $("div.video").css("display", "none");
			break;
			case "review":
				//change status & style menu
				$("#characteristic").removeClass("active");
				$("#review").addClass("active");
				$("#pfeedbacks").removeClass("active");
                $("#video").removeClass("active");
				//display selected division, hide others
				$("div.review").fadeIn();
				$("div.characteristic").css("display", "none");
				$("div.pfeedbacks").css("display", "none");
                $("div.video").css("display", "none");
			break;
			case "pfeedbacks":
				//change status & style menu
				$("#characteristic").removeClass("active");
				$("#review").removeClass("active");
				$("#pfeedbacks").addClass("active");
                $("#video").removeClass("active");
				//display selected division, hide others
				$("div.pfeedbacks").fadeIn();
				$("div.characteristic").css("display", "none");
				$("div.review").css("display", "none");
                $("div.video").css("display", "none");
			break;
            case "video":
                //change status & style menu
                $("#characteristic").removeClass("active");
                $("#review").removeClass("active");
                $("#pfeedbacks").removeClass("active");
                $("#video").addClass("active");
                //display selected division, hide others
                $("div.pfeedbacks").css("display", "none");
                $("div.characteristic").css("display", "none");
                $("div.review").css("display", "none");
                $("div.video").fadeIn();
            break;
		}
		//alert(e.target.id);
		return false;
	});
});