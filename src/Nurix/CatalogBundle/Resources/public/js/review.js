/**
 * Created by root on 4/20/14.
 */
$(document).ready(function(){
   $('.btn-group .btn').on('click',function(){
       var value = $(this).data('title');
       $('#nurix_catalogbundle_review_rating').val(value[0]);
   })
});
