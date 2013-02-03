$(function(){
    $('.button_buy').click(function(){
        alert($(this).getAttribute("product"));
        $.ajax({
                url : "path.php",
                data: { id: product_id },
                success: function( data)
                {
                    if(data.error){
                        alert('ERROR');
                    }
                    else{
                        alert(data.title + 'was added!!!');
                    }
                }
            });
    });
});