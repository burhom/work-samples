jQuery.fn.shuffle = function () {
    var j;
    for (var i = 0; i < this.length; i++) {
        j = Math.floor(Math.random() * this.length);
        $(this[i]).before($(this[j]));
    }
    return this;
};

$('#logo a').on('mouseenter', movearound);
var timer;
function movearound() {

    $('.square').shuffle();
    timer = setTimeout(function() {
        movearound();
    }, 200);

}

$('#logo a').on('mouseleave', function() {
    clearTimeout(timer);
});

function resizeCanvas() {
  $('.hover-img').each(function(index, element) {
    var canvas = $(this)[0];
    var context = canvas.getContext('2d');

    canvas.width = $('.project').width();
    canvas.height = $('.img-wrapper').height();
    $(this).data('instapixel').redraw({ 'resize' : true });
  })
}

//ajax load
function loadPost(href, $link) {
  
  //bring in the project overlay
  $('body').addClass('fixed')

  //load news
  if($link.parents('#posts').length) {

    //open news
    if (typeof SVGLoader == 'function') { 
      var loader = new SVGLoader( document.getElementById('loader'), { speedIn : 700, easingIn : mina.easeinout } );
    }

    if($('html').hasClass('no-svg')) {
      $('#loader').addClass('show') //ie fallback
    } else {
      loader.show() //svg goodness
    }

    //loading indicator
    $('#loader h3').delay(700).fadeIn(300, function() {
      //load post
      $('#post').load(href + ' #post > *', function(response, status, xhr) {
        if ( status == 'error' ) {
          
        } else {
          $('#post').fadeIn(300, function() {
            $('body').addClass('article-active')
            loader.hide() //svg goodness
            $('#loader').removeClass('show pageload-loading')
            $('#loader h3').hide()
          })
        }
      })
    })
  
  //load project
  } else {

    //from archives
    if($link.parents('.archive').length) {
      var linkText = $link.find('h3').html()
      $link.find('h3').fadeTo(100, 0, function() {
        $link.find('h3').html('Loading...').fadeTo(100, 1)
      })
    
    //from projects
    } else {
      var linkText = $link.find('span').html()
      $link.find('span').fadeTo(100, 0, function() {
        $link.find('span').html('Loading...').fadeTo(100, 1)
      })
    }

    $('#project').load(href + ' #project > *', function(response, status, xhr) {
      if ( status == 'error' ) {
        if($link.parents('.archive').length) {
          $link.find('h3').fadeTo(100, 0, function() {
            $link.find('h3').html('Error').fadeTo(100, 1)
          })
        } else {
          $link.find('span').fadeTo(100, 0, function() {
            $link.find('span').html('Error').fadeTo(100, 1)
          })
        }
      } else {
        console.log(xhr.status)
        console.log(status)
        var headerHeight = $('#header').css('position') === 'fixed' ? $('#header').height()+'px' : 0
        $('#project').fadeIn(200).animate({
          top: headerHeight
        }, 700, 'easeInOutExpo', function() {
          if($link.parents('.archive').length) {
            $link.find('h3').html(linkText)
          } else {
            $link.find('span').html(linkText)
          }
          $('body').addClass('project-active')
        })
        $('.project-links a').each(function() {
          $(this).css('margin-top', ($(this).width()/2)+40).delay(700).animate({opacity: 1}, 300)
        })
      }
    })
  }
}

(function() {

  // Highlight current section while scrolling DOWN
  $('.section').waypoint(function(direction) {
      if (direction === 'down') {
        var $link = $('a[href="/' + this.id + '"]');
        $('ul.nav.navbar-nav li').removeClass('active');
        $link.parent().addClass('active');
      }
  }, { offset: '50%' });

  // Highlight current section while scrolling UP
  $('.section').waypoint(function(direction) {
      if (direction === 'up') {
        var $link = $('a[href="/' + this.id + '"]');
        $('ul.nav.navbar-nav li').removeClass('active');
        $link.parent().addClass('active');
      }
  }, {
      offset: function() {
          // This is the calculation that would give you
          // "bottom of element hits middle of window"
          return $.waypoints('viewportHeight') / 2 - $(this).outerHeight();
      }
  });

  // history.js
  $('ul.nav.navbar-nav li a, .project a, .archive a, .post > a').on('click', addressUpdate)
  $('#project').on('click', '.project-links a', addressUpdate)

  function addressUpdate(ev) {
    ev.preventDefault()
    var $that = $(this)
    var separator = ' | '
    var title = $(document).find('title').text()
    title = title.substring(title.indexOf(separator), title.length)
    
    //set title
    if($(this).parents('.project').length) { // project link
      title = $(this).closest('.project').find('h4').text() + title
    } else if($(this).parents('.archive').length) { // archive link
      title = $(this).find('span.name').text() + title
    } else if($(this).parents('.project-links').length) { // prev or next project
      title = $(this).find('span').text() + title
    } else if ($(this).parents('#posts').length) { // news post
      title = $(this).find('> h4').text() + title
    } else { // regular nav links
      title = $that.text() + title
    }

    //update url + title
    var href = $that.attr('href')
    History.pushState(null, title, href)
    
    //load post
    if($that.parents('.project, .archive, .project-links, #posts').length) {
      loadPost(href, $that)
    
    //scroll to section
    } else {
      
      //if news
      if($('body').hasClass('article-active')) {
        $('#post').fadeOut(400, function() {
          $('body').removeClass('fixed article-active')
          $('#post').empty().hide()
        })
        $('html, body').stop().animate({
          scrollTop: ($('#' + href.replace('/', '')).offset().top)
        }, 2000,'easeInOutExpo')
      
      //if project
      } else {
        $('#project').animate({
          top: '100%'
        }, 700, 'easeInOutExpo', function() {
          $('body').removeClass('fixed project-active')
          $('#project').empty().hide()
        })
        $('html, body').stop().animate({
          scrollTop: ($('#' + href.replace('/', '')).offset().top)
        }, 2000,'easeInOutExpo')
      }
    }
  }

})();

//on page load
$(window).load(function() {
  //scroll to section
  var path = document.location.pathname
  var project = path.split('/')[2]
  path = path.substring(path.lastIndexOf('/') + 1, path.length)
  if ($('#' + path).length && !project) {
    $('html, body').stop().animate({
      scrollTop: ($('#' + path).offset().top)
    }, 2000,'easeInOutExpo')
  } else if (typeof project !== 'undefined') {
    $('.project-links a').each(function() {
      $(this).css('margin-top', ($(this).width()/2)+40).delay(700).animate({opacity: 1}, 300)
    })
  }
})

$(window).on('resize', function() {
  resizeCanvas();
})

//setup sliders and accordions
$(document).ready(function() {

  //init slider
  $('.slider').slick({
    autoplay: true,
    infinite: true,
    arrows: false,
    dots: true,
    speed: 800,
    cssEase: 'cubic-bezier(0.86, 0, 0.07, 1)',
    slidesToShow: 1,
    slidesToScroll: 1,
    // responsive: [
    //   {
    //     breakpoint: 480,
    //     settings: {
    //       dots: true,
    //       arrows: false
    //     }
    //   }
    // ]
  })

  //manual buttons
  $('.next').on('click', function() {
    $(this).parent().slickNext()
  })
  $('.prev').on('click', function() {
    $(this).parent().slickPrev()
  })

  $('#posts').slick({
    centerMode: true,
    arrows: false,
    centerPadding: '200px',
    slidesToShow: 1,
    speed: 800,
    cssEase: 'cubic-bezier(0.86, 0, 0.07, 1)',
    responsive: [{
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
            }
        }, {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: false,
                slidesToShow: 1
            }
        }]
  })

  //manual buttons
  $('.next').on('click', function() {
    $(this).parent().slickNext()
  })
  $('.prev').on('click', function() {
    $(this).parent().slickPrev()
  })

  //close buttons
  $('#project').on('click', 'a.close', function(e) {
    e.preventDefault()
    $('#project').animate({
      top: '100%'
    }, 700, 'easeInOutExpo', function() {
      $('body').removeClass('fixed project-active')
      $('#project').empty().hide()
    })
  })

  $('#post').on('click', 'a.close', function(e) {
    e.preventDefault()
    $('#post').fadeOut(400, function() {
      $('body').removeClass('fixed article-active')
      $('#post').empty().hide()
    })
  })

  //button hovers
  $('.btn').hover(
    function() {
      $('.line-t, .line-b', this).stop().animate({
        width: '100%'
      }, 400, 'easeInOutQuint');
      $('.line-r, .line-l', this).stop().animate({
        height: '100%'
      }, 400, 'easeInOutQuint');
    },
    function() {
      $('.line-t, .line-b', this).stop().animate({
        width: '10px'
      }, 400, 'easeInOutQuint');
      $('.line-r, .line-l', this).stop().animate({
        height: '10px'
      }, 400, 'easeInOutQuint');
    }
  )

  //fancy labels
  $('label').inFieldLabels()

  //project hovers
  $('.project').on({
    mouseover: function(){
      $('.overlay', this).fadeIn(300);
    },
    mouseleave: function(){
      $('.overlay', this).fadeOut(300);
    }
  })

  //pixelate bitches!
  $('.project').each(function() {
    $('.hover-img', this).instapixel( { 'imgURL': $('.img-wrapper img', this).attr('src'), debug: false } )
  })
  resizeCanvas();

  //archives overlay
  $('#archives .btn').on('click', function(e) {
    e.preventDefault();
    $('body').addClass('fixed');
    $('#archives .overlay').removeClass('close').addClass('open');
  });

  $('#archives .btn-close').on('click', function(e) {
    e.preventDefault();
    $('body').removeClass('fixed');
    $('#archives .overlay').removeClass('open').addClass('close');
  });

});