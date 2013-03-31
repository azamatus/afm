$(document).ready(function() {
    $('.video__load-info').on('click', function() {
        var videoId = false;
        /*
         $.getJSON('http://gdata.youtube.com/feeds/api/videos/'+video_id+'?v=2&alt=jsonc',function(data,status,xhr){
         alert(data.data.title);
         // data contains the JSON-Object below
         });
         */
        var url = $('#FormVideoEditSrc').val();
        console.log('url -> ' + url);
        var regExp = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        var match = url.match(regExp);
        console.log(match);
        if (match && match[1].length==11){
            videoId = match[1];
        }


        if (videoId !== false) {
            $.ajax({
                type: "GET",
                url: 'http://gdata.youtube.com/feeds/api/videos/'+videoId+'?v=2&alt=jsonc',
                cache: false,
                crossDomain: true,
                dataType:'jsonp',
                success: function(data){
                    $('#FormVideoEditSrc').val('https://www.youtube.com/watch?v=' + videoId);
                    $('#FormVideoEditTitle').val(data.data.title);
                    $('#FormVideoEditTitleEn').val(data.data.title);
                    $('#FormVideoEditPreview').val(data.data.thumbnail.hqDefault);
                    $('#FormVideoEditVideoId').val(data.data.id);
                    $('#FormVideoEditLength').val(data.data.duration);
                    // alert(data.data.title);
                    //showMyVideos(data);
                }
            });
        } else {
            alert('Неверная ссылка на видео');
        }
        return false;
    });
});
