$(document).ready(function() {

  if($('.slider').length) {
    
    $('.slide').each(function() {
      var img = $('> img', this)
      $(this).backstretch(img.attr('src'))
      img.hide()
    })

    $('.slider').slick({
      autoplay: true,
      infinite: false,
      arrows: false,
      speed: 600,
      cssEase: 'cubic-bezier(0.86, 0, 0.07, 1)',
      slidesToShow: 1,
      slidesToScroll: 1,
      onInit: function(slider) {
      $('.slider a.prev').hide()
      },
      onAfterChange: function(slider,index) {
        if(index === 0) {
          $('.slider a.prev').fadeOut(100)
          $('.slider a.next').fadeIn(100)
        } else if(index === slider.slideCount-1) {
          $('.slider a.next').fadeOut(100)
          $('.slider a.prev').fadeIn(100)
        } else {
          $('.slider a.prev, .slider a.next').fadeIn(100)
        }
      },
    })

    //manual buttons
    $('.slider .next').on('click', function() {
    $(this).parent().slickNext()
    })
    $('.slider .prev').on('click', function() {
    $(this).parent().slickPrev()
    })
  }

})