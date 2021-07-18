$(function(){
    $(document).on('click','.follow-button', function(){
        var follow_id  = $(this).data('follow');
        var profile  = $(this).data('profile');
        $.ajax({
            // ローカル用
            // url: "http://localhost:8888/phpfullscratch/core/ajax/follow.php",
            url: "https://phpfullscratch0701.herokuapp.com/core/ajax/follow.php",
            method: "POST",
            data: {

                follow:profile
            },
            success: function(data) {
                location.reload();
            }
        });
    }); 

    $(document).on('click','.unfollow-button', function(){
        var follow_id  = $(this).data('follow');
        var profile  = $(this).data('profile');
        $.ajax({
            // ローカル用
            // url: "http://localhost:8888/phpfullscratch/core/ajax/follow.php",
            url: "https://phpfullscratch0701.herokuapp.com/core/ajax/follow.php",
            method: "POST",
            data: {

                unfollow:profile
            },
            success: function(data) {
                location.reload();
            }
        });
    });
});

