WebFontConfig={google:{families:["Open+Sans::latin"]}},function(){var e=document.createElement("script");e.src=("https:"==document.location.protocol?"https":"http")+"://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js",e.type="text/javascript",e.async="true";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)}(),jQuery(document).ready(function(e){function n(e){return"none"==e.css("display")?!1:!0}function s(){e(".sdrn_parent_item_li").each(function(){var n=e(this),s=0,i=n.find(".sdrn_icon_par").first(),t=n.find("a.sdrn_parent_item").first();s=m.hasClass("top")?window.innerWidth:h.innerWidth(),0==n.find(".sdrn_clear").length&&t.after('<br class="sdrn_clear"/>')})}function i(){m.find("ul.sub-menu").each(function(){var s=e(this),i=s.parent("li").find(".sdrn_icon_par"),t=s.parent("li");n(s)&&s.slideUp(300),i.removeClass("sdrn_par_opened"),i.removeClass(m.attr("data-custom_icon_open")),i.addClass(m.attr("data-custom_icon")),t.removeClass("sdrn_no_border_bottom")})}function t(){window.scrollBy(1,1),window.scrollBy(-1,-1),g=m.width(),y=window.innerHeight<p.height()?p.height():window.innerHeight,x=window.innerWidth<p.width()?p.width():window.innerWidth,p.hasClass("menu_is_opened")&&(m.hasClass("sdrn_jquery")&&(i(),p.hasClass("sdrn_left")&&(p.css({left:g}),p.scrollLeft(0)),e.sidr("close","sdrn_menu"),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened")),m.hasClass("sdrn_css3")&&(i(),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened")))}function a(s){s.length>0&&e.each(s,function(s,i){if(0==W){var t=parseInt(i.css("top"),0)>=0?parseInt(i.css("top"),0):0,a=e("#wpadminbar");n(a)&&n(l)&&i.css({top:t+42+a.height()}),n(a)&&!n(l)&&i.css({top:t+a.height()}),!n(a)&&n(l)&&i.css({top:t+42}),n(a)||n(l)||i.css({top:t}),i.css({"z-index":900}),i.addClass("fixed_animation")}}),W=!0}function r(){var s=e("#wpadminbar");n(s)&&(e("#sdrn_menu.left ul#sdrn_menu_ul, #sdrn_menu.right ul#sdrn_menu_ul").css({"padding-top":42+s.height()}),e("#sdrn_bar").css({top:s.height()}))}function o(){m.hasClass("sdrn_jquery")&&(e.sidr("close","sdrn_menu"),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened")),m.hasClass("sdrn_css3")&&(i(),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened"),e(".fixed_animation").removeClass("fixed_animation_moved"))}function d(){m.hasClass("sdrn_jquery")&&(e.sidr("open","sdrn_menu"),l.addClass("menu_is_opened"),p.addClass("menu_is_opened")),m.hasClass("sdrn_css3")&&(l.addClass("menu_is_opened"),p.addClass("menu_is_opened"),e(".fixed_animation").addClass("fixed_animation_moved"))}var l=e("#sdrn_bar"),_=l.outerHeight(!0),c=l.attr("data-from_width"),m=e("#sdrn_menu"),h=e("#sdrn_menu_ul"),u=m.find("a"),p=e("body"),f=e("html"),w=300,C=e("#wpadminbar"),v=l.length>0&&m.length>0?!0:!1,g=m.width(),b=m.attr("data-expand_sub_with_parent"),y=window.innerHeight<p.height()?p.height():window.innerHeight,x=window.innerWidth<p.width()?p.width():window.innerWidth,k=[],W=!1,j=navigator.userAgent,B=!1,S=!1;if(-1!=j.indexOf("Chrome")&&(B=!0),-1!=j.indexOf("Firefox")&&(S=!0),f.addClass("sdrn_"+Detect({useUA:!0})),v){h.find("li").first().css({"border-top":"none"}),e(document).mouseup(function(s){m.is(s.target)||0!==m.has(s.target).length||n(m)&&(m.hasClass("sdrn_jquery")&&(i(),e.sidr("close","sdrn_menu"),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened")),m.hasClass("sdrn_css3")&&(i(),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened"),e(".fixed_animation").removeClass("fixed_animation_moved")))}),m.find("ul.sub-menu").each(function(){var n=e(this),s=n.prev("a"),i=s.parent("li").first();s.addClass("sdrn_parent_item"),i.addClass("sdrn_parent_item_li");var t=s.before('<span class="sdrn_icon sdrn_icon_par icon_default '+m.attr("data-custom_icon")+'"></span> ').find(".sdrn_icon_par");n.hide()}),m.hasClass("sdrn_custom_icons")&&e("#sdrn_menu span.sdrn_icon").removeClass("icon_default"),m.find("#sdrn_menu_ul a[data-cii=1]").each(function(){var n=e(this),s=n.attr("data-fa_icon"),i=n.attr("data-icon_color"),t=n.find("div").first(),a=n.attr("data-icon_src");a||(t.addClass("sdrn_item_custom_icon"),t.addClass("sdrn_item_custom_icon_fa"),t.addClass(s),t.css({color:i})),a&&(t.addClass("sdrn_item_custom_icon"),t.html('<img src="'+a+'" width="23" height="23" alt="cii">'))}),s(),e(".sdrn_icon_par").on("click",function(n){n.preventDefault();var s=e(this),i=s.parent("li").find("ul.sub-menu").first();i.slideToggle(300),s.toggleClass("sdrn_par_opened"),""!=m.attr("data-custom_icon")&&(s.toggleClass(m.attr("data-custom_icon_open")),""!=m.attr("data-custom_icon_open")&&s.toggleClass(m.attr("data-custom_icon"))),s.parent("li").first().toggleClass("sdrn_no_border_bottom")});var q=e("meta[name=viewport]");if(q=q.length?q:e('<meta name="viewport" />').appendTo("head"),"no"==m.attr("data-zooming")?q.attr("content","user-scalable=no, width=device-width, maximum-scale=1, minimum-scale=1"):q.attr("content","user-scalable=yes, width=device-width, initial-scale=1.0, minimum-scale=1"),S?screen.addEventListener("orientationchange",function(){t()}):window.addEventListener("orientationchange",t,!1),m.hasClass("left")||m.hasClass("right")){if(m.hasClass("sdrn_jquery")){var D=m.hasClass("left")?"left":"right";l.sidr({name:"sdrn_menu",side:D,speed:w})}if(r(),m.hasClass("sdrn_css3")){m.show();var E=p.wrapInner('<div id="sdrn_wrapper">').find("#sdrn_wrapper"),M=E.wrapInner('<div id="sdrn_wrapper_inner">').find("#sdrn_wrapper_inner");m.insertBefore(E),l.insertBefore(E),C.insertBefore(E);var O=M.find("> *").filter(function(){return"fixed"===e(this).css("position")}).each(function(){var n=e(this);p.append(n),k.push(n)});a(k),p.height()<e(window).height()&&(p.height(e(window).height()),E.height(e(window).height())),E.css(""==p.css("background")||p.css("background-color").indexOf("0)")>=0?{background:"#fff"}:{background:p.css("background")})}l.on("click",function(){i(),l.toggleClass("_opened_"),l.hasClass("_opened_")?(l.addClass("menu_is_opened"),p.addClass("menu_is_opened"),e(".fixed_animation").addClass("fixed_animation_moved")):(l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened"),e(".fixed_animation").removeClass("fixed_animation_moved"))}),u.on("click",function(n){if(n.preventDefault(),"yes"==b&&e(this).parent().hasClass("sdrn_parent_item_li"))return void e(this).prev("span.sdrn_icon").trigger("click");var s=e(this).attr("href");m.hasClass("sdrn_jquery")&&e.sidr("close","sdrn_menu"),m.hasClass("sdrn_css3")&&(i(),e(".fixed_animation").removeClass("fixed_animation_moved")),l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened"),setTimeout(function(){window.location.href=s},w)}),"yes"==m.attr("data-swipe_actions")&&e(window).touchwipe({wipeLeft:function(){m.hasClass("left")&&o(),m.hasClass("right")&&d()},wipeRight:function(){m.hasClass("left")&&d(),m.hasClass("right")&&o()},preventDefaultEvents:!1}),e(window).resize(function(){x=window.innerWidth<p.width()?p.width():window.innerWidth,x>c&&n(m)&&(i(),m.hasClass("sdrn_jquery")&&e.sidr("close","sdrn_menu"),m.hasClass("sdrn_css3")&&(l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened"),e(".fixed_animation").removeClass("fixed_animation_moved"))),r(),a(k)})}else m.hasClass("top")&&(p.prepend(m),r(),l.on("click",function(n){e("html, body").animate({scrollTop:0},w),l.toggleClass("_opened_"),l.hasClass("_opened_")?(l.addClass("menu_is_opened"),p.addClass("menu_is_opened")):(l.removeClass("menu_is_opened"),p.removeClass("menu_is_opened")),i(),m.stop(!0,!1).slideToggle(w)}),u.on("click",function(n){if(n.preventDefault(),"yes"==b&&e(this).parent().hasClass("sdrn_parent_item_li"))return console.log("s"),void e(this).prev("span.sdrn_icon_par").trigger("click");var s=e(this).attr("href");m.slideUp(w,function(){window.location.href=s})}),e(window).resize(function(){x=window.innerWidth<p.width()?p.width():window.innerWidth,x>c&&n(m)&&(i(),m.slideUp(w,function(){}))}))}});var Detect=function(e){void 0===e&&(e={}),this.init=function(){return this.mm=window.matchMedia,this.mm&&!e.useUA?(this.method="media queries",this.type=n()):(this.method="user agent strings",this.type=r()),e.verbose?[this.type,this.method]:this.type};var n=function(){return t(320)&&a(480)?"smartphone":t(768)&&a(1024)?"tablet":"desktop"},s=function(e,n){return window.matchMedia("screen and ("+e+"-device-width: "+n+"px)").matches},t=function(e){return s("min",e)},a=function(e){return s("max",e)},r=function(){var e=navigator.userAgent;for(tablets=[/Android 3/i,/iPad/i],i=0,l=tablets.length;l>i;i++)if(e.match(tablets[i]))return"tablet";for(smartphones=[/Mobile/i,/Android/i,/iPhone/i,/BlackBerry/i,/Windows Phone/i,/Windows Mobile/i,/Maemo/i,/PalmSource/i,/SymbianOS/i,/SymbOS/i,/Nokia/i,/MOT-/i,/JDME/i,/Series 60/i,/S60/i,/SonyEricsson/i],i=0,l=smartphones.length;l>i;i++)if(e.match(smartphones[i]))return"smartphone";return"desktop"};return this.init()};
//# sourceMappingURL=./mobile.nav.frontend-ck.map