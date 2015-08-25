$(window).on('load resize',function(e){
  var width = $('.featured-image').width();
  $('.featured-image,.featured-image img').height(width*0.67);
});
