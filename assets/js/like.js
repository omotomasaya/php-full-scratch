$(function(){
    $(document).on('click','.like-btn', function(){
        var tweetID  = $(this).data('tweet');
        var tweet_id  = $(this).data('user');
        $.ajax({
            url: "http://localhost:8888/portfolio/core/ajax/like.php",
            method: "POST",
            data: {
                like:tweetID,
                tweetBy:tweet_id
            },
            success: function(data) {
                location.reload();
            }
        });
    }); 

    $(document).on('click','.unlike-btn', function(){
        var tweetID  = $(this).data('tweet');
        var tweet_id  = $(this).data('user');
        $.ajax({
            url: "http://localhost:8888/portfolio/core/ajax/like.php",
            method: "POST",
            data: {
                unlike:tweetID,
                tweetBy:tweet_id
            },
            success: function(data) {
                location.reload();
            }
        });
    });
});

