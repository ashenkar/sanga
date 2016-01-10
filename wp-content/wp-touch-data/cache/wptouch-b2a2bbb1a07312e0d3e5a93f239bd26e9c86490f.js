//fgnass.github.com/spin.js#v1.2.7
!function(e,t,n){function o(e,n){var r=t.createElement(e||"div"),i;for(i in n)r[i]=n[i];return r}function u(e){for(var t=1,n=arguments.length;t<n;t++)e.appendChild(arguments[t]);return e}function f(e,t,n,r){var o=["opacity",t,~~(e*100),n,r].join("-"),u=.01+n/r*100,f=Math.max(1-(1-e)/t*(100-u),e),l=s.substring(0,s.indexOf("Animation")).toLowerCase(),c=l&&"-"+l+"-"||"";return i[o]||(a.insertRule("@"+c+"keyframes "+o+"{"+"0%{opacity:"+f+"}"+u+"%{opacity:"+e+"}"+(u+.01)+"%{opacity:1}"+(u+t)%100+"%{opacity:"+e+"}"+"100%{opacity:"+f+"}"+"}",a.cssRules.length),i[o]=1),o}function l(e,t){var i=e.style,s,o;if(i[t]!==n)return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(o=0;o<r.length;o++){s=r[o]+t;if(i[s]!==n)return s}}function c(e,t){for(var n in t)e.style[l(e,n)||n]=t[n];return e}function h(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var i in r)e[i]===n&&(e[i]=r[i])}return e}function p(e){var t={x:e.offsetLeft,y:e.offsetTop};while(e=e.offsetParent)t.x+=e.offsetLeft,t.y+=e.offsetTop;return t}var r=["webkit","Moz","ms","O"],i={},s,a=function(){var e=o("style",{type:"text/css"});return u(t.getElementsByTagName("head")[0],e),e.sheet||e.styleSheet}(),d={lines:12,length:7,width:5,radius:10,rotate:0,corners:1,color:"#000",speed:1,trail:100,opacity:.25,fps:20,zIndex:2e9,className:"spinner",top:"auto",left:"auto",position:"relative"},v=function m(e){if(!this.spin)return new m(e);this.opts=h(e||{},m.defaults,d)};v.defaults={},h(v.prototype,{spin:function(e){this.stop();var t=this,n=t.opts,r=t.el=c(o(0,{className:n.className}),{position:n.position,width:0,zIndex:n.zIndex}),i=n.radius+n.length+n.width,u,a;e&&(e.insertBefore(r,e.firstChild||null),a=p(e),u=p(r),c(r,{left:(n.left=="auto"?a.x-u.x+(e.offsetWidth>>1):parseInt(n.left,10)+i)+"px",top:(n.top=="auto"?a.y-u.y+(e.offsetHeight>>1):parseInt(n.top,10)+i)+"px"})),r.setAttribute("aria-role","progressbar"),t.lines(r,t.opts);if(!s){var f=0,l=n.fps,h=l/n.speed,d=(1-n.opacity)/(h*n.trail/100),v=h/n.lines;(function m(){f++;for(var e=n.lines;e;e--){var i=Math.max(1-(f+e*v)%h*d,n.opacity);t.opacity(r,n.lines-e,i,n)}t.timeout=t.el&&setTimeout(m,~~(1e3/l))})()}return t},stop:function(){var e=this.el;return e&&(clearTimeout(this.timeout),e.parentNode&&e.parentNode.removeChild(e),this.el=n),this},lines:function(e,t){function i(e,r){return c(o(),{position:"absolute",width:t.length+t.width+"px",height:t.width+"px",background:e,boxShadow:r,transformOrigin:"left",transform:"rotate("+~~(360/t.lines*n+t.rotate)+"deg) translate("+t.radius+"px"+",0)",borderRadius:(t.corners*t.width>>1)+"px"})}var n=0,r;for(;n<t.lines;n++)r=c(o(),{position:"absolute",top:1+~(t.width/2)+"px",transform:t.hwaccel?"translate3d(0,0,0)":"",opacity:t.opacity,animation:s&&f(t.opacity,t.trail,n,t.lines)+" "+1/t.speed+"s linear infinite"}),t.shadow&&u(r,c(i("#000","0 0 4px #000"),{top:"2px"})),u(e,u(r,i(t.color,"0 0 1px rgba(0,0,0,.1)")));return e},opacity:function(e,t,n){t<e.childNodes.length&&(e.childNodes[t].style.opacity=n)}}),function(){function e(e,t){return o("<"+e+' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">',t)}var t=c(o("group"),{behavior:"url(#default#VML)"});!l(t,"transform")&&t.adj?(a.addRule(".spin-vml","behavior:url(#default#VML)"),v.prototype.lines=function(t,n){function s(){return c(e("group",{coordsize:i+" "+i,coordorigin:-r+" "+ -r}),{width:i,height:i})}function l(t,i,o){u(a,u(c(s(),{rotation:360/n.lines*t+"deg",left:~~i}),u(c(e("roundrect",{arcsize:n.corners}),{width:r,height:n.width,left:n.radius,top:-n.width>>1,filter:o}),e("fill",{color:n.color,opacity:n.opacity}),e("stroke",{opacity:0}))))}var r=n.length+n.width,i=2*r,o=-(n.width+n.length)*2+"px",a=c(s(),{position:"absolute",top:o,left:o}),f;if(n.shadow)for(f=1;f<=n.lines;f++)l(f,-2,"progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");for(f=1;f<=n.lines;f++)l(f);return u(t,a)},v.prototype.opacity=function(e,t,n,r){var i=e.firstChild;r=r.shadow&&r.lines||0,i&&t+r<i.childNodes.length&&(i=i.childNodes[t+r],i=i&&i.firstChild,i=i&&i.firstChild,i&&(i.opacity=n))}):s=l(t,"animation")}(),typeof define=="function"&&define.amd?define(function(){return v}):e.Spinner=v}(window,document);
/*

You can now create a spinner using any of the variants below:

$("#el").spin(); // Produces default Spinner using the text color of #el.
$("#el").spin("small"); // Produces a 'small' Spinner using the text color of #el.
$("#el").spin("large", "white"); // Produces a 'large' Spinner in white (or any valid CSS color).
$("#el").spin({ ... }); // Produces a Spinner using your custom settings.

$("#el").spin(false); // Kills the spinner.

*/
(function($) {
	$.fn.spin = function(opts, color) {
		var presets = {
			"tiny": { lines: 8, length: 2, width: 2, radius: 3 },
			"small": { lines: 8, length: 4, width: 3, radius: 5 },
			"large": { lines: 10, length: 8, width: 4, radius: 8 }
		};
		if (Spinner) {
			return this.each(function() {
				var $this = $(this),
					data = $this.data();
				
				if (data.spinner) {
					data.spinner.stop();
					delete data.spinner;
				}
				if (opts !== false) {
					if (typeof opts === "string") {
						if (opts in presets) {
							opts = presets[opts];
						} else {
							opts = {};
						}
						if (color) {
							opts.color = color;
						}
					}
					data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
				}
			});
		} else {
			throw "Spinner class not available.";
		}
	};
})(jQuery);
/*
 * Swipe 2.0
 *
 * Brad Birdsall
 * Copyright 2013, MIT License
 *
*/

function Swipe(container, options) {

  "use strict";

  // utilities
  var noop = function() {}; // simple no operation function
  var offloadFn = function(fn) { setTimeout(fn || noop, 0) }; // offload a functions execution
  
  // check browser capabilities
  var browser = {
    addEventListener: !!window.addEventListener,
    touch: ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
    transitions: (function(temp) {
      var props = ['transitionProperty', 'WebkitTransition', 'MozTransition', 'OTransition', 'msTransition'];
      for ( var i in props ) if (temp.style[ props[i] ] !== undefined) return true;
      return false;
    })(document.createElement('swipe'))
  };

  // quit if no root element
  if (!container) return;
  var element = container.children[0];
  var slides, slidePos, width, length;
  options = options || {};
  var index = parseInt(options.startSlide, 10) || 0;
  var speed = options.speed || 300;
  options.continuous = options.continuous !== undefined ? options.continuous : true;

  function setup() {

    // cache slides
    slides = element.children;
    length = slides.length;

    // set continuous to false if only one slide
    if (slides.length < 2) options.continuous = false;

    //special case if two slides
    if (browser.transitions && options.continuous && slides.length < 3) {
      element.appendChild(slides[0].cloneNode(true));
      element.appendChild(element.children[1].cloneNode(true));
      slides = element.children;
    }

    // create an array to store current positions of each slide
    slidePos = new Array(slides.length);

    // determine width of each slide
    width = container.getBoundingClientRect().width || container.offsetWidth;

    element.style.width = (slides.length * width) + 'px';

    // stack elements
    var pos = slides.length;
    while(pos--) {

      var slide = slides[pos];

      slide.style.width = width + 'px';
      slide.setAttribute('data-index', pos);

      if (browser.transitions) {
        slide.style.left = (pos * -width) + 'px';
        move(pos, index > pos ? -width : (index < pos ? width : 0), 0);
      }

    }

    // reposition elements before and after index
    if (options.continuous && browser.transitions) {
      move(circle(index-1), -width, 0);
      move(circle(index+1), width, 0);
    }

    if (!browser.transitions) element.style.left = (index * -width) + 'px';

    container.style.visibility = 'visible';

  }

  function prev() {

    if (options.continuous) slide(index-1);
    else if (index) slide(index-1);

  }

  function next() {

    if (options.continuous) slide(index+1);
    else if (index < slides.length - 1) slide(index+1);

  }

  function circle(index) {

    // a simple positive modulo using slides.length
    return (slides.length + (index % slides.length)) % slides.length;

  }

  function slide(to, slideSpeed) {

    // do nothing if already on requested slide
    if (index == to) return;
    
    if (browser.transitions) {

      var direction = Math.abs(index-to) / (index-to); // 1: backward, -1: forward

      // get the actual position of the slide
      if (options.continuous) {
        var natural_direction = direction;
        direction = -slidePos[circle(to)] / width;

        // if going forward but to < index, use to = slides.length + to
        // if going backward but to > index, use to = -slides.length + to
        if (direction !== natural_direction) to =  -direction * slides.length + to;

      }

      var diff = Math.abs(index-to) - 1;

      // move all the slides between index and to in the right direction
      while (diff--) move( circle((to > index ? to : index) - diff - 1), width * direction, 0);
            
      to = circle(to);

      move(index, width * direction, slideSpeed || speed);
      move(to, 0, slideSpeed || speed);

      if (options.continuous) move(circle(to - direction), -(width * direction), 0); // we need to get the next in place
      
    } else {     
      
      to = circle(to);
      animate(index * -width, to * -width, slideSpeed || speed);
      //no fallback for a circular continuous if the browser does not accept transitions
    }

    index = to;
    offloadFn(options.callback && options.callback(index, slides[index]));
  }

  function move(index, dist, speed) {

    translate(index, dist, speed);
    slidePos[index] = dist;

  }

  function translate(index, dist, speed) {

    var slide = slides[index];
    var style = slide && slide.style;

    if (!style) return;

    style.webkitTransitionDuration = 
    style.MozTransitionDuration = 
    style.msTransitionDuration = 
    style.OTransitionDuration = 
    style.transitionDuration = speed + 'ms';

    style.webkitTransform = 'translate(' + dist + 'px,0)' + 'translateZ(0)';
    style.msTransform = 
    style.MozTransform = 
    style.OTransform = 'translateX(' + dist + 'px)';

  }

  function animate(from, to, speed) {

    // if not an animation, just reposition
    if (!speed) {

      element.style.left = to + 'px';
      return;

    }
    
    var start = +new Date;
    
    var timer = setInterval(function() {

      var timeElap = +new Date - start;
      
      if (timeElap > speed) {

        element.style.left = to + 'px';

        if (delay) begin();

        options.transitionEnd && options.transitionEnd.call(event, index, slides[index]);

        clearInterval(timer);
        return;

      }

      element.style.left = (( (to - from) * (Math.floor((timeElap / speed) * 100) / 100) ) + from) + 'px';

    }, 4);

  }

  // setup auto slideshow
  var delay = options.auto || 0;
  var interval;

  function begin() {

    interval = setTimeout(next, delay);

  }

  function stop() {

    delay = 0;
    clearTimeout(interval);

  }


  // setup initial vars
  var start = {};
  var delta = {};
  var isScrolling;      

  // setup event capturing
  var events = {

    handleEvent: function(event) {

      switch (event.type) {
        case 'touchstart': this.start(event); break;
        case 'touchmove': this.move(event); break;
        case 'touchend': offloadFn(this.end(event)); break;
        case 'webkitTransitionEnd':
        case 'msTransitionEnd':
        case 'oTransitionEnd':
        case 'otransitionend':
        case 'transitionend': offloadFn(this.transitionEnd(event)); break;
        case 'resize': offloadFn(setup.call()); break;
      }

      if (options.stopPropagation) event.stopPropagation();

    },
    start: function(event) {

      var touches = event.touches[0];

      // measure start values
      start = {

        // get initial touch coords
        x: touches.pageX,
        y: touches.pageY,

        // store time to determine touch duration
        time: +new Date

      };
      
      // used for testing first move event
      isScrolling = undefined;

      // reset delta and end measurements
      delta = {};

      // attach touchmove and touchend listeners
      element.addEventListener('touchmove', this, false);
      element.addEventListener('touchend', this, false);

    },
    move: function(event) {

      // ensure swiping with one touch and not pinching
      if ( event.touches.length > 1 || event.scale && event.scale !== 1) return

      if (options.disableScroll) event.preventDefault();

      var touches = event.touches[0];

      // measure change in x and y
      delta = {
        x: touches.pageX - start.x,
        y: touches.pageY - start.y
      }

      // determine if scrolling test has run - one time test
      if ( typeof isScrolling == 'undefined') {
        isScrolling = !!( isScrolling || Math.abs(delta.x) < Math.abs(delta.y) );
      }

      // if user is not trying to scroll vertically
      if (!isScrolling) {

        // prevent native scrolling 
        event.preventDefault();

        // stop slideshow
        stop();

        // increase resistance if first or last slide
        if (options.continuous) { // we don't add resistance at the end

          translate(circle(index-1), delta.x + slidePos[circle(index-1)], 0);
          translate(index, delta.x + slidePos[index], 0);
          translate(circle(index+1), delta.x + slidePos[circle(index+1)], 0);

        } else {

          delta.x = 
            delta.x / 
              ( (!index && delta.x > 0               // if first slide and sliding left
                || index == slides.length - 1        // or if last slide and sliding right
                && delta.x < 0                       // and if sliding at all
              ) ?                      
              ( Math.abs(delta.x) / width + 1 )      // determine resistance level
              : 1 );                                 // no resistance if false
          
          // translate 1:1
          translate(index-1, delta.x + slidePos[index-1], 0);
          translate(index, delta.x + slidePos[index], 0);
          translate(index+1, delta.x + slidePos[index+1], 0);
        }

      }

    },
    end: function(event) {

      // measure duration
      var duration = +new Date - start.time;

      // determine if slide attempt triggers next/prev slide
      var isValidSlide = 
            Number(duration) < 250               // if slide duration is less than 250ms
            && Math.abs(delta.x) > 20            // and if slide amt is greater than 20px
            || Math.abs(delta.x) > width/2;      // or if slide amt is greater than half the width

      // determine if slide attempt is past start and end
      var isPastBounds = 
            !index && delta.x > 0                            // if first slide and slide amt is greater than 0
            || index == slides.length - 1 && delta.x < 0;    // or if last slide and slide amt is less than 0

      if (options.continuous) isPastBounds = false;
      
      // determine direction of swipe (true:right, false:left)
      var direction = delta.x < 0;

      // if not scrolling vertically
      if (!isScrolling) {

        if (isValidSlide && !isPastBounds) {

          if (direction) {

            if (options.continuous) { // we need to get the next in this direction in place

              move(circle(index-1), -width, 0);
              move(circle(index+2), width, 0);

            } else {
              move(index-1, -width, 0);
            }

            move(index, slidePos[index]-width, speed);
            move(circle(index+1), slidePos[circle(index+1)]-width, speed);
            index = circle(index+1);  
                      
          } else {
            if (options.continuous) { // we need to get the next in this direction in place

              move(circle(index+1), width, 0);
              move(circle(index-2), -width, 0);

            } else {
              move(index+1, width, 0);
            }

            move(index, slidePos[index]+width, speed);
            move(circle(index-1), slidePos[circle(index-1)]+width, speed);
            index = circle(index-1);

          }

          options.callback && options.callback(index, slides[index]);

        } else {

          if (options.continuous) {

            move(circle(index-1), -width, speed);
            move(index, 0, speed);
            move(circle(index+1), width, speed);

          } else {

            move(index-1, -width, speed);
            move(index, 0, speed);
            move(index+1, width, speed);
          }

        }

      }

      // kill touchmove and touchend event listeners until touchstart called again
      element.removeEventListener('touchmove', events, false)
      element.removeEventListener('touchend', events, false)

    },
    transitionEnd: function(event) {

      if (parseInt(event.target.getAttribute('data-index'), 10) == index) {
        
        if (delay) begin();

        options.transitionEnd && options.transitionEnd.call(event, index, slides[index]);

      }

    }

  }

  // trigger setup
  setup();

  // start auto slideshow if applicable
  if (delay) begin();


  // add event listeners
  if (browser.addEventListener) {
    
    // set touchstart event on element    
    if (browser.touch) element.addEventListener('touchstart', events, false);

    if (browser.transitions) {
      element.addEventListener('webkitTransitionEnd', events, false);
      element.addEventListener('msTransitionEnd', events, false);
      element.addEventListener('oTransitionEnd', events, false);
      element.addEventListener('otransitionend', events, false);
      element.addEventListener('transitionend', events, false);
    }

    // set resize event on window
    window.addEventListener('resize', events, false);

  } else {

    window.onresize = function () { setup() }; // to play nice with old IE

  }

  // expose the Swipe API
  return {
    setup: function() {

      setup();

    },
    slide: function(to, speed) {
      
      // cancel slideshow
      stop();
      
      slide(to, speed);

    },
    prev: function() {

      // cancel slideshow
      stop();

      prev();

    },
    next: function() {

      // cancel slideshow
      stop();

      next();

    },
    getPos: function() {

      // return current index position
      return index;

    },
    getNumSlides: function() {
      
      // return total number of slides
      return length;
    },
    kill: function() {

      // cancel slideshow
      stop();

      // reset element
      element.style.width = 'auto';
      element.style.left = 0;

      // reset slides
      var pos = slides.length;
      while(pos--) {

        var slide = slides[pos];
        slide.style.width = '100%';
        slide.style.left = 0;

        if (browser.transitions) translate(pos, 0, 0);

      }

      // removed event listeners
      if (browser.addEventListener) {

        // remove current event listeners
        element.removeEventListener('touchstart', events, false);
        element.removeEventListener('webkitTransitionEnd', events, false);
        element.removeEventListener('msTransitionEnd', events, false);
        element.removeEventListener('oTransitionEnd', events, false);
        element.removeEventListener('otransitionend', events, false);
        element.removeEventListener('transitionend', events, false);
        window.removeEventListener('resize', events, false);

      }
      else {

        window.onresize = null;

      }

    }
  }

}


if ( window.jQuery || window.Zepto ) {
  (function($) {
    $.fn.Swipe = function(params) {
      return this.each(function() {
        $(this).data('Swipe', new Swipe($(this)[0], params));
      });
    }
  })( window.jQuery || window.Zepto )
}


function wptouchFdnSetupMenu( menuContainer ) {

	menuContainer = jQuery( menuContainer );

	menuContainer.find( 'li.menu-item ul' ).each( function() {
		if ( !jQuery( this ).children().length > 0 ) {
			jQuery( this ).remove();
		}
	});

	menuContainer.find( 'li.menu-item' ).has( 'ul' ).addClass( 'has_children' ).prepend( '<span></span>' );

	jQuery( 'ul li.has_children span', menuContainer ).on( 'click', function( e ) {
		jQuery( this ).toggleClass( 'toggle' ).parent().toggleClass( 'open-tree' );
		jQuery( this ).parent().find( 'ul' ).first().webkitSlideToggle();
		e.preventDefault();
		e.stopPropagation();
	});

	//If parent links are turned off
	var noParentLinks = jQuery( 'ul.no-parent-links' );
	if ( jQuery( noParentLinks ).length ) {

		menuContainer.each( function(){
			jQuery( noParentLinks, this ).off().on( 'click', 'li.has_children > a', function( e ){
				jQuery( this ).parent().find( 'span' ).trigger( 'click' );
				e.preventDefault();
				e.stopPropagation();
			});
		});
	}
}

// Setup show/hide menus
function wptouchFdnSetupAllMenus() {
	jQuery( '.show-hide-menu, .slide-menu' ).each( function() {
		var menuId = jQuery( this ).prop( 'id' );
		if ( menuId ) {
			wptouchFdnSetupMenu( '#' + menuId );
		}
	});
}

function wptouchDoFdnMenuReady() {
	wptouchFdnSetupAllMenus();
}

jQuery( document ).ready( function() { wptouchDoFdnMenuReady(); } );
function wptouchFoundationInfiniteScrollReady() {
	var loadMoreLink = 'a.infinite-link';	

	jQuery( window ).scroll( function() {
		var actualLink = jQuery( loadMoreLink );

		if ( actualLink.length ) {
			var currentPosition = jQuery( loadMoreLink ).offset();
			var pixelsVisible = window.innerHeight - currentPosition.top + jQuery( window ).scrollTop();
		
			if ( pixelsVisible > 100 & !jQuery( loadMoreLink ).hasClass( 'ajaxing' ) ) {
				jQuery( loadMoreLink ).addClass( 'ajaxing' ).text( wptouchFdn.ajaxLoading ).prepend( '<span class="spinner"></span>' );
				jQuery( '.spinner' ).spin( 'tiny' );
				var loadMoreURL = jQuery( loadMoreLink ).attr( 'rel' );

				jQuery( loadMoreLink ).after( "<span class='ajax-target'></span>" );
				jQuery( '.ajax-target' ).load( loadMoreURL + ' #content > div, #content .infinite-link', function() {
					jQuery( '.ajax-target' ).replaceWith( jQuery( this ).html() );	
					jQuery( '.ajaxing' ).animate( { height: 'toggle' }, 200, 'linear', function(){ jQuery( this ).remove(); } );
				});
			}			
		}
	});
}

jQuery( document ).ready( function() { wptouchFoundationInfiniteScrollReady(); });
/* WPtouch Foundation Web-App Mode Module JS */

function _wptouchWebAppSetupEachLink( oneLink ) {
	var targetURL = oneLink.attr( 'href' );
	var targetLink = oneLink;

	var localDomain = '//' + location.hostname;
	var rootDomain = location.hostname.split( '.' );
	var masterDomain = rootDomain[1] + '.' + rootDomain[2];

	// Check for URLs that should break out of Web-App mode
	if ( typeof wptouchWebApp.ignoredWebAppURLs != 'undefined' ) {
		jQuery.each( wptouchWebApp.ignoredWebAppURLs, function( i, val ) {
			if ( targetURL.match( val ) ) {
				targetLink.addClass( 'ignored' );
			}
		});
	}

	// Check for URLs that should break out of Web-App mode
	if ( typeof wptouchWebApp.ignoredURLs != 'undefined' ) {
		jQuery.each( wptouchWebApp.ignoredURLs, function( i, val ) {
			if ( targetURL.match( val ) ) {
				targetLink.addClass( 'ignored' );
			}
		});
	}

	// Look for files that should definitely open in another browser, and also images
	if ( targetURL.match( ( /[^\s]+(\.(pdf|numbers|pages|xls|xlsx|doc|docx|zip|tar|gz|csv|txt))$/i ) ) ) {
		targetLink.addClass( 'file' );
	} else if ( targetURL.match( ( /[^\s]+(\.(mp3|mp4|m4a|mov|m4v|wav|aiff|ogg))$/i ) ) ) {
		targetLink.addClass( 'media' );
	} else if ( targetURL.match( ( /[^\s]+(\.(jpg|jpeg|gif|png|bmp|tiff|svg))$/i ) ) ) {
		targetLink.addClass( 'img-link' );
	}

	// Click handler for all Web-App mode links without hash targets
	var thisTargetUrl = oneLink.attr( 'href' ).split('#')[0];
	var thisTargetAnchor = oneLink.attr( 'href' ).split('#')[1];

	if ( oneLink.hasClass( 'external' ) || oneLink.parent( 'li' ).hasClass( 'external' ) ) {
		return confirm( wptouchWebApp.externalLinkText );
	} else if ( oneLink.hasClass( 'file' ) ) {
		return confirm( wptouchWebApp.externalFileText );
	} else if ( oneLink.hasClass( 'media' ) ) {
		window.location = thisTargetUrl;
		return false;
	} else if ( oneLink.hasClass( 'img-link' ) ) {
		return false;
	} else if ( thisTargetUrl.match( localDomain ) || ( !thisTargetUrl.match( 'http://' )  && !thisTargetUrl.match( 'https://' ) ) ) {
		// This is a local HTTP address, or HTTP is missing from the URL
		// First, let's make sure it's not in the ignored list first
		if ( oneLink.hasClass( 'ignored' ) || oneLink.parent( 'li' ).hasClass( 'ignored' ) ) {
			// This is *not* a local link or one that has been ignored, so let's ask what to do
	       	return confirm( wptouchWebApp.externalLinkText );
		} else if ( thisTargetAnchor && thisTargetUrl.match( '//' ) ) {
			wptouchWebAppLoadPage( thisTargetUrl );
			return false;
		} else if ( thisTargetAnchor && thisTargetAnchor == 'respond' && !thisTargetUrl.match( '//' ) ) {
			wptouchWebAppLoadPage( targetLink.attr( 'href' ) );
			return false;
		} else if ( thisTargetAnchor && !thisTargetUrl.match( '//' ) ) {
			return true;
		} else if ( oneLink.attr( 'href' ) == '#' ) {
			// Allow local JS to execute
			return true;
		} else {
			// This is a local link that hasn't been ignored, so let's move to it
			wptouchWebAppLoadPage( thisTargetUrl );
			return false;
		}
	} else {
		return confirm( wptouchWebApp.externalLinkText );
	}
}

function _wptouchWebAppSetupLinkTrapping( webAppLinks ) {
	webAppLinks.each( function() {
		jQuery( this ).off( 'click.weblinks' ).on( 'click.weblinks', function() {
			var thisElement = jQuery( this );
			var result = _wptouchWebAppSetupEachLink( thisElement );
			return result;
		});
	});
}

function wptouchWebAppSetupLinkTrapping() {
	// Need to update this list
	var webAppLinks = jQuery( 'a' ).not( 'ul.no-parent-links li.has_children > a, .no-ajax, .back-button, .fwd-button, .back-to-top, .comment-reply-link, .slide-toggle, .show-hide-toggle, [href^=mailto], [href^=tel]' );
	_wptouchWebAppSetupLinkTrapping( webAppLinks );
}

function wptouchWebAppLoadPage( targetUrl ) {
	setTimeout( function() {
		wptouchWebAppSaveState( targetUrl );
		window.location = targetUrl;
	}, 250 );
}

// Main entry point for webapp mode
jQuery( document ).ready( function() {
	if ( navigator.standalone ) {
		wptouchWebAppOnly();
		wptouchWebAppSetupLinkTrapping();
		wptouchWebAppHandleShortcodes();
	}
}).ajaxComplete( function() {
	if ( navigator.standalone ) {
		wptouchWebAppSetupLinkTrapping();
		wptouchWebAppHandleShortcodes();

		// Erase the cookie
		wptouchCreateCookie( 'wptouch-webapp-' + wptouchWebApp.persistenceSalt, '', -1 );
	}
});

// Things to do only when in Web-App Mode
function wptouchWebAppOnly() {
	wptouchCreateCookie( 'wptouch-webapp-' + wptouchWebApp.persistenceSalt, 'on' );
	if ( wptouchWebApp.persistence == 0 ) {
		wptouchEraseCookie( 'wptouch-webapp-persist-' + wptouchWebApp.persistenceSalt );
	}
	jQuery( 'body' ).addClass( 'web-app-mode' );

	wptouchWebAppBackButton();

    if( window.location.hash ) { // just in case there is no hash
    	jQuery( document.body ).animate( {
            'scrollTop': jQuery( window.location.hash ).offset().top
        }, 500);
    }


	jQuery( '#switch' ).remove();
}

function wptouchWebAppBackButton(){
	if ( jQuery( '.back-button' ).length ) {
		var startPosition = 0;
		var backButton = jQuery( '.back-button' );

		jQuery( window ).scroll( function () {
			var newPosition = jQuery( this ).scrollTop();
			if ( newPosition > startPosition ) {
				backButton.removeClass( 'visible' );
			} else {
				if ( !backButton.hasClass( 'visible' ) ) {
					backButton.addClass( 'visible' );
				}
			}
			startPosition = newPosition;
		});

		// New back button history handling
		if ( history.length == '1' || document.referrer == '' ) {
			backButton.hide();
		}
	}
}

function wptouchWebAppSaveState( url ) {
	if ( wptouchWebApp.persistence == 1 && !url.match( 'action=logout' ) ) {
		wptouchCreateCookie( 'wptouch-webapp-persist-' + wptouchWebApp.persistenceSalt, url, 365 );
	}
}

function wptouchWebAppHandleShortcodes() {
	// For web application mode
	var webAppDivs = jQuery( '.wptouch-shortcode-webapp-only' );
	webAppDivs.show();
}
/* WPtouch Pro Foundation Base JS */
/* Description: This file holds all the default jQuery & Ajax functions for the Foundation parent theme on mobile & tablets, used by all child themes */

// Try to get out of frames!
function wptouchFdnEscFrames() {
	if ( window.top != window.self ) {
		window.top.location = self.location.href
	}
}

function wptouchFdnIfFixed() {
	if ( wptouchFdnHasFixedPos() ) {
		jQuery( 'body' ).addClass( 'has-fixed' );
	}
}

function wptouchFdnBindBackButtons( buttonElement ) {
	if ( typeof( buttonElement ) === 'undefined' ) buttonElement = '.back-button';
	jQuery( buttonElement ).on( 'click', function( e ) {
		history.back();
		e.preventDefault();
	});
}

function wptouchFdnBindFwdButtons( buttonElement ) {
	if ( typeof( buttonElement ) === 'undefined' ) buttonElement = '.fwd-button';
	jQuery( buttonElement ).on( 'click', function( e ) {
		history.forward();
		e.preventDefault();
	});
}

// Try to make smaller elements nicer in posts
function wptouchFdnCenterImages( elements, imgWidth ) {
	jQuery( elements ).each( function() {
		if ( !jQuery( this ).hasClass( 'aligncenter' ) && jQuery( this ).width() > imgWidth ) {
			jQuery( this ).not('.post-thumbnail').addClass( 'aligncenter' );
		}
	});
}

function wptouchFdnSetupSlideToggles() {
	jQuery( '.slide-toggle' ).each( function() {
		var targetId = jQuery( this ).attr( 'data-effect-target' );
		wptouchFdnSlideToggle( this, '#' + targetId, 500 );
	});
}

/* Detect screen sizes and other device details and add or remove corresponding 'smartphone' or 'tablet' classes
	Using document.body.clientWidth because it's faster (and it's what jQuery uses under the hood, anyways) */
function wptouchFdnUpdateDevice() {
	var bodyEl = jQuery( 'body' );
	// Update the body class if the device width is equal to or bigger than 768px
	if ( document.body.clientWidth < 768 && !bodyEl.hasClass( 'smartphone' ) ) {
		bodyEl.addClass( 'smartphone' ).removeClass( 'tablet' );
		// Create a cookie for the device class so we can reference it via PHP afterwards if needed
		wptouchCreateCookie( 'wptouch-device-type', 'smartphone', 365 );
	} else if ( document.body.clientWidth >= 768 && !bodyEl.hasClass( 'tablet' ) ) {
		bodyEl.addClass( 'tablet' ).removeClass( 'smartphone' );
		// Create a cookie for the device class so we can reference it via PHP afterwards if needed
		wptouchCreateCookie( 'wptouch-device-type', 'tablet', 365 );
	}
}

function wptouchFdnUpdateOrientation() {
	var bodyEl = jQuery( 'body' );
// Update scroll position slightly to fix fixed elements
//	var scrollPosition = bodyEl.scrollTop() + 1;
//	window.scrollTo( 0, scrollPosition, 100 );

	// If it's a smartphone & the clientWidth is less than 480, assume it's portrait, else landscape (works for iPhone 5, as well )
	if ( bodyEl.hasClass( 'smartphone' ) ) {
		if ( document.body.clientWidth < 480 ) {
			bodyEl.addClass( 'portrait' ).removeClass( 'landscape' );
			wptouchCreateCookie( 'wptouch-device-orientation', 'portrait', 365 );
	} else {
			bodyEl.addClass( 'landscape' ).removeClass( 'portrait' );
			wptouchCreateCookie( 'wptouch-device-orientation', 'landscape', 365 );
		}
	}

	// If it's a tablet & the clientWidth is less than 1024, assume it's portrait, else landscape
	if ( bodyEl.hasClass( 'tablet' ) ) {
		if ( document.body.clientWidth < 1024 ) {
			bodyEl.addClass( 'portrait' ).removeClass( 'landscape' );
			wptouchCreateCookie( 'wptouch-device-orientation', 'portrait', 365 );
		} else {
			bodyEl.addClass( 'landscape' ).removeClass( 'portrait' );
			wptouchCreateCookie( 'wptouch-device-orientation', 'landscape', 365 );
		}
	}
}

function wptouchFdnDoDeviceAndOrientationListener() {
	jQuery( window ).resize( function() {
		wptouchFdnUpdateDevice();
		wptouchFdnUpdateOrientation();
	}).resize();
}

// Back to top links in themes
function wptouchFdnSetupBackToTopLinks() {
	jQuery( 'body' ).on( 'click', '.back-to-top', function( e ){
	    jQuery( 'body' ).animate( { scrollTop: jQuery( 'html' ).offset().top }, 550 );
		e.preventDefault();
	});
}

function wptouchFdnSetupShowHideToggles() {
	jQuery( '.show-hide-toggle' ).each( function() {
		var targetId = jQuery( this ).attr( 'data-effect-target' );
		var closeId = jQuery( this ).attr( 'data-effect-close' );
		var linkId = jQuery( this ).prop( 'id' );

		jQuery( this ).on( 'click', function( e ) {
			if ( typeof( closeId ) !== 'undefined' ) {
				var originalId = jQuery( '#' + closeId ).attr( 'data-source-click' );
				if ( typeof( originalId ) !== 'undefined' ) {
					jQuery( '#' + originalId ).removeClass( 'toggle-open' );
					jQuery( '#' + closeId ).data( 'data-source-click', '' );
				}

				jQuery( '#' + closeId ).hide();
			}

			jQuery( this ).toggleClass( 'toggle-open' );
			jQuery( '#' + targetId ).attr( 'data-source-click', linkId ).webkitSlideToggle();

			e.preventDefault();
		});
	});
}

function wptouchFdnCheckHideAddressBar() {
	if ( jQuery( 'body' ).hasClass( 'hide-address-bar' ) ) {
		window.scrollTo( 0,1 );
	}
}

function wptouchFdnPreviewReload() {
	jQuery( '#preview-bar' ).find( '.refresher' ).on( 'click', function() {
		setTimeout( window.location.reload.bind( window.location ), 0 );
	});
}

function wptouchFdnSwitchToggle() {
	jQuery( '#switch' ).on( 'click', '.off', function() {
		jQuery( '.on' ).removeClass( 'active' );
		jQuery( this ).addClass( 'active' );
	});
}

function wptouchFdnHandleShortcode() {
	if ( !navigator.standalone ) {
		jQuery( '.wptouch-shortcode-mobile-only' ).show();
	}
}

function wptouchFdnSetupjQuery() {

	// jQuery function opacityToggle()
	jQuery.fn.opacityToggle = function( speed, easing, callback ) {
		return this.animate( { opacity: 'toggle' }, speed, easing, callback );
   	}

  	// jQuery function webkitSlideToggle()
	jQuery.fn.webkitSlideToggle = function() {
		this.toggle();
  	}

	// jQuery function viewportCenter()
	jQuery.fn.viewportCenter = function() {
	    this.css( 'position', 'absolute' );
	    this.css( 'top', ( ( jQuery( window ).height() - this.outerHeight() ) / 3 ) + jQuery( window ).scrollTop() + 'px' );
	    this.css( 'left', ( ( jQuery( window ).width() - this.outerWidth() ) / 2 ) + jQuery( window ).scrollLeft() + 'px' );
	    return this;
	}

	// Set the form element tabindex automagically
	jQuery( function() {
		var tabindex = 1;
		jQuery( 'input, select, textarea' ).each( function() {
			if ( this.type != "hidden" ) {
				var inputToTab = jQuery( this );
				inputToTab.attr( 'tabindex', tabindex );
				tabindex++;
			}
		});
	});
}

function wptouchFdnSetupWPML() {
	var wpmlLanguageSwitch = jQuery( '#wpml-language-chooser select' );
	if ( wpmlLanguageSwitch.length ) {
		wpmlLanguageSwitch.change( function() {
			var switchLink = wpmlLanguageSwitch.val();
			document.location.href = switchLink;
		});
	}
}

function wptouchFdnBaseReady() {
	wptouchFdnEscFrames();
	wptouchFdnIfFixed();
	wptouchFdnBindBackButtons();
	wptouchFdnBindFwdButtons();
	wptouchFdnCenterImages( '.post img, .wp-caption', 105 );
	wptouchFdnSetupSlideToggles();
	wptouchFdnDoDeviceAndOrientationListener();
	wptouchFdnSetupBackToTopLinks();
	wptouchFdnSetupShowHideToggles();
	wptouchFdnCheckHideAddressBar();
	wptouchFdnPreviewReload();
	wptouchFdnSwitchToggle();
	wptouchFdnHandleShortcode();
	wptouchFdnSetupjQuery();
	wptouchFdnSetupWPML();
}

jQuery( document ).ready( function() { wptouchFdnBaseReady(); } );
/* WPtouch Pro Public Foundation JavaScript Functions */
/* Description: These functions can be used in themes as needed */

function wptouchFdnIsiOS6() {
	return ( '-webkit-filter' in document.body.style );
}

function wptouchFdnHasFixedPos() {
	if ( jQuery( 'body' ).hasClass( 'preview-mode' ) ) {
		return true;
	} else {
		return '-webkit-overflow-scrolling' in document.body.style;
	}
}

// Function for fade-toggling hidden elements
function wptouchFdnShowHideToggle( linkTrigger, hiddenElement ) {
	jQuery( linkTrigger ).on( 'click', function( e ) {
		jQuery( linkTrigger ).toggleClass( 'toggle-open' );
		jQuery( hiddenElement ).opacityToggle( 380 );
		e.preventDefault();
	});
}

// Function for slide-toggling hidden elements
function wptouchFdnSlideToggle( linkTrigger, hiddenElement, speed ) {
	jQuery( linkTrigger ).on( 'click', function( e ) {
		jQuery( linkTrigger ).toggleClass( 'toggle-open' );
		jQuery( hiddenElement ).slideToggle( speed );

		e.preventDefault();
	});
}

// Create a cookie
function wptouchCreateCookie( name, value, days ) {
	if ( days ) {
		var date = new Date();
		date.setTime( date.getTime() + ( days*24*60*60*1000 ) );
		var expires = '; expires='+date.toGMTString();
	}
	else var expires = '';
	document.cookie = name+'='+value+expires+'; path='+wptouchMain.siteurl;
}

// Read a cookie
function wptouchReadCookie( name ) {
	var nameEQ = name + "=";
	var ca = document.cookie.split( ';' );
	for( var i=0; i < ca.length; i++ ) {
		var c = ca[i];
		while ( c.charAt( 0 )==' ' ) c = c.substring( 1, c.length );
		if ( c.indexOf( nameEQ ) == 0 ) return c.substring( nameEQ.length, c.length );
	}
	return null;
}

// Erase a cookie
function wptouchEraseCookie( name ) {
	wptouchCreateCookie( name, '', -1 );
}

// List all cookies (useful in alerts for testing)
function wptouchListCookies() {
    var theCookies = document.cookie.split(';');
    var aString = '';
    for (var i = 1 ; i <= theCookies.length; i++) {
        aString += i + ' ' + theCookies[i-1] + "\n";
    }
    return aString;
}
/* Add to Homescreen v3.0.8 ~ (c) 2014 Matteo Spinelli ~ @license: http://cubiq.org/license */
(function (window, document) {
/*
       _   _ _____     _____
 ___ _| |_| |_   _|___|  |  |___ _____ ___ ___ ___ ___ ___ ___ ___
| .'| . | . | | | | . |     | . |     | -_|_ -|  _|  _| -_| -_|   |
|__,|___|___| |_| |___|__|__|___|_|_|_|___|___|___|_| |___|___|_|_|
                              by Matteo Spinelli ~ http://cubiq.org
*/

// Check if document is loaded, needed by autostart
var _DOMReady = false;
if ( document.readyState === 'complete' ) {
	_DOMReady = true;
} else {
	window.addEventListener('load', loaded, false);
}

function loaded () {
	window.removeEventListener('load', loaded, false);
	_DOMReady = true;
}

// regex used to detect if app has been added to the homescreen
var _reSmartURL = /\/ath(\/)?$/;
var _reQueryString = /([\?&]ath=[^&]*$|&ath=[^&]*(&))/;

// singleton
var _instance;
function ath (options) {
	_instance = _instance || new ath.Class(options);

	return _instance;
}

// message in all supported languages
ath.intl = {
	de_de: {
		message: 'Um diese Web-App zum Home-Bildschirm hinzuzufügen, tippen Sie auf %icon und dann <strong>%action</strong>.',
		action: { ios: 'Zum Home-Bildschirm', android: 'Zum Startbildschirm hinzufügen', windows: 'Auf Startseite' }
	},

	en_us: {
		message: 'To add this web app to the home screen: tap %icon and then <strong>%action</strong>.',
		action: { ios: 'Add to Home Screen', android: 'Add to homescreen', windows: 'pin to start' }
	},

	es_es: {
		message: 'Para añadir esta aplicación web a la pantalla de inicio: pulsa %icon y selecciona <strong>%action</strong>.',
		action: { ios: 'Añadir a pantalla de inicio', android: 'Añadir a pantalla de inicio', windows: 'Añadir a inicio' }
	},

	fr_fr: {
		message: 'Pour ajouter cette application web sur l\'écran d\'accueil : Appuyez %icon et sélectionnez <strong>%action</strong>.',
		action: { ios: 'Ajouter sur l\'écran d\'accueil', android: 'Ajouter à l\'écran d\'accueil', windows: 'Épingler à l\'écran d\'accueil' }
	},

	it_it: {
		message: 'Per Aggiungere questa web app alla schermata iniziale: premi %icon e poi <strong>%action</strong>.',
		action: { ios: 'Aggiungi a Home', android: 'Aggiungi alla homescreen', windows: 'aggiungi a start' }
	},

	nb_no: {
		message: 'For å installere denne appen på hjem-skjermen: trykk på %icon og deretter <strong>%action</strong>.',
		action: { ios: 'Legg til på Hjem-skjerm', android: 'Legg til på startsiden', windows: 'fest til start' }
	},

	nl_nl: {
		message: 'Om deze webapp op je telefoon te installeren, klik op %icon en dan <strong>%action</strong>.',
		action: { ios: 'Zet in beginscherm', android: 'Toevoegen aan startscherm', windows: 'Aan startscherm vastmaken' }
	},

	sv_se: {
		message: 'För att lägga till denna webbapplikation på hemskärmen: tryck på %icon och därefter <strong>%action</strong>.',
		action: { ios: 'Lägg till på hemskärmen', android: 'Lägg til på startskärmen', windows: 'fäst på startskärmen' }
	},

	zh_cn: {
		message: '如要把应用程式加至主屏幕,请点击%icon, 然后<strong>%action</strong>',
		action: { ios: '加至主屏幕', android: '加至主屏幕', windows: '按住启动' }
	},

	zh_tw: {
		message: '如要把應用程式加至主屏幕, 請點擊%icon, 然後<strong>%action</strong>.',
		action: { ios: '加至主屏幕', android: '加至主屏幕', windows: '按住啟動' }
	}
};

// Add 2 characters language support (Android mostly)
for ( var lang in ath.intl ) {
	ath.intl[lang.substr(0, 2)] = ath.intl[lang];
}

// default options
ath.defaults = {
	appID: 'org.cubiq.addtohome',		// local storage name (no need to change)
	fontSize: 15,				// base font size, used to properly resize the popup based on viewport scale factor
	debug: false,				// override browser checks
	modal: false,				// prevent further actions until the message is closed
	mandatory: false,			// you can't proceed if you don't add the app to the homescreen
	autostart: true,			// show the message automatically
	skipFirstVisit: false,		// show only to returning visitors (ie: skip the first time you visit)
	startDelay: 1,				// display the message after that many seconds from page load
	lifespan: 15,				// life of the message in seconds
	displayPace: 1440,			// minutes before the message is shown again (0: display every time, default 24 hours)
	maxDisplayCount: 0,			// absolute maximum number of times the message will be shown to the user (0: no limit)
	icon: true,					// add touch icon to the message
	message: '',				// the message can be customized
	validLocation: [],			// list of pages where the message will be shown (array of regexes)
	onInit: null,				// executed on instance creation
	onShow: null,				// executed when the message is shown
	onRemove: null,				// executed when the message is removed
	onAdd: null,				// when the application is launched the first time from the homescreen (guesstimate)
	onPrivate: null,			// executed if user is in private mode
	detectHomescreen: false		// try to detect if the site has been added to the homescreen (false | true | 'hash' | 'queryString' | 'smartURL')
};

// browser info and capability
var _ua = window.navigator.userAgent;

var _nav = window.navigator;
_extend(ath, {
	hasToken: document.location.hash == '#ath' || _reSmartURL.test(document.location.href) || _reQueryString.test(document.location.search),
	isRetina: window.devicePixelRatio && window.devicePixelRatio > 1,
	isIDevice: (/iphone|ipod|ipad/i).test(_ua),
	isMobileChrome: _ua.indexOf('Android') > -1 && (/Chrome\/[.0-9]*/).test(_ua),
	isMobileIE: _ua.indexOf('Windows Phone') > -1,
	language: _nav.language && _nav.language.toLowerCase().replace('-', '_') || ''
});

// falls back to en_us if language is unsupported
ath.language = ath.language && ath.language in ath.intl ? ath.language : 'en_us';

ath.isMobileSafari = ath.isIDevice && _ua.indexOf('Safari') > -1 && _ua.indexOf('CriOS') < 0;
ath.OS = ath.isIDevice ? 'ios' : ath.isMobileChrome ? 'android' : ath.isMobileIE ? 'windows' : 'unsupported';

ath.OSVersion = _ua.match(/(OS|Android) (\d+[_\.]\d+)/);
ath.OSVersion = ath.OSVersion && ath.OSVersion[2] ? +ath.OSVersion[2].replace('_', '.') : 0;

ath.isStandalone = window.navigator.standalone || ( ath.isMobileChrome && ( screen.height - document.documentElement.clientHeight < 40 ) );	// TODO: check the lame polyfill
ath.isTablet = (ath.isMobileSafari && _ua.indexOf('iPad') > -1) || (ath.isMobileChrome && _ua.indexOf('Mobile') < 0);

ath.isCompatible = (ath.isMobileSafari && ath.OSVersion >= 6) || ath.isMobileChrome;	// TODO: add winphone

var _defaultSession = {
	lastDisplayTime: 0,			// last time we displayed the message
	returningVisitor: false,	// is this the first time you visit
	displayCount: 0,			// number of times the message has been shown
	optedout: false,			// has the user opted out
	added: false				// has been actually added to the homescreen
};

ath.removeSession = function (appID) {
	try {
		localStorage.removeItem(appID || ath.defaults.appID);
	} catch (e) {
		// we are most likely in private mode
	}
};

ath.Class = function (options) {
	// merge default options with user config
	this.options = _extend({}, ath.defaults);
	_extend(this.options, options);

	// normalize some options
	this.options.mandatory = this.options.mandatory && ( 'standalone' in window.navigator || this.options.debug );
	this.options.modal = this.options.modal || this.options.mandatory;
	if ( this.options.mandatory ) {
		this.options.startDelay = -0.5;		// make the popup hasty
	}
	this.options.detectHomescreen = this.options.detectHomescreen === true ? 'hash' : this.options.detectHomescreen;

	// setup the debug environment
	if ( this.options.debug ) {
		ath.isCompatible = true;
		ath.OS = typeof this.options.debug == 'string' ? this.options.debug : ath.OS == 'unsupported' ? 'android' : ath.OS;
		ath.OSVersion = ath.OS == 'ios' ? '8' : '4';
	}

	// the element the message will be appended to
	this.container = document.documentElement;

	// load session
	this.session = localStorage.getItem(this.options.appID);
	this.session = this.session ? JSON.parse(this.session) : undefined;

	// user most likely came from a direct link containing our token, we don't need it and we remove it
	if ( ath.hasToken && ( !ath.isCompatible || !this.session ) ) {
		ath.hasToken = false;
		_removeToken();
	}

	// the device is not supported
	if ( !ath.isCompatible ) {
		return;
	}

	this.session = this.session || _defaultSession;

	// check if we can use the local storage
	try {
		localStorage.setItem(this.options.appID, JSON.stringify(this.session));
		ath.hasLocalStorage = true;
	} catch (e) {
		// we are most likely in private mode
		ath.hasLocalStorage = false;

		if ( this.options.onPrivate ) {
			this.options.onPrivate.call(this);
		}
	}

	// check if this is a valid location
	var isValidLocation = !this.options.validLocation.length;
	for ( var i = this.options.validLocation.length; i--; ) {
		if ( this.options.validLocation[i].test(document.location.href) ) {
			isValidLocation = true;
			break;
		}
	}

	// check compatibility with old versions of add to homescreen. Opt-out if an old session is found
	if ( localStorage.getItem('addToHome') ) {
		this.optOut();
	}

	// critical errors:
	// user opted out, already added to the homescreen, not a valid location
	if ( this.session.optedout || this.session.added || !isValidLocation ) {
		return;
	}

	// check if the app is in stand alone mode
	if ( ath.isStandalone ) {
		// execute the onAdd event if we haven't already
		if ( !this.session.added ) {
			this.session.added = true;
			this.updateSession();

			if ( this.options.onAdd && ath.hasLocalStorage ) {	// double check on localstorage to avoid multiple calls to the custom event
				this.options.onAdd.call(this);
			}
		}

		return;
	}

	// (try to) check if the page has been added to the homescreen
	if ( this.options.detectHomescreen ) {
		// the URL has the token, we are likely coming from the homescreen
		if ( ath.hasToken ) {
			_removeToken();		// we don't actually need the token anymore, we remove it to prevent redistribution

			// this is called the first time the user opens the app from the homescreen
			if ( !this.session.added ) {
				this.session.added = true;
				this.updateSession();

				if ( this.options.onAdd && ath.hasLocalStorage ) {	// double check on localstorage to avoid multiple calls to the custom event
					this.options.onAdd.call(this);
				}
			}

			return;
		}

		// URL doesn't have the token, so add it
		if ( this.options.detectHomescreen == 'hash' ) {
			history.replaceState('', window.document.title, document.location.href + '#ath');
		} else if ( this.options.detectHomescreen == 'smartURL' ) {
			history.replaceState('', window.document.title, document.location.href.replace(/(\/)?$/, '/ath$1'));
		} else {
			history.replaceState('', window.document.title, document.location.href + (document.location.search ? '&' : '?' ) + 'ath=');
		}
	}

	// check if this is a returning visitor
	if ( !this.session.returningVisitor ) {
		this.session.returningVisitor = true;
		this.updateSession();

		// we do not show the message if this is your first visit
		if ( this.options.skipFirstVisit ) {
			return;
		}
	}

	// we do no show the message in private mode
	if ( !ath.hasLocalStorage ) {
		return;
	}

	// all checks passed, ready to display
	this.ready = true;

	if ( this.options.onInit ) {
		this.options.onInit.call(this);
	}

	if ( this.options.autostart ) {
		this.show();
	}
};

ath.Class.prototype = {
	// event type to method conversion
	events: {
		load: '_delayedShow',
		error: '_delayedShow',
		orientationchange: 'resize',
		resize: 'resize',
		scroll: 'resize',
		click: 'remove',
		touchmove: '_preventDefault',
		transitionend: '_removeElements',
		webkitTransitionEnd: '_removeElements',
		MSTransitionEnd: '_removeElements'
	},

	handleEvent: function (e) {
		var type = this.events[e.type];
		if ( type ) {
			this[type](e);
		}
	},

	show: function (force) {
		// in autostart mode wait for the document to be ready
		if ( this.options.autostart && !_DOMReady ) {
			setTimeout(this.show.bind(this), 50);
			return;
		}

		// message already on screen
		if ( this.shown ) {
			return;
		}

		var now = Date.now();
		var lastDisplayTime = this.session.lastDisplayTime;

		if ( force !== true ) {
			// this is needed if autostart is disabled and you programmatically call the show() method
			if ( !this.ready ) {
				return;
			}

			// we obey the display pace (prevent the message to popup too often)
			if ( now - lastDisplayTime < this.options.displayPace * 60000 ) {
				return;
			}

			// obey the maximum number of display count
			if ( this.options.maxDisplayCount && this.session.displayCount >= this.options.maxDisplayCount ) {
				return;
			}
		}

		this.shown = true;

		// increment the display count
		this.session.lastDisplayTime = now;
		this.session.displayCount++;
		this.updateSession();

		// try to get the highest resolution application icon
		if ( !this.applicationIcon ) {
			if ( ath.OS == 'ios' ) {
				this.applicationIcon = document.querySelector('head link[rel^=apple-touch-icon][sizes="152x152"],head link[rel^=apple-touch-icon][sizes="144x144"],head link[rel^=apple-touch-icon][sizes="120x120"],head link[rel^=apple-touch-icon][sizes="114x114"],head link[rel^=apple-touch-icon]');
			} else {
				this.applicationIcon = document.querySelector('head link[rel^="shortcut icon"][sizes="196x196"],head link[rel^=apple-touch-icon]');
			}
		}

		var message = '';

		if ( this.options.message in ath.intl ) {		// you can force the locale
			message = ath.intl[this.options.message].message.replace('%action', ath.intl[this.options.message].action[ath.OS]);
		} else if ( this.options.message !== '' ) {		// or use a custom message
			message = this.options.message;
		} else {										// otherwise we use our message
			message = ath.intl[ath.language].message.replace('%action', ath.intl[ath.language].action[ath.OS]);
		}

		// add the action icon
		message = '<p>' + message.replace('%icon', '<span class="ath-action-icon">icon</span>') + '</p>';

		// create the message container
		this.viewport = document.createElement('div');
		this.viewport.className = 'ath-viewport';
		if ( this.options.modal ) {
			this.viewport.className += ' ath-modal';
		}
		if ( this.options.mandatory ) {
			this.viewport.className += ' ath-mandatory';
		}
		this.viewport.style.position = 'absolute';

		// create the actual message element
		this.element = document.createElement('div');
		this.element.className = 'ath-container ath-' + ath.OS + ' ath-' + ath.OS + (ath.OSVersion + '').substr(0,1) + ' ath-' + (ath.isTablet ? 'tablet' : 'phone');
		this.element.style.cssText = '-webkit-transition-property:-webkit-transform,opacity;-webkit-transition-duration:0;-webkit-transform:translate3d(0,0,0);transition-property:transform,opacity;transition-duration:0;transform:translate3d(0,0,0);-webkit-transition-timing-function:ease-out';
		this.element.style.webkitTransform = 'translate3d(0,-' + window.innerHeight + 'px,0)';
		this.element.style.webkitTransitionDuration = '0s';

		// add the application icon
		if ( this.options.icon && this.applicationIcon ) {
			this.element.className += ' ath-icon';
			this.img = document.createElement('img');
			this.img.className = 'ath-application-icon';
			this.img.addEventListener('load', this, false);
			this.img.addEventListener('error', this, false);

			this.img.src = this.applicationIcon.href;
			this.element.appendChild(this.img);
		}

		this.element.innerHTML += message;

		// we are not ready to show, place the message out of sight
		this.viewport.style.left = '-99999em';

		// attach all elements to the DOM
		this.viewport.appendChild(this.element);
		this.container.appendChild(this.viewport);

		// if we don't have to wait for an image to load, show the message right away
		if ( !this.img ) {
			this._delayedShow();
		}
	},

	_delayedShow: function (e) {
		setTimeout(this._show.bind(this), this.options.startDelay * 1000 + 500);
	},

	_show: function () {
		var that = this;

		// update the viewport size and orientation
		this.updateViewport();

		// reposition/resize the message on orientation change
		window.addEventListener('resize', this, false);
		window.addEventListener('scroll', this, false);
		window.addEventListener('orientationchange', this, false);

		if ( this.options.modal ) {
			// lock any other interaction
			document.addEventListener('touchmove', this, true);
		}

		// Enable closing after 1 second
		if ( !this.options.mandatory ) {
			setTimeout(function () {
				that.element.addEventListener('click', that, true);
			}, 1000);
		}

		// kick the animation
		setTimeout(function () {
			that.element.style.webkitTransform = 'translate3d(0,0,0)';
			that.element.style.webkitTransitionDuration = '1.2s';
		}, 0);

		// set the destroy timer
		if ( this.options.lifespan ) {
			this.removeTimer = setTimeout(this.remove.bind(this), this.options.lifespan * 1000);
		}

		// fire the custom onShow event
		if ( this.options.onShow ) {
			this.options.onShow.call(this);
		}
	},

	remove: function () {
		clearTimeout(this.removeTimer);

		// clear up the event listeners
		if ( this.img ) {
			this.img.removeEventListener('load', this, false);
			this.img.removeEventListener('error', this, false);
		}

		window.removeEventListener('resize', this, false);
		window.removeEventListener('scroll', this, false);
		window.removeEventListener('orientationchange', this, false);
		document.removeEventListener('touchmove', this, true);
		this.element.removeEventListener('click', this, true);

		// remove the message element on transition end
		this.element.addEventListener('transitionend', this, false);
		this.element.addEventListener('webkitTransitionEnd', this, false);
		this.element.addEventListener('MSTransitionEnd', this, false);

		// start the fade out animation
		this.element.style.webkitTransitionDuration = '0.3s';
		this.element.style.opacity = '0';
	},

	_removeElements: function () {
		this.element.removeEventListener('transitionend', this, false);
		this.element.removeEventListener('webkitTransitionEnd', this, false);
		this.element.removeEventListener('MSTransitionEnd', this, false);

		// remove the message from the DOM
		this.container.removeChild(this.viewport);

		this.shown = false;

		// fire the custom onRemove event
		if ( this.options.onRemove ) {
			this.options.onRemove.call(this);
		}
	},

	updateViewport: function () {
		if ( !this.shown ) {
			return;
		}

		this.viewport.style.width = window.innerWidth + 'px';
		this.viewport.style.height = window.innerHeight + 'px';
		this.viewport.style.left = window.scrollX + 'px';
		this.viewport.style.top = window.scrollY + 'px';

		var clientWidth = document.documentElement.clientWidth;

		this.orientation = clientWidth > document.documentElement.clientHeight ? 'landscape' : 'portrait';

		var screenWidth = ath.OS == 'ios' ? this.orientation == 'portrait' ? screen.width : screen.height : screen.width;
		this.scale = screen.width > clientWidth ? 1 : screenWidth / window.innerWidth;

		this.element.style.fontSize = this.options.fontSize / this.scale + 'px';
	},

	resize: function () {
		clearTimeout(this.resizeTimer);
		this.resizeTimer = setTimeout(this.updateViewport.bind(this), 100);
	},

	updateSession: function () {
		if ( ath.hasLocalStorage === false ) {
			return;
		}

		localStorage.setItem(this.options.appID, JSON.stringify(this.session));
	},

	clearSession: function () {
		this.session = _defaultSession;
		this.updateSession();
	},

	optOut: function () {
		this.session.optedout = true;
		this.updateSession();
	},

	optIn: function () {
		this.session.optedout = false;
		this.updateSession();
	},

	clearDisplayCount: function () {
		this.session.displayCount = 0;
		this.updateSession();
	},

	_preventDefault: function (e) {
		e.preventDefault();
		e.stopPropagation();
	}
};

// utility
function _extend (target, obj) {
	for ( var i in obj ) {
		target[i] = obj[i];
	}

	return target;
}

function _removeToken () {
	if ( document.location.hash == '#ath' ) {
		history.replaceState('', window.document.title, document.location.href.split('#')[0]);
	}

	if ( _reSmartURL.test(document.location.href) ) {
		history.replaceState('', window.document.title, document.location.href.replace(_reSmartURL, '$1'));
	}

	if ( _reQueryString.test(document.location.search) ) {
		history.replaceState('', window.document.title, document.location.href.replace(_reQueryString, '$2'));
	}
}

// expose to the world
window.addToHomescreen = ath;

})(window, document);


if ( wptouchFdnAddToHome.bubbleExpiryInDays == 0 ) {
	localStorage.removeItem( 'org.cubiq.addtohome' );
}

var addToHomeConfig = {
	message: wptouchFdnAddToHome.bubbleMessage,				// The message shown (configured in admin)
	displayPace: wptouchFdnAddToHome.bubbleExpiryInDays,	// Days to wait before showing the popup again (0 = always displayed)
	autostart: true,										// Automatically open the balloon
	skipFirstVisit: false,									// Show the balloon to returning visitors only (setting this to true is HIGHLY RECCOMENDED)
	startDelay: 1,											// Display the message after that many seconds from page load
	lifespan: 1200,//60,											// 60 seconds before it is automatically destroyed
	icon: true												// Display the homescreen icon
};

addToHomescreen( addToHomeConfig );
/* WPtouch Foundation Google Fonts Code */

var googleBodyEls = ( 'form *' );
var googleHeadingEls = ( 'h1, h2, h3, h4, h5, h6' );

function addGoogleFontClasses() {
	jQuery( googleBodyEls ).addClass( 'body-font' );
	jQuery( googleHeadingEls ).addClass( 'heading-font' );
}

jQuery( document ).ready( function() { addGoogleFontClasses(); });
jQuery( document ).ajaxComplete( function() { addGoogleFontClasses(); });
function doFoundationLoadMoreReady() {
	var loadMoreLink = 'a.load-more-link';
	jQuery( '#content' ).on( 'click', loadMoreLink, function( e ) {
		jQuery( loadMoreLink ).addClass( 'ajaxing' ).text( wptouchFdn.ajaxLoading ).prepend( '<span class="spinner"></span>' );
		jQuery( '.spinner' ).spin( 'tiny' );
		var loadMoreURL = jQuery( loadMoreLink ).attr( 'rel' );

		jQuery( loadMoreLink ).after( "<span class='ajax-target'></span>" );
		jQuery( '.ajax-target' ).load( loadMoreURL + ' #content > div, #content .load-more-link', function() {
			jQuery( '.ajax-target' ).replaceWith( jQuery( this ).html() );	
			jQuery( '.ajaxing' ).animate( { height: 'toggle' }, 200, 'linear', function(){ jQuery( this ).remove(); } );
		});
		
		e.preventDefault();
	});	

	// Load More Comments
	var loadMoreComsLink = '.load-more-comments-wrap a';
	jQuery( '.commentlist' ).on( 'click', loadMoreComsLink, function() {
		jQuery( loadMoreComsLink ).addClass( 'ajaxing' ).text( wptouchFdn.ajaxLoading ).prepend( '<span class="spinner"></span>' );
		jQuery( '.spinner' ).spin( 'tiny' );
		var loadMoreURL = jQuery( loadMoreComsLink ).prop( 'href' );

		jQuery( loadMoreComsLink ).parent().after( "<span class='ajax-target'></span>" );
		jQuery( '.ajax-target' ).load( loadMoreURL + ' ol.commentlist > li', function() {
			jQuery( '.ajax-target' ).replaceWith( jQuery( this ).html() );	
			jQuery( '.ajaxing' ).animate( { height: 'toggle' }, 200, 'linear', function(){ jQuery( this ).parent().remove(); } );
		});
		
		return false;
	});

	// Load More Post Search Results
	var loadMorePostSearchLink = 'a.load-more-post-link';
	jQuery( '#content' ).on( 'click', loadMorePostSearchLink, function( e ) {
		jQuery( loadMorePostSearchLink ).addClass( 'ajaxing' ).text( wptouchFdn.ajaxLoading ).prepend( '<span class="spinner"></span>' );
		jQuery( '.spinner' ).spin( 'tiny' );
		var loadMoreURL = jQuery( loadMorePostSearchLink ).attr( 'rel' );

		jQuery( loadMorePostSearchLink ).after( "<span class='ajax-target'></span>" );
		jQuery( '.ajax-target' ).load( loadMoreURL + ' #content #post-results, #content .load-more-post-link', function() {
			jQuery( '.ajax-target' ).replaceWith( jQuery( this ).html() );	
			jQuery( '.ajaxing' ).animate( { height: 'toggle' }, 200, 'linear', function(){ jQuery( this ).remove(); } );
		});
		
		e.preventDefault();
	});	

	// Load More Page Search Results
	var loadMorePageSearchLink = 'a.load-more-page-link';
	jQuery( '#content' ).on( 'click', loadMorePageSearchLink, function( e ) {
		jQuery( loadMorePageSearchLink ).addClass( 'ajaxing' ).text( wptouchFdn.ajaxLoading ).prepend( '<span class="spinner"></span>' );
		jQuery( '.spinner' ).spin( 'tiny' );
		var loadMoreURL = jQuery( loadMorePageSearchLink ).attr( 'rel' );

		jQuery( loadMorePageSearchLink ).after( "<span class='ajax-target'></span>" );
		jQuery( '.ajax-target' ).load( loadMoreURL + ' #content #page-results, #content .load-more-page-link', function() {
			jQuery( '.ajax-target' ).replaceWith( jQuery( this ).html() );	
			jQuery( '.ajaxing' ).animate( { height: 'toggle' }, 200, 'linear', function(){ jQuery( this ).remove(); } );
		});
		
		e.preventDefault();
	});	

}
jQuery( document ).ready( function() { doFoundationLoadMoreReady(); });
/*global jQuery */
/*!
* FitVids 1.0.1 (modded by http://ialreadydontlikeyou.tumblr.com/post/19574163656/a-modification-to-fitvids-js)
*
* Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
* Date: Thu Sept 01 18:00:00 2011 -0500
*/

(function( $ ){

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null
    }

	var div = document.createElement('style'),
	ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];

    div.innerHTML =
		'.fluid-width-video-wrapper {				\
			width: 100%;										\
			position: relative;								\
			padding: 0;										\
		}                           			       				\
																	\
		.fluid-width-video-wrapper iframe,		\
		.fluid-width-video-wrapper object, 		\
		.fluid-width-video-wrapper embed {	\
			position: absolute;							\
			top: 0;                          					\
			left: 0;                        						\
			width: 100%;                    					\
			height: 100%;									\
		}';

    ref.parentNode.insertBefore(div,ref);

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        // Vimeo
        "iframe[src^='http://player.vimeo.com']",
        "iframe[src^='https://player.vimeo.com']",
        "iframe[src^='//player.vimeo.com']",
        // YouTube
        "iframe[src^='http://www.youtube.com']",
        "iframe[src^='https://www.youtube.com']",
        "iframe[src^='//www.youtube.com']",
        // Others
        "iframe[src^='http://www.kickstarter.com']",
		"iframe[src^='http://www.funnyordie.com']",
		"iframe[src^='http://media.mtvnservices.com']",
		"iframe[src^='http://trailers.apple.com']",
		"iframe[src^='http://www.brightcove.com']",
		"iframe[src^='http://blip.tv']",
		"iframe[src^='http://break.com']",
		"iframe[src^='http://www.traileraddict.com']",
		"iframe[src^='http://d.yimg.com']",
		"iframe[src^='http://movies.yahoo.com']",
		"iframe[src^='http://www.dailymotion.com']",
		"iframe[src^='http://s.mcstatic.com']",
		"iframe[src^='http://vine.co']",
		"iframe[src^='https://vine.co']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var $allVideos = $(this).find(selectors.join(','));

      $allVideos.each(function(){
        var $this = $(this);
        if (this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        var height = this.tagName.toLowerCase() == 'object' ? $this.attr('height') : $this.height(),
            aspectRatio = height / $this.width();
		if(!$this.attr('id')){
			var videoID = 'fitvid' + Math.floor(Math.random()*999999);
			$this.attr('id', videoID);
		}
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });

  }
})( jQuery );
/* WPtouch Foundation Media Handling Code */

function handleVids() {
	// Add dynamic automatic video resizing via fitVids (if enabled)
	if ( jQuery.isFunction( jQuery.fn.fitVids ) ) {	
		jQuery( '#content' ).fitVids();
	}
	
	// Add dynamic automatic video resizing via CoyierVids (if enabled)
	if ( typeof window.coyierVids == 'function' ) {
		coyierVids();
	}
	
	// If we have html5 videos, add controls for them if they're not specified, CSS will style them appropriately
	if ( jQuery( 'video' ).length ) {
		jQuery( 'video' ).attr( 'controls', 'controls' );
	}
}

// Fixes all HTML5 videos from trigging when menus are overtop
function listenForMenuOpenHideVideos(){
	jQuery( '.show-hide-toggle' ).on( 'click', function(){
		setTimeout( function(){
			var menuDisplay = jQuery( '#menu, #alt-menu' ).css( 'display' );
			if ( menuDisplay == 'block' ) {
				jQuery( '.css-videos video, .css-videos embed, .css-videos object, .css-videos .mejs-container' ).css( 'visibility', 'hidden' );
			} else {
				jQuery( '.css-videos video, .css-videos embed, .css-videos object, .css-videos .mejs-container' ).css( 'visibility', 'visible' );			
			}
		}, 500 );

	});
}

jQuery( document ).ready( function() { 
	handleVids(); 
	listenForMenuOpenHideVideos();
});

function doFoundationFeaturedLoaded() {
	foundationCreateDots();

	var slideNumber = 0;
	var isContinuous = false;

	var slideOption = '0';
	if ( jQuery( '#slider' ).hasClass( 'slide' ) ) {
		slideOption = '4000';
		if ( jQuery( '#slider' ).hasClass( 'slow') ) {
			slideOption = '6000';
		} else if ( jQuery( '#slider').hasClass( 'fast') ) {
			slideOption = '2500';
		}
	}

	if ( jQuery( '#slider' ).hasClass( 'continuous' ) ) {
		isContinuous = true;
	}

	var bullets = jQuery( '.dots' ).find( 'li' );

	var sliderOptions = {
		startSlide: slideNumber,
		continuous: isContinuous,
		callback: function( pos ) {
			if ( isNaN( pos ) ) {
				pos = 0;
			}
			var i = bullets.length;
			if ( i > 0 ) {
				while (i--) {
					bullets[i].className = ' ';
				}
				bullets[pos].className = 'active';
			}
		}
	}

	// only include this parameter if it's non-zero
	if ( slideOption > 0  && !jQuery( 'body' ).hasClass( 'rtl' ) ) {
		sliderOptions.auto = slideOption;
	}

	jQuery( '.one-swipe-image' ).css( 'visibility', 'visible' );

	var featuredSlider = new Swipe( document.getElementById( 'slider' ), sliderOptions );
}

function foundationCreateDots() {

	var sliderEl = jQuery( '#slider' );
	var images = sliderEl.find( 'a' );
	var slideNumber = 0;

	// Create dots
	var dots = '<ul class="dots">';

	for ( i = 0; i < images.length; i++ ) {
		dots = dots + '<li data-pos="'+i+'">&nbsp;</li>';
	}

	dots = dots + '</ul>';

	sliderEl.before( dots );

	jQuery( '.dots' ).find( 'li[data-pos="'+slideNumber+'"]' ).addClass( 'active' );
}

jQuery( document ).ready( function() {
	doFoundationFeaturedLoaded();
});
/*
 * jquery.tappable.js version 0.2
 *
 * 'Tapped' touch behaviour for elements
 *
 *  - A 'touched' class is added to the element as soon as it is tapped (or, in
 *    the case of a "long tap" - when the user keeps their finger down for a
 *    moment - after a specified delay).
 *
 *  - The supplied callback is called as soon as the user lifts their finger.
 *
 *  - The class is removed, and firing of the callback cancelled, if the user moves
 *    their finger (though this can be disabled).
 *
 *  - If the browser doesn't support touch events, it falls back to click events.
 *
 * More detailed explanation of behaviour and background:
 * http://aanandprasad.com/articles/jquery-tappable/
 *
 * See it in action here: http://nnnnext.com
 *
 * I recommend that you add a `-webkit-tap-highlight-color: rgba(0,0,0,0)`
 * style rule to any elements you wish to make tappable, to hide the ugly grey
 * click overlay.
 *
 * Tested on iOS 4.3 and some version of Android, I don't know. Leave me alone.
 *
 * Basic usage:
 *
 *   $(element).tappable(function() { console.log("Hello World!") })
 *
 * Advanced usage:
 *
 *   $(element).tappable({
 *     callback:     function() { console.log("Hello World!") },
 *     cancelOnMove: false,
 *     touchDelay:   150,
 *     onlyIf:       function(el) { return $(el).hasClass('enabled') }
 *   })
 *
 * Options:
 *
 *   cancelOnMove: If truthy, then as soon as the user moves their finger, the
 *                 'touched' class is removed from the element. When they lift
 *                 their finger, the callback will *not* be fired. Defaults to
 *                 true.
 *
 *   touchDelay:   Time to wait (ms) before adding the 'touched' class when the
 *                 user performs a "long tap". Best employed on elements that the
 *                 user is likely to touch while scrolling. Around 150 will work
 *                 well. Defaults to 0.
 *   
 *   onlyIf:       Function to run as soon as the user touches the element, to
 *                 determine whether to do anything. If it returns a falsy value,
 *                 the 'touched' class will not be added and the callback will
 *                 not be fired.
 *
 */
 (function($){var touchSupported=("ontouchstart" in window);$.fn.tappable=function(options){var cancelOnMove=true,onlyIf=function(){return true},touchDelay=0,callback;switch(typeof options){case"function":callback=options;break;case"object":callback=options.callback;if(typeof options.cancelOnMove!="undefined"){cancelOnMove=options.cancelOnMove}if(typeof options.onlyIf!="undefined"){onlyIf=options.onlyIf}if(typeof options.touchDelay!="undefined"){touchDelay=options.touchDelay}break}var fireCallback=function(el,event){if(typeof callback=="function"&&onlyIf(el)){callback.call(el,event)}};if(touchSupported){this.bind("touchstart",function(event){var el=this;if(onlyIf(this)){$(el).addClass("touch-started");window.setTimeout(function(){if($(el).hasClass("touch-started")){$(el).addClass("touched")}},touchDelay)}return true});this.bind("touchend",function(event){var el=this;if($(el).hasClass("touch-started")){$(el).removeClass("touched").removeClass("touch-started");fireCallback(el,event)}return true});/*this.bind("click",function(event){ event.preventDefault() });*/if(cancelOnMove){this.bind("touchmove",function(){$(this).removeClass("touched").removeClass("touch-started")})}}else{if(typeof callback=="function"){this.bind("click",function(event){if(onlyIf(this)){callback.call(this,event)}})}}return this}})(jQuery);
jQuery( window ).load( function() {
	bindTappableEls( '.tappable, .show-hide-toggle, .slide-toggle, .menu-btn' );
});

jQuery( document ).ajaxComplete( function() {
	bindTappableEls( '.tappable, .show-hide-toggle, .slide-toggle, .menu-btn' );
});

function bindTappableEls( elements ){
	jQuery( elements ).each( function(){
		jQuery( this ).tappable({ touchDelay: 74 });
	});
}
/* WPtouch Foundation FastClick w/ jQuery Code */
jQuery( function() {
    FastClick.attach( document.body );
});
(function(){function FastClick(layer,options){var oldOnClick;options=options||{};this.trackingClick=false;this.trackingClickStart=0;this.targetElement=null;this.touchStartX=0;this.touchStartY=0;this.lastTouchIdentifier=0;this.touchBoundary=options.touchBoundary||10;this.layer=layer;this.tapDelay=options.tapDelay||200;if(FastClick.notNeeded(layer)){return}function bind(method,context){return function(){return method.apply(context,arguments)}}var methods=["onMouse","onClick","onTouchStart","onTouchMove","onTouchEnd","onTouchCancel"];var context=this;for(var i=0,l=methods.length;i<l;i++){context[methods[i]]=bind(context[methods[i]],context)}if(deviceIsAndroid){layer.addEventListener("mouseover",this.onMouse,true);layer.addEventListener("mousedown",this.onMouse,true);layer.addEventListener("mouseup",this.onMouse,true)}layer.addEventListener("click",this.onClick,true);layer.addEventListener("touchstart",this.onTouchStart,false);layer.addEventListener("touchmove",this.onTouchMove,false);layer.addEventListener("touchend",this.onTouchEnd,false);layer.addEventListener("touchcancel",this.onTouchCancel,false);if(!Event.prototype.stopImmediatePropagation){layer.removeEventListener=function(type,callback,capture){var rmv=Node.prototype.removeEventListener;if(type==="click"){rmv.call(layer,type,callback.hijacked||callback,capture)}else{rmv.call(layer,type,callback,capture)}};layer.addEventListener=function(type,callback,capture){var adv=Node.prototype.addEventListener;if(type==="click"){adv.call(layer,type,callback.hijacked||(callback.hijacked=function(event){if(!event.propagationStopped){callback(event)}}),capture)}else{adv.call(layer,type,callback,capture)}}}if(typeof layer.onclick==="function"){oldOnClick=layer.onclick;layer.addEventListener("click",function(event){oldOnClick(event)},false);layer.onclick=null}}var deviceIsAndroid=navigator.userAgent.indexOf("Android")>0;var deviceIsIOS=/iP(ad|hone|od)/.test(navigator.userAgent);var deviceIsIOS4=deviceIsIOS&&(/OS 4_\d(_\d)?/).test(navigator.userAgent);var deviceIsIOSWithBadTarget=deviceIsIOS&&(/OS ([6-9]|\d{2})_\d/).test(navigator.userAgent);var deviceIsBlackBerry10=navigator.userAgent.indexOf("BB10")>0;FastClick.prototype.needsClick=function(target){switch(target.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(target.disabled){return true}break;case"input":if((deviceIsIOS&&target.type==="file")||target.disabled){return true}break;case"label":case"video":return true}return(/\bneedsclick\b/).test(target.className)};FastClick.prototype.needsFocus=function(target){switch(target.nodeName.toLowerCase()){case"textarea":return true;case"select":return !deviceIsAndroid;case"input":switch(target.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return false}return !target.disabled&&!target.readOnly;default:return(/\bneedsfocus\b/).test(target.className)}};FastClick.prototype.sendClick=function(targetElement,event){var clickEvent,touch;if(document.activeElement&&document.activeElement!==targetElement){document.activeElement.blur()}touch=event.changedTouches[0];clickEvent=document.createEvent("MouseEvents");clickEvent.initMouseEvent(this.determineEventType(targetElement),true,true,window,1,touch.screenX,touch.screenY,touch.clientX,touch.clientY,false,false,false,false,0,null);clickEvent.forwardedTouchEvent=true;targetElement.dispatchEvent(clickEvent)};FastClick.prototype.determineEventType=function(targetElement){if(deviceIsAndroid&&targetElement.tagName.toLowerCase()==="select"){return"mousedown"}return"click"};FastClick.prototype.focus=function(targetElement){var length;if(deviceIsIOS&&targetElement.setSelectionRange&&targetElement.type.indexOf("date")!==0&&targetElement.type!=="time"){length=targetElement.value.length;targetElement.setSelectionRange(length,length)}else{targetElement.focus()}};FastClick.prototype.updateScrollParent=function(targetElement){var scrollParent,parentElement;scrollParent=targetElement.fastClickScrollParent;if(!scrollParent||!scrollParent.contains(targetElement)){parentElement=targetElement;do{if(parentElement.scrollHeight>parentElement.offsetHeight){scrollParent=parentElement;targetElement.fastClickScrollParent=parentElement;break}parentElement=parentElement.parentElement}while(parentElement)}if(scrollParent){scrollParent.fastClickLastScrollTop=scrollParent.scrollTop}};FastClick.prototype.getTargetElementFromEventTarget=function(eventTarget){if(eventTarget.nodeType===Node.TEXT_NODE){return eventTarget.parentNode}return eventTarget};FastClick.prototype.onTouchStart=function(event){var targetElement,touch,selection;if(event.targetTouches.length>1){return true}targetElement=this.getTargetElementFromEventTarget(event.target);touch=event.targetTouches[0];if(deviceIsIOS){selection=window.getSelection();if(selection.rangeCount&&!selection.isCollapsed){return true}if(!deviceIsIOS4){if(touch.identifier&&touch.identifier===this.lastTouchIdentifier){event.preventDefault();return false}this.lastTouchIdentifier=touch.identifier;this.updateScrollParent(targetElement)}}this.trackingClick=true;this.trackingClickStart=event.timeStamp;this.targetElement=targetElement;this.touchStartX=touch.pageX;this.touchStartY=touch.pageY;if((event.timeStamp-this.lastClickTime)<this.tapDelay){event.preventDefault()}return true};FastClick.prototype.touchHasMoved=function(event){var touch=event.changedTouches[0],boundary=this.touchBoundary;if(Math.abs(touch.pageX-this.touchStartX)>boundary||Math.abs(touch.pageY-this.touchStartY)>boundary){return true}return false};FastClick.prototype.onTouchMove=function(event){if(!this.trackingClick){return true}if(this.targetElement!==this.getTargetElementFromEventTarget(event.target)||this.touchHasMoved(event)){this.trackingClick=false;this.targetElement=null}return true};FastClick.prototype.findControl=function(labelElement){if(labelElement.control!==undefined){return labelElement.control}if(labelElement.htmlFor){return document.getElementById(labelElement.htmlFor)}return labelElement.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")};FastClick.prototype.onTouchEnd=function(event){var forElement,trackingClickStart,targetTagName,scrollParent,touch,targetElement=this.targetElement;if(!this.trackingClick){return true}if((event.timeStamp-this.lastClickTime)<this.tapDelay){this.cancelNextClick=true;return true}this.cancelNextClick=false;this.lastClickTime=event.timeStamp;trackingClickStart=this.trackingClickStart;this.trackingClick=false;this.trackingClickStart=0;if(deviceIsIOSWithBadTarget){touch=event.changedTouches[0];targetElement=document.elementFromPoint(touch.pageX-window.pageXOffset,touch.pageY-window.pageYOffset)||targetElement;targetElement.fastClickScrollParent=this.targetElement.fastClickScrollParent}targetTagName=targetElement.tagName.toLowerCase();if(targetTagName==="label"){forElement=this.findControl(targetElement);if(forElement){this.focus(targetElement);if(deviceIsAndroid){return false}targetElement=forElement}}else{if(this.needsFocus(targetElement)){if((event.timeStamp-trackingClickStart)>100||(deviceIsIOS&&window.top!==window&&targetTagName==="input")){this.targetElement=null;return false}this.focus(targetElement);this.sendClick(targetElement,event);if(!deviceIsIOS||targetTagName!=="select"){this.targetElement=null;event.preventDefault()}return false}}if(deviceIsIOS&&!deviceIsIOS4){scrollParent=targetElement.fastClickScrollParent;if(scrollParent&&scrollParent.fastClickLastScrollTop!==scrollParent.scrollTop){return true}}if(!this.needsClick(targetElement)){event.preventDefault();this.sendClick(targetElement,event)}return false};FastClick.prototype.onTouchCancel=function(){this.trackingClick=false;this.targetElement=null};FastClick.prototype.onMouse=function(event){if(!this.targetElement){return true}if(event.forwardedTouchEvent){return true}if(!event.cancelable){return true}if(!this.needsClick(this.targetElement)||this.cancelNextClick){if(event.stopImmediatePropagation){event.stopImmediatePropagation()}else{event.propagationStopped=true}event.stopPropagation();event.preventDefault();return false}return true};FastClick.prototype.onClick=function(event){var permitted;if(this.trackingClick){this.targetElement=null;this.trackingClick=false;return true}if(event.target.type==="submit"&&event.detail===0){return true}permitted=this.onMouse(event);if(!permitted){this.targetElement=null}return permitted};FastClick.prototype.destroy=function(){var layer=this.layer;if(deviceIsAndroid){layer.removeEventListener("mouseover",this.onMouse,true);layer.removeEventListener("mousedown",this.onMouse,true);layer.removeEventListener("mouseup",this.onMouse,true)}layer.removeEventListener("click",this.onClick,true);layer.removeEventListener("touchstart",this.onTouchStart,false);layer.removeEventListener("touchmove",this.onTouchMove,false);layer.removeEventListener("touchend",this.onTouchEnd,false);layer.removeEventListener("touchcancel",this.onTouchCancel,false)};FastClick.notNeeded=function(layer){var metaViewport;var chromeVersion;var blackberryVersion;if(typeof window.ontouchstart==="undefined"){return true}chromeVersion=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1];if(chromeVersion){if(deviceIsAndroid){metaViewport=document.querySelector("meta[name=viewport]");if(metaViewport){if(metaViewport.content.indexOf("user-scalable=no")!==-1){return true}if(chromeVersion>31&&document.documentElement.scrollWidth<=window.outerWidth){return true}}}else{return true}}if(deviceIsBlackBerry10){blackberryVersion=navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/);if(blackberryVersion[1]>=10&&blackberryVersion[2]>=3){metaViewport=document.querySelector("meta[name=viewport]");if(metaViewport){if(metaViewport.content.indexOf("user-scalable=no")!==-1){return true}if(document.documentElement.scrollWidth<=window.outerWidth){return true}}}}if(layer.style.msTouchAction==="none"){return true}return false};FastClick.attach=function(layer,options){return new FastClick(layer,options)};if(typeof define=="function"&&typeof define.amd=="object"&&define.amd){define(function(){return FastClick})}else{if(typeof module!=="undefined"&&module.exports){module.exports=FastClick.attach;module.exports.FastClick=FastClick}else{window.FastClick=FastClick}}}());
/*! PushIt - v1.0
* An elegant transform-based off-canvas solution for providing left & right menus for mobile websites, complete with jQuery fallback.
* Based on "Pushy" by Christopher Yee - http://christopheryee.ca/pushy/
* Modified for left and right menu support by BraveNewCode Inc. for WPtouch - http://www.wptouch.com
*/

// Let's get the current vendor prefix for each browser
var prefix = (function() {
	var styles = window.getComputedStyle( document.documentElement, '' ),
	vendor = ( Array.prototype.slice.call( styles ).join( '' ).match( /-(moz|webkit|ms)-/ ) || ( styles.OLink === '' && ['', 'o'] ) )[1];
	return { css: '-' + vendor + '-' }
})();

( function( $ ){

	// Hey! Ow! Push it good!
	$.fn.pushIt = function( options ) {

		var settings = $.extend( {
			leftMenu: 			jQuery( '.pushit-left' ),
			rightMenu:	 		jQuery( '.pushit-right' ),
			body: 				jQuery( 'body' ),
			container: 			jQuery( '.page-wrapper' ),	// container element
			pushItActiveClass:	'pushit-active',			// element to toggle site overlay
			containerClass: 	'container-pushit',			// container open
			menuBtn: 			jQuery('.menu-btn'),		// css classe(s) to toggle the menu
			viewportWidth:	 	jQuery( window ).width(),	// Needed to position a right menu
			menuWidth:	 		240,						// Menu width (default is 240px)
			menuSpeed:	 		330,						// Speed of the menu transistion, in milliseconds
			bezierCurve:		'.290, .050, .140, .870',	// Menu transistion bezier
			pushed: 			false,
			lastAspect:         false                       // Store last aspect ratio
		}, options );

		var hasOverflowScroll = typeof( jQuery( 'body' )[0].style['-webkit-overflow-scrolling'] ) !== 'undefined';
		if ( hasOverflowScroll ) {
			jQuery( 'body' ).addClass( 'has-overflow-scroll' );
		}

		// Add the overlay div
		settings.body.append( '<div id="pushit-overlay"></div>' );
		var pushitOverlay = jQuery( '#pushit-overlay' );

		// Setup default positioning and width
		settings.leftMenu.addClass( 'pushit-left' )
			.css( 'left', '-' + settings.menuWidth + 'px' )
			.css( 'width', settings.menuWidth + 'px' );

		// Setup default positioning and width
		settings.rightMenu.addClass( 'pushit-right' )
			.css( 'width', settings.menuWidth + 'px' )
			.css( 'left', settings.viewportWidth + 'px' );

		// Make sure it's positioned relative & add the transition CSS for slide prep
		settings.container
			.css( 'position', 'relative' )
			.css( prefix.css+'transition', prefix.css+'transform .'+settings.menuSpeed+'s cubic-bezier('+settings.bezierCurve+')' );

		settings.lastAspect = getAspect();

		// Add the transition CSS for slide  prep
		jQuery( '.pushit' )
			.css( prefix.css+'transition', prefix.css+'transform .'+settings.menuSpeed+'s cubic-bezier('+settings.bezierCurve+')' );

		function getAspect() {
			if ( jQuery( window ).width() < jQuery( window ).height() ) {
				return 'portrait';
			} else {
				return 'landscape';
			}
		}

		function whichPushIt( clicked ){
			var parent = clicked;
			if ( parent.hasClass( 'pushit-left' ) ) {
				return 'left';
			} else {
				return 'right';
			}
		}

		function oppositePushIt( direction ) {
			var direction = ( direction == 'left' ? 'right' : 'left' );
			return direction;
		}

		function cleanUpPushit(){
			setTimeout( function(){
				// Cleanup memory usage!
				settings.container
					.css( prefix.css+'transform', '' )
					.css( 'position', '' )
					.css( 'overflow', '' )
					.css( 'height', '' );
				pushitOverlay.css( 'z-index', '-1' );
			}, settings.menuSpeed + 300 );
		}

		// Close menu when clicking container
		function pushitCloseListener() {
			pushitOverlay.one( 'click.pushit touchmove.pushit', function( e ){
				e.preventDefault();
				e.stopImmediatePropagation();
				togglePushIt( settings.pushed );
				pushitOverlay.off( 'click.pushit touchmove.pushit' );
			}).css( 'z-index', '99' );
		}

		function disableTouchMove(){
			settings.container.on( 'touchmove', function( e ){
//			    e.preventDefault();
			});
		}

		function enableTouchMove(){
//			settings.container.off( 'touchmove' );
		}

		function repositionPushIt(){
			var currentWindow = jQuery( window );
			currentWindow.resize( function(){

				// Move the right menu if it exists to a new position outside the viewport right
				if ( settings.rightMenu.length ) {
					settings.viewportWidth = currentWindow.width();
					settings.rightMenu.css( 'left', settings.viewportWidth + 'px' );
				}

				// Hide the menu if the aspect changes
				if ( settings.lastAspect != getAspect() ) {
					settings.lastAspect = getAspect();


					// Close the menu on a rotate— no need to have the browser choke on render
					if ( jQuery( '.pushit-active' ).length ) {
						pushitOverlay.trigger( 'click' );
						cleanUpPushit();
					}

				}
			});
		}

		function togglePushIt( clicked ){
			settings.pushed = clicked;
			direction = whichPushIt( clicked );
			var side = ('.pushit-' + direction );
			var activeSide = jQuery( side );
			jQuery( side ).toggleClass( 'pushit-open' );
			// Left Menus
			// Open
			if ( side == '.pushit-left' && activeSide.hasClass( 'pushit-open' ) ) {
				disableTouchMove();
				pushitCloseListener();
				settings.container
					.height( window.innerHeight )
					.css( 'position', 'fixed' )
					.css( 'overflow', 'hidden' );

				if ( prefix.css != '' ){
					activeSide.css( prefix.css+'transform', 'translate3d(' + settings.menuWidth + 'px, 0, 0)' );
					settings.container.css( prefix.css+'transform', 'translate3d(' + settings.menuWidth + 'px, 0, 0)' );
				} else {
					activeSide.animate( { left: '0' }, settings.menuSpeed );
					settings.container.animate( { left: settings.menuWidth }, settings.menuSpeed );
				}
			// Closed
			} else if ( side == '.pushit-left' && !activeSide.hasClass( 'pushit-open' ) ) {
				enableTouchMove();
				if ( prefix.css != '' ){
					activeSide.css( prefix.css+'transform', 'translate3d(0, 0, 0)' );
					settings.container.css( prefix.css+'transform', 'translate3d(0, 0, 0)' );
				} else {
					activeSide.animate( { left: '-' + settings.menuWidth }, settings.menuSpeed );
					settings.container.animate( { left: '0' }, settings.menuSpeed );
				}
				cleanUpPushit();
			}
			// Right Menus
			// Open
			if ( side == '.pushit-right' && jQuery( side ).hasClass( 'pushit-open' ) ) {
				disableTouchMove();
				pushitCloseListener();
				settings.container
					.height( window.innerHeight )
					.css( 'position', 'fixed' )
					.css( 'overflow', 'hidden' );

				if ( prefix.css != '' ){
					activeSide.css( prefix.css+'transform', 'translate3d(-' + settings.menuWidth + 'px, 0, 0)' );
					settings.container.css( prefix.css+'transform', 'translate3d(-' + settings.menuWidth + 'px, 0, 0)' );
				} else {
					activeSide.animate( { left: settings.viewportWidth - settings.menuWidth }, settings.menuSpeed );
					settings.container.animate( { left: '-' + settings.menuWidth }, settings.menuSpeed );
				}
			// Closed
			} else if ( side == '.pushit-right' && !jQuery( side ).hasClass( 'pushit-open' ) ) {
				enableTouchMove();
				if ( prefix.css != '' ){
					activeSide.css( prefix.css+'transform', 'translate3d(0, 0, 0)' );
					settings.container.css( prefix.css+'transform', 'translate3d(0, 0, 0)' );
				} else {
					activeSide.animate( { left: settings.viewportWidth }, settings.menuSpeed );
					settings.container.animate( { left: '0' }, settings.menuSpeed );
				}
				cleanUpPushit();
			}

			settings.container.toggleClass( whichPushIt( clicked ) );
			settings.body.toggleClass( settings.pushItActiveClass ); //toggle site overlay
			settings.container.toggleClass( settings.containerClass );
		}

		repositionPushIt();

		// Toggle menu
		settings.menuBtn.on( 'click.pushit-button', function( e ) {
			e.preventDefault();
			e.stopImmediatePropagation();
			menuTarget = '#' + jQuery( this ).attr( 'data-menu-target' );
			togglePushIt( jQuery( menuTarget ).parent() );
		});
	}
})( jQuery );
// WPtouch Basic Client-side Ajax Routines
function WPtouchAjax( actionName, actionParams, callback ) {
	var ajaxData = {
		action: "wptouch_client_ajax",
		wptouch_action: actionName,
		wptouch_nonce: wptouchMain.security_nonce
	};

	for ( name in actionParams ) { ajaxData[name] = actionParams[name]; }

	jQuery.post( wptouchMain.ajaxurl, ajaxData, function( result ) {
		callback( result );
	});
}

jQuery( 'table' ).parent( 'p,div' ).addClass( 'table-parent' );

jQuery( '#footer .back-to-top' ).click( function( e ) {
	e.preventDefault();
	jQuery( window ).scrollTop( 0 );
});

function doWPtouchReady() {
	// Shortcode
	var shortcodeDiv = jQuery( '.wptouch-sc-content' );

	if ( shortcodeDiv.length ) {
		// We have a shortcode
		var params = {
			post_id: shortcodeDiv.attr( 'data-post-id' ),
			post_content: jQuery( '.wptouch-orig-content' ).html()
		};

		WPtouchAjax( 'handle_shortcode', params, function( response ) {
			if ( response == 'WPTOUCH_NO_SHORTCODE' ) {
				// No desktop shortcode, show the original one
				shortcodeDiv.hide();
				jQuery( '.wptouch-orig-content' ).show();
			} else {
				shortcodeDiv.html( response );
			}
		});
	}
}

jQuery( document ).ready( function() { doWPtouchReady(); });

