$('.form-control').on('focus blur', function (e) {
    $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
}).trigger('blur');

$('#moveleft').click(function() {
  moveLeft();
});

$('#moveright').click(function() {
  moveRight();
});

function moveRight(){
  $('#textbox').animate({
    'marginLeft': "50%" //moves right
  });

  $('.top').animate({
    'marginLeft': "0" //moves right
  });
}

function moveLeft(){
  $('#textbox').animate({
    'marginLeft': "0" //moves left
  });

  $('.top').animate({
    'marginLeft': "100%" //moves right
  });
}