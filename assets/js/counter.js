$(function(){

  $('.tweet-text').keyup(function(){
    var max = 140;
    var count = $(this).val().length;
    $('#count').text(max - count);
    if(count > max){
        $('#count').css('color', '#f00');
    }else if(count === max){
        $('#count').css('color', '#00f');
    }else{
        $('#count').css('color', '#000');
    }
  });
});