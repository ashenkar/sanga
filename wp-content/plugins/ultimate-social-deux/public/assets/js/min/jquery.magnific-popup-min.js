!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e("object"==typeof exports?require("jquery"):window.jQuery||window.Zepto)}(function($){var e="Close",t="BeforeClose",n="AfterClose",i="BeforeAppend",o="MarkupParse",r="Open",a="Change",s="mfp",l="."+s,c="mfp-ready",d="mfp-removing",u="mfp-prevent-close",p,f=function(){},m=!!window.jQuery,g,h=$(window),v,C,y,w,b=function(e,t){p.ev.on(s+e+l,t)},I=function(e,t,n,i){var o=document.createElement("div");return o.className="mfp-"+e,n&&(o.innerHTML=n),i?t&&t.appendChild(o):(o=$(o),t&&o.appendTo(t)),o},x=function(e,t){p.ev.triggerHandler(s+e,t),p.st.callbacks&&(e=e.charAt(0).toLowerCase()+e.slice(1),p.st.callbacks[e]&&p.st.callbacks[e].apply(p,$.isArray(t)?t:[t]))},k=function(e){return e===w&&p.currTemplate.closeBtn||(p.currTemplate.closeBtn=$(p.st.closeMarkup.replace("%title%",p.st.tClose)),w=e),p.currTemplate.closeBtn},T=function(){$.magnificPopup.instance||(p=new f,p.init(),$.magnificPopup.instance=p)},E=function(){var e=document.createElement("p").style,t=["ms","O","Moz","Webkit"];if(void 0!==e.transition)return!0;for(;t.length;)if(t.pop()+"Transition"in e)return!0;return!1};f.prototype={constructor:f,init:function(){var e=navigator.appVersion;p.isIE7=-1!==e.indexOf("MSIE 7."),p.isIE8=-1!==e.indexOf("MSIE 8."),p.isLowIE=p.isIE7||p.isIE8,p.isAndroid=/android/gi.test(e),p.isIOS=/iphone|ipad|ipod/gi.test(e),p.supportsTransition=E(),p.probablyMobile=p.isAndroid||p.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),v=$(document),p.popupsCache={}},open:function(e){var t;if(e.isObj===!1){p.items=e.items.toArray(),p.index=0;var n=e.items,i;for(t=0;t<n.length;t++)if(i=n[t],i.parsed&&(i=i.el[0]),i===e.el[0]){p.index=t;break}}else p.items=$.isArray(e.items)?e.items:[e.items],p.index=e.index||0;if(p.isOpen)return void p.updateItemHTML();p.types=[],y="",p.ev=e.mainEl&&e.mainEl.length?e.mainEl.eq(0):v,e.key?(p.popupsCache[e.key]||(p.popupsCache[e.key]={}),p.currTemplate=p.popupsCache[e.key]):p.currTemplate={},p.st=$.extend(!0,{},$.magnificPopup.defaults,e),p.fixedContentPos="auto"===p.st.fixedContentPos?!p.probablyMobile:p.st.fixedContentPos,p.st.modal&&(p.st.closeOnContentClick=!1,p.st.closeOnBgClick=!1,p.st.showCloseBtn=!1,p.st.enableEscapeKey=!1),p.bgOverlay||(p.bgOverlay=I("bg").on("click"+l,function(){p.close()}),p.wrap=I("wrap").attr("tabindex",-1).on("click"+l,function(e){p._checkIfClose(e.target)&&p.close()}),p.container=I("container",p.wrap)),p.contentContainer=I("content"),p.st.preloader&&(p.preloader=I("preloader",p.container,p.st.tLoading));var a=$.magnificPopup.modules;for(t=0;t<a.length;t++){var s=a[t];s=s.charAt(0).toUpperCase()+s.slice(1),p["init"+s].call(p)}x("BeforeOpen"),p.st.showCloseBtn&&(p.st.closeBtnInside?(b(o,function(e,t,n,i){n.close_replaceWith=k(i.type)}),y+=" mfp-close-btn-in"):p.wrap.append(k())),p.st.alignTop&&(y+=" mfp-align-top"),p.wrap.css(p.fixedContentPos?{overflow:p.st.overflowY,overflowX:"hidden",overflowY:p.st.overflowY}:{top:h.scrollTop(),position:"absolute"}),(p.st.fixedBgPos===!1||"auto"===p.st.fixedBgPos&&!p.fixedContentPos)&&p.bgOverlay.css({height:v.height(),position:"absolute"}),p.st.enableEscapeKey&&v.on("keyup"+l,function(e){27===e.keyCode&&p.close()}),h.on("resize"+l,function(){p.updateSize()}),p.st.closeOnContentClick||(y+=" mfp-auto-cursor"),y&&p.wrap.addClass(y);var d=p.wH=h.height(),u={};if(p.fixedContentPos&&p._hasScrollBar(d)){var f=p._getScrollbarSize();f&&(u.marginRight=f)}p.fixedContentPos&&(p.isIE7?$("body, html").css("overflow","hidden"):u.overflow="hidden");var m=p.st.mainClass;return p.isIE7&&(m+=" mfp-ie7"),m&&p._addClassToMFP(m),p.updateItemHTML(),x("BuildControls"),$("html").css(u),p.bgOverlay.add(p.wrap).prependTo(p.st.prependTo||$(document.body)),p._lastFocusedEl=document.activeElement,setTimeout(function(){p.content?(p._addClassToMFP(c),p._setFocus()):p.bgOverlay.addClass(c),v.on("focusin"+l,p._onFocusIn)},16),p.isOpen=!0,p.updateSize(d),x(r),e},close:function(){p.isOpen&&(x(t),p.isOpen=!1,p.st.removalDelay&&!p.isLowIE&&p.supportsTransition?(p._addClassToMFP(d),setTimeout(function(){p._close()},p.st.removalDelay)):p._close())},_close:function(){x(e);var t=d+" "+c+" ";if(p.bgOverlay.detach(),p.wrap.detach(),p.container.empty(),p.st.mainClass&&(t+=p.st.mainClass+" "),p._removeClassFromMFP(t),p.fixedContentPos){var i={marginRight:""};p.isIE7?$("body, html").css("overflow",""):i.overflow="",$("html").css(i)}v.off("keyup"+l+" focusin"+l),p.ev.off(l),p.wrap.attr("class","mfp-wrap").removeAttr("style"),p.bgOverlay.attr("class","mfp-bg"),p.container.attr("class","mfp-container"),!p.st.showCloseBtn||p.st.closeBtnInside&&p.currTemplate[p.currItem.type]!==!0||p.currTemplate.closeBtn&&p.currTemplate.closeBtn.detach(),p._lastFocusedEl&&$(p._lastFocusedEl).focus(),p.currItem=null,p.content=null,p.currTemplate=null,p.prevHeight=0,x(n)},updateSize:function(e){if(p.isIOS){var t=document.documentElement.clientWidth/window.innerWidth,n=window.innerHeight*t;p.wrap.css("height",n),p.wH=n}else p.wH=e||h.height();p.fixedContentPos||p.wrap.css("height",p.wH),x("Resize")},updateItemHTML:function(){var e=p.items[p.index];p.contentContainer.detach(),p.content&&p.content.detach(),e.parsed||(e=p.parseEl(p.index));var t=e.type;if(x("BeforeChange",[p.currItem?p.currItem.type:"",t]),p.currItem=e,!p.currTemplate[t]){var n=p.st[t]?p.st[t].markup:!1;x("FirstMarkupParse",n),p.currTemplate[t]=n?$(n):!0}C&&C!==e.type&&p.container.removeClass("mfp-"+C+"-holder");var i=p["get"+t.charAt(0).toUpperCase()+t.slice(1)](e,p.currTemplate[t]);p.appendContent(i,t),e.preloaded=!0,x(a,e),C=e.type,p.container.prepend(p.contentContainer),x("AfterChange")},appendContent:function(e,t){p.content=e,e?p.st.showCloseBtn&&p.st.closeBtnInside&&p.currTemplate[t]===!0?p.content.find(".mfp-close").length||p.content.append(k()):p.content=e:p.content="",x(i),p.container.addClass("mfp-"+t+"-holder"),p.contentContainer.append(p.content)},parseEl:function(e){var t=p.items[e],n;if(t.tagName?t={el:$(t)}:(n=t.type,t={data:t,src:t.src}),t.el){for(var i=p.types,o=0;o<i.length;o++)if(t.el.hasClass("mfp-"+i[o])){n=i[o];break}t.src=t.el.attr("data-mfp-src"),t.src||(t.src=t.el.attr("href"))}return t.type=n||p.st.type||"inline",t.index=e,t.parsed=!0,p.items[e]=t,x("ElementParse",t),p.items[e]},addGroup:function(e,t){var n=function(n){n.mfpEl=this,p._openClick(n,e,t)};t||(t={});var i="click.magnificPopup";t.mainEl=e,t.items?(t.isObj=!0,e.off(i).on(i,n)):(t.isObj=!1,t.delegate?e.off(i).on(i,t.delegate,n):(t.items=e,e.off(i).on(i,n)))},_openClick:function(e,t,n){var i=void 0!==n.midClick?n.midClick:$.magnificPopup.defaults.midClick;if(i||2!==e.which&&!e.ctrlKey&&!e.metaKey){var o=void 0!==n.disableOn?n.disableOn:$.magnificPopup.defaults.disableOn;if(o)if($.isFunction(o)){if(!o.call(p))return!0}else if(h.width()<o)return!0;e.type&&(e.preventDefault(),p.isOpen&&e.stopPropagation()),n.el=$(e.mfpEl),n.delegate&&(n.items=t.find(n.delegate)),p.open(n)}},updateStatus:function(e,t){if(p.preloader){g!==e&&p.container.removeClass("mfp-s-"+g),t||"loading"!==e||(t=p.st.tLoading);var n={status:e,text:t};x("UpdateStatus",n),e=n.status,t=n.text,p.preloader.html(t),p.preloader.find("a").on("click",function(e){e.stopImmediatePropagation()}),p.container.addClass("mfp-s-"+e),g=e}},_checkIfClose:function(e){if(!$(e).hasClass(u)){var t=p.st.closeOnContentClick,n=p.st.closeOnBgClick;if(t&&n)return!0;if(!p.content||$(e).hasClass("mfp-close")||p.preloader&&e===p.preloader[0])return!0;if(e===p.content[0]||$.contains(p.content[0],e)){if(t)return!0}else if(n&&$.contains(document,e))return!0;return!1}},_addClassToMFP:function(e){p.bgOverlay.addClass(e),p.wrap.addClass(e)},_removeClassFromMFP:function(e){this.bgOverlay.removeClass(e),p.wrap.removeClass(e)},_hasScrollBar:function(e){return(p.isIE7?v.height():document.body.scrollHeight)>(e||h.height())},_setFocus:function(){(p.st.focus?p.content.find(p.st.focus).eq(0):p.wrap).focus()},_onFocusIn:function(e){return e.target===p.wrap[0]||$.contains(p.wrap[0],e.target)?void 0:(p._setFocus(),!1)},_parseMarkup:function(e,t,n){var i;n.data&&(t=$.extend(n.data,t)),x(o,[e,t,n]),$.each(t,function(t,n){if(void 0===n||n===!1)return!0;if(i=t.split("_"),i.length>1){var o=e.find(l+"-"+i[0]);if(o.length>0){var r=i[1];"replaceWith"===r?o[0]!==n[0]&&o.replaceWith(n):"img"===r?o.is("img")?o.attr("src",n):o.replaceWith('<img src="'+n+'" class="'+o.attr("class")+'" />'):o.attr(i[1],n)}}else e.find(l+"-"+t).html(n)})},_getScrollbarSize:function(){if(void 0===p.scrollbarSize){var e=document.createElement("div");e.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(e),p.scrollbarSize=e.offsetWidth-e.clientWidth,document.body.removeChild(e)}return p.scrollbarSize}},$.magnificPopup={instance:null,proto:f.prototype,modules:[],open:function(e,t){return T(),e=e?$.extend(!0,{},e):{},e.isObj=!0,e.index=t||0,this.instance.open(e)},close:function(){return $.magnificPopup.instance&&$.magnificPopup.instance.close()},registerModule:function(e,t){t.options&&($.magnificPopup.defaults[e]=t.options),$.extend(this.proto,t.proto),this.modules.push(e)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}},$.fn.magnificPopup=function(e){T();var t=$(this);if("string"==typeof e)if("open"===e){var n,i=m?t.data("magnificPopup"):t[0].magnificPopup,o=parseInt(arguments[1],10)||0;i.items?n=i.items[o]:(n=t,i.delegate&&(n=n.find(i.delegate)),n=n.eq(o)),p._openClick({mfpEl:n},t,i)}else p.isOpen&&p[e].apply(p,Array.prototype.slice.call(arguments,1));else e=$.extend(!0,{},e),m?t.data("magnificPopup",e):t[0].magnificPopup=e,p.addGroup(t,e);return t};var _="inline",S,P,O,z=function(){O&&(P.after(O.addClass(S)).detach(),O=null)};$.magnificPopup.registerModule(_,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){p.types.push(_),b(e+"."+_,function(){z()})},getInline:function(e,t){if(z(),e.src){var n=p.st.inline,i=$(e.src);if(i.length){var o=i[0].parentNode;o&&o.tagName&&(P||(S=n.hiddenClass,P=I(S),S="mfp-"+S),O=i.after(P).detach().removeClass(S)),p.updateStatus("ready")}else p.updateStatus("error",n.tNotFound),i=$("<div>");return e.inlineElement=i,i}return p.updateStatus("ready"),p._parseMarkup(t,{},e),t}}});var M="ajax",B,F=function(){B&&$(document.body).removeClass(B)},H=function(){F(),p.req&&p.req.abort()};$.magnificPopup.registerModule(M,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){p.types.push(M),B=p.st.ajax.cursor,b(e+"."+M,H),b("BeforeChange."+M,H)},getAjax:function(e){B&&$(document.body).addClass(B),p.updateStatus("loading");var t=$.extend({url:e.src,success:function(t,n,i){var o={data:t,xhr:i};x("ParseAjax",o),p.appendContent($(o.data),M),e.finished=!0,F(),p._setFocus(),setTimeout(function(){p.wrap.addClass(c)},16),p.updateStatus("ready"),x("AjaxContentAdded")},error:function(){F(),e.finished=e.loadError=!0,p.updateStatus("error",p.st.ajax.tError.replace("%url%",e.src))}},p.st.ajax.settings);return p.req=$.ajax(t),""}}});var L,A=function(e){if(e.data&&void 0!==e.data.title)return e.data.title;var t=p.st.image.titleSrc;if(t){if($.isFunction(t))return t.call(p,e);if(e.el)return e.el.attr(t)||""}return""};$.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var t=p.st.image,n=".image";p.types.push("image"),b(r+n,function(){"image"===p.currItem.type&&t.cursor&&$(document.body).addClass(t.cursor)}),b(e+n,function(){t.cursor&&$(document.body).removeClass(t.cursor),h.off("resize"+l)}),b("Resize"+n,p.resizeImage),p.isLowIE&&b("AfterChange",p.resizeImage)},resizeImage:function(){var e=p.currItem;if(e&&e.img&&p.st.image.verticalFit){var t=0;p.isLowIE&&(t=parseInt(e.img.css("padding-top"),10)+parseInt(e.img.css("padding-bottom"),10)),e.img.css("max-height",p.wH-t)}},_onImageHasSize:function(e){e.img&&(e.hasSize=!0,L&&clearInterval(L),e.isCheckingImgSize=!1,x("ImageHasSize",e),e.imgHidden&&(p.content&&p.content.removeClass("mfp-loading"),e.imgHidden=!1))},findImageSize:function(e){var t=0,n=e.img[0],i=function(o){L&&clearInterval(L),L=setInterval(function(){return n.naturalWidth>0?void p._onImageHasSize(e):(t>200&&clearInterval(L),t++,void(3===t?i(10):40===t?i(50):100===t&&i(500)))},o)};i(1)},getImage:function(e,t){var n=0,i=function(){e&&(e.img[0].complete?(e.img.off(".mfploader"),e===p.currItem&&(p._onImageHasSize(e),p.updateStatus("ready")),e.hasSize=!0,e.loaded=!0,x("ImageLoadComplete")):(n++,200>n?setTimeout(i,100):o()))},o=function(){e&&(e.img.off(".mfploader"),e===p.currItem&&(p._onImageHasSize(e),p.updateStatus("error",r.tError.replace("%url%",e.src))),e.hasSize=!0,e.loaded=!0,e.loadError=!0)},r=p.st.image,a=t.find(".mfp-img");if(a.length){var s=document.createElement("img");s.className="mfp-img",e.el&&e.el.find("img").length&&(s.alt=e.el.find("img").attr("alt")),e.img=$(s).on("load.mfploader",i).on("error.mfploader",o),s.src=e.src,a.is("img")&&(e.img=e.img.clone()),s=e.img[0],s.naturalWidth>0?e.hasSize=!0:s.width||(e.hasSize=!1)}return p._parseMarkup(t,{title:A(e),img_replaceWith:e.img},e),p.resizeImage(),e.hasSize?(L&&clearInterval(L),e.loadError?(t.addClass("mfp-loading"),p.updateStatus("error",r.tError.replace("%url%",e.src))):(t.removeClass("mfp-loading"),p.updateStatus("ready")),t):(p.updateStatus("loading"),e.loading=!0,e.hasSize||(e.imgHidden=!0,t.addClass("mfp-loading"),p.findImageSize(e)),t)}}});var j,N=function(){return void 0===j&&(j=void 0!==document.createElement("p").style.MozTransform),j};$.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(e){return e.is("img")?e:e.find("img")}},proto:{initZoom:function(){var n=p.st.zoom,i=".zoom",o;if(n.enabled&&p.supportsTransition){var r=n.duration,a=function(e){var t=e.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),i="all "+n.duration/1e3+"s "+n.easing,o={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},r="transition";return o["-webkit-"+r]=o["-moz-"+r]=o["-o-"+r]=o[r]=i,t.css(o),t},s=function(){p.content.css("visibility","visible")},l,c;b("BuildControls"+i,function(){if(p._allowZoom()){if(clearTimeout(l),p.content.css("visibility","hidden"),o=p._getItemToZoom(),!o)return void s();c=a(o),c.css(p._getOffset()),p.wrap.append(c),l=setTimeout(function(){c.css(p._getOffset(!0)),l=setTimeout(function(){s(),setTimeout(function(){c.remove(),o=c=null,x("ZoomAnimationEnded")},16)},r)},16)}}),b(t+i,function(){if(p._allowZoom()){if(clearTimeout(l),p.st.removalDelay=r,!o){if(o=p._getItemToZoom(),!o)return;c=a(o)}c.css(p._getOffset(!0)),p.wrap.append(c),p.content.css("visibility","hidden"),setTimeout(function(){c.css(p._getOffset())},16)}}),b(e+i,function(){p._allowZoom()&&(s(),c&&c.remove(),o=null)})}},_allowZoom:function(){return"image"===p.currItem.type},_getItemToZoom:function(){return p.currItem.hasSize?p.currItem.img:!1},_getOffset:function(e){var t;t=e?p.currItem.img:p.st.zoom.opener(p.currItem.el||p.currItem);var n=t.offset(),i=parseInt(t.css("padding-top"),10),o=parseInt(t.css("padding-bottom"),10);n.top-=$(window).scrollTop()-i;var r={width:t.width(),height:(m?t.innerHeight():t[0].offsetHeight)-o-i};return N()?r["-moz-transform"]=r.transform="translate("+n.left+"px,"+n.top+"px)":(r.left=n.left,r.top=n.top),r}}});var W="iframe",R="//about:blank",Z=function(e){if(p.currTemplate[W]){var t=p.currTemplate[W].find("iframe");t.length&&(e||(t[0].src=R),p.isIE8&&t.css("display",e?"block":"none"))}};$.magnificPopup.registerModule(W,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){p.types.push(W),b("BeforeChange",function(e,t,n){t!==n&&(t===W?Z():n===W&&Z(!0))}),b(e+"."+W,function(){Z()})},getIframe:function(e,t){var n=e.src,i=p.st.iframe;$.each(i.patterns,function(){return n.indexOf(this.index)>-1?(this.id&&(n="string"==typeof this.id?n.substr(n.lastIndexOf(this.id)+this.id.length,n.length):this.id.call(this,n)),n=this.src.replace("%id%",n),!1):void 0});var o={};return i.srcAction&&(o[i.srcAction]=n),p._parseMarkup(t,o,e),p.updateStatus("ready"),t}}});var q=function(e){var t=p.items.length;return e>t-1?e-t:0>e?t+e:e},D=function(e,t,n){return e.replace(/%curr%/gi,t+1).replace(/%total%/gi,n)};$.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var t=p.st.gallery,n=".mfp-gallery",i=Boolean($.fn.mfpFastClick);return p.direction=!0,t&&t.enabled?(y+=" mfp-gallery",b(r+n,function(){t.navigateByImgClick&&p.wrap.on("click"+n,".mfp-img",function(){return p.items.length>1?(p.next(),!1):void 0}),v.on("keydown"+n,function(e){37===e.keyCode?p.prev():39===e.keyCode&&p.next()})}),b("UpdateStatus"+n,function(e,t){t.text&&(t.text=D(t.text,p.currItem.index,p.items.length))}),b(o+n,function(e,n,i,o){var r=p.items.length;i.counter=r>1?D(t.tCounter,o.index,r):""}),b("BuildControls"+n,function(){if(p.items.length>1&&t.arrows&&!p.arrowLeft){var e=t.arrowMarkup,n=p.arrowLeft=$(e.replace(/%title%/gi,t.tPrev).replace(/%dir%/gi,"left")).addClass(u),o=p.arrowRight=$(e.replace(/%title%/gi,t.tNext).replace(/%dir%/gi,"right")).addClass(u),r=i?"mfpFastClick":"click";n[r](function(){p.prev()}),o[r](function(){p.next()}),p.isIE7&&(I("b",n[0],!1,!0),I("a",n[0],!1,!0),I("b",o[0],!1,!0),I("a",o[0],!1,!0)),p.container.append(n.add(o))}}),b(a+n,function(){p._preloadTimeout&&clearTimeout(p._preloadTimeout),p._preloadTimeout=setTimeout(function(){p.preloadNearbyImages(),p._preloadTimeout=null},16)}),void b(e+n,function(){v.off(n),p.wrap.off("click"+n),p.arrowLeft&&i&&p.arrowLeft.add(p.arrowRight).destroyMfpFastClick(),p.arrowRight=p.arrowLeft=null})):!1},next:function(){p.direction=!0,p.index=q(p.index+1),p.updateItemHTML()},prev:function(){p.direction=!1,p.index=q(p.index-1),p.updateItemHTML()},goTo:function(e){p.direction=e>=p.index,p.index=e,p.updateItemHTML()},preloadNearbyImages:function(){var e=p.st.gallery.preload,t=Math.min(e[0],p.items.length),n=Math.min(e[1],p.items.length),i;for(i=1;i<=(p.direction?n:t);i++)p._preloadItem(p.index+i);for(i=1;i<=(p.direction?t:n);i++)p._preloadItem(p.index-i)},_preloadItem:function(e){if(e=q(e),!p.items[e].preloaded){var t=p.items[e];t.parsed||(t=p.parseEl(e)),x("LazyLoad",t),"image"===t.type&&(t.img=$('<img class="mfp-img" />').on("load.mfploader",function(){t.hasSize=!0}).on("error.mfploader",function(){t.hasSize=!0,t.loadError=!0,x("LazyLoadError",t)}).attr("src",t.src)),t.preloaded=!0}}}});var K="retina";$.magnificPopup.registerModule(K,{options:{replaceSrc:function(e){return e.src.replace(/\.\w+$/,function(e){return"@2x"+e})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var e=p.st.retina,t=e.ratio;t=isNaN(t)?t():t,t>1&&(b("ImageHasSize."+K,function(e,n){n.img.css({"max-width":n.img[0].naturalWidth/t,width:"100%"})}),b("ElementParse."+K,function(n,i){i.src=e.replaceSrc(i,t)}))}}}}),function(){var e=1e3,t="ontouchstart"in window,n=function(){h.off("touchmove"+o+" touchend"+o)},i="mfpFastClick",o="."+i;$.fn.mfpFastClick=function(i){return $(this).each(function(){var r=$(this),a;if(t){var s,l,c,d,u,p;r.on("touchstart"+o,function(t){d=!1,p=1,u=t.originalEvent?t.originalEvent.touches[0]:t.touches[0],l=u.clientX,c=u.clientY,h.on("touchmove"+o,function(e){u=e.originalEvent?e.originalEvent.touches:e.touches,p=u.length,u=u[0],(Math.abs(u.clientX-l)>10||Math.abs(u.clientY-c)>10)&&(d=!0,n())}).on("touchend"+o,function(t){n(),d||p>1||(a=!0,t.preventDefault(),clearTimeout(s),s=setTimeout(function(){a=!1},e),i())})})}r.on("click"+o,function(){a||i()})})},$.fn.destroyMfpFastClick=function(){$(this).off("touchstart"+o+" click"+o),t&&h.off("touchmove"+o+" touchend"+o)}}(),T()});