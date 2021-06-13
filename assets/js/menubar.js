$(function(){
        $(document).ready(function(){
  $('#contextmenu > div').next().hide();
  $('#contextmenu > div').click(function(){
    $(this).next().slideToggle('slow');
  });
});
    });