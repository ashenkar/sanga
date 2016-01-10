jQuery(document).ready(function() {

	jQuery('.us_mail_send').on('click', function(){
		jQuery('.us_mail_response').addClass('alert alert-info').html(us_script.trying);
		us_mail_send();
	});

	function us_mail_send() {

		var your_name = jQuery('.us_mail_your_name').val(),
		url = jQuery('.us_mail_url').val(),
		your_email = jQuery('.us_mail_your_email').val(),
		recipient_email = jQuery('.us_mail_recipient_email').val(),
		message = jQuery('.us_mail_message').val(),
		captcha = jQuery('.us_mail_captcha').val();

		jQuery.ajax({
			type: 'POST',
			url: us_script.ajaxurl,
			data: {
				action: 'us_send_mail',
				url: url,
				your_name: your_name,
				your_email: your_email,
				recipient_email: recipient_email,
				message: message,
				captcha: captcha,
				nonce : us_script.nonce
			},

			success: function(response) {

				var responseElement = jQuery('.us_mail_response');
				var us_mail_form = jQuery('.us_mail_form_holder');

				responseElement
				.hide()
				.removeClass('alert alert-danger alert-info alert-success');

				if (response === "ok") {
					responseElement
					.fadeIn().addClass('alert alert-success').html(us_script.success);

					us_mail_form
					.html('');

					setTimeout(function() {
						jQuery('.us_modal');
						jQuery.magnificPopup.instance.close();
					}, 2000);
				} else {
					responseElement
					.fadeIn()
					.html(response)
					.addClass('alert alert-danger');
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown);
			}

		});

	}

	jQuery('.us_pinterest').find('a').click(function() {
		var a_href = jQuery(this).attr('href');
        jQuery.magnificPopup.open({
        	items: {
                src: a_href,
            },
			type:'inline',
			midClick: true,
			removalDelay: 300,
			mainClass: 'us_pinterest_fade us_wrapper'
		});
		return false;
	});

	jQuery('.us_mail').find('a').click(function() {
		var a_href = jQuery(this).attr('href');
        jQuery.magnificPopup.open({
        	items: {
                src: a_href,
            },
			type:'inline',
			midClick: true,
			removalDelay: 300,
			mainClass: 'us_mail_fade us_wrapper'
		});
		return false;
	});

	jQuery('.us_more').find('a').click(function() {
		var a_href = jQuery(this).attr('href');
        jQuery.magnificPopup.open({
        	items: {
                src: a_href,
            },
			type:'inline',
			midClick: true,
			removalDelay: 300,
			mainClass: 'us_more_fade us_wrapper'
		});
		return false;
	});


	jQuery('.us_love').each(function() {

		var count = jQuery(this).find('.us_count').text();
		var countLong = parseInt(long_num(count));
		var countLongPlus = countLong + 1;
		var shortPlus = short_num(countLongPlus);

		var url = jQuery(this).parent().data('url');

		jQuery(this).find('a').one('click', function() {

			var data = {
				action: 'us_love',
				url: url,
				nonce: us_script.nonce
			};

			// don't allow the user to love the item more than once
			if(jQuery(this).hasClass('loved')) {
				alert(us_script.already_loved_message);
				return false;
			}

			if( jQuery.cookie('us_love_count_' + url)) {
				alert(us_script.already_loved_message);
				return false;
			}

			jQuery.ajax({
				type: "POST",
				data: data,
				url: us_script.ajaxurl,
				context: this,
				success: function( response ) {
					if( response ) {
						jQuery(this).addClass('loved');
						jQuery('.us_love').each(function() {
							if (jQuery(this).parent().data('url') === url) {
								jQuery(this).find('.us_count').text(shortPlus);
							}
							jQuery.cookie('us_love_count_' + url, 'yes', { expires: 365 });
						});
						jQuery('.us_total').each(function() {
							if(jQuery(this).parent().data('url') === url ) {
								var countTotal = jQuery(this).find('.us_count').text();
								var countTotalLong = parseInt(long_num(countTotal));
								var countTotalLongPlus = countTotalLong + 1;
								var shortTotalPlus = short_num(countTotalLongPlus);
								jQuery(this).find('.us_count').text(shortTotalPlus);
							}
						});
					} else {
						alert(us_script.already_loved_message);
					}
				}
			}).fail(function () {
				alert(us_script.error_message);
			});
			return false;
		});
	});

	var popup = {
		google: function(opt){
			PopupCenter("https://plus.google.com/share?url="+encodeURIComponent(opt.url), 'google', us_script.googleplus_width, us_script.googleplus_height );
		},
		facebook: function(opt){
			PopupCenter("http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(opt.url)+"&t="+opt.text, 'facebook', us_script.facebook_width, us_script.facebook_height );
		},
		twitter: function(opt){
			get_short_url(opt.url, function( short_url ) {
				PopupCenter("https://twitter.com/intent/tweet?text="+encodeURIComponent(opt.text)+"&url="+encodeURIComponent(short_url)+(us_script.tweet_via !== '' ? '&via='+us_script.tweet_via : ''), 'twitter', us_script.twitter_width, us_script.twitter_height );
			});
		},
		delicious: function(opt){
			PopupCenter('http://www.delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent(opt.url)+'&title='+opt.text, 'delicious', us_script.delicious_width, us_script.delicious_height );
		},
		stumble: function(opt){
			PopupCenter('http://www.stumbleupon.com/badge/?url='+encodeURIComponent(opt.url), 'stumble', us_script.stumble_width, us_script.stumble_height );
		},
		linkedin: function(opt){
			PopupCenter('https://www.linkedin.com/cws/share?url='+encodeURIComponent(opt.url)+'&token=&isFramed=true', 'linkedin', us_script.linkedin_width, us_script.linkedin_height );
		},
		pinterest: function(opt){
			PopupCenter("http://pinterest.com/pin/create/button/?url="+encodeURIComponent(opt.url)+"&media="+encodeURIComponent(opt.media)+"&description="+encodeURIComponent(opt.text), 'pinterest', us_script.pinterest_width, us_script.pinterest_height );
		},
		buffer: function(opt){
			get_short_url(opt.url, function( short_url ) {
				PopupCenter('http://bufferapp.com/add?url='+encodeURIComponent(short_url)+'&text='+encodeURIComponent(opt.text)+(us_script.tweet_via !== '' ? '&via='+us_script.tweet_via : '')+'&picture='+encodeURIComponent(opt.media), 'buffer', us_script.buffer_width, us_script.buffer_height );
			});
		},
		reddit: function(opt){
			PopupCenter('http://reddit.com/submit?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'reddit', us_script.reddit_width, us_script.reddit_height );
		},
		vkontakte: function(opt){
			PopupCenter('http://vkontakte.ru/share.php?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text)+'&image='+encodeURIComponent(opt.media), 'vkontakte', us_script.vkontakte_width, us_script.vkontakte_height );
		},
		print: function(opt){
			PopupCenter('http://www.printfriendly.com/print/?url='+encodeURIComponent(opt.url), 'printfriendly', us_script.printfriendly_width, us_script.printfriendly_height );
		},
		pocket: function(opt){
			PopupCenter('https://getpocket.com/edit.php?url='+encodeURIComponent(opt.url), 'pocket', us_script.pocket_width, us_script.pocket_height );
		},
		tumblr: function(opt){
			PopupCenter('http://tumblr.com/share?s=&v=3&u='+encodeURIComponent(opt.url)+'&t='+encodeURIComponent(opt.text), 'tumblr', us_script.tumblr_width, us_script.tumblr_height );
		},
		flipboard: function(opt){
			PopupCenter('https://share.flipboard.com/bookmarklet/popout?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'flipboard', us_script.flipboard_width, us_script.flipboard_height );
		},
		ok: function(opt){
			PopupCenter('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'ok', us_script.ok_width, us_script.ok_height );
		},
		weibo: function(opt){
			PopupCenter('http://service.weibo.com/share/share.php?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'weibo', us_script.weibo_width, us_script.weibo_height );
		},
		xing: function(opt){
			PopupCenter('https://www.xing.com/social_plugins/share?h=1&url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'xing', us_script.xing_width, us_script.xing_height );
		},
		managewp: function(opt){
			PopupCenter('http://managewp.org/share/form?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'managewp', us_script.managewp_width, us_script.managewp_height );
		},
		whatsapp: function(opt){
			PopupCenter('whatsapp://send?text='+encodeURIComponent(opt.url)+' '+encodeURIComponent(opt.text), 'whatsapp', us_script.whatsapp_width, us_script.whatsapp_height );
		},
		meneame: function(opt){
			PopupCenter('http://www.meneame.net/submit.php?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'meneame', us_script.meneame_width, us_script.meneame_height );
		},
		digg: function(opt){
			PopupCenter('http://digg.com/submit?url='+encodeURIComponent(opt.url)+'&title='+encodeURIComponent(opt.text), 'digg', us_script.digg_width, us_script.digg_height );
		}
	};

	function openPopup (site, opt) {
		popup[site](opt);
		if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
			var tracking = {
				google: {site: 'GooglePlus', action: 'share'},
				facebook: {site: 'Facebook', action: 'share'},
				twitter: {site: 'Twitter', action: 'tweet'},
				delicious: {site: 'Delicious', action: 'add'},
				stumble: {site: 'Stumbleupon', action: 'add'},
				linkedin: {site: 'Linkedin', action: 'share'},
				pinterest: {site: 'Pinterest', action: 'pin'},
				buffer: {site: 'Buffer', action: 'share'},
				reddit: {site: 'Reddit', action: 'share'},
				vkontakte: {site: 'Vkontakte', action: 'share'},
				print: {site: 'Printfriendly', action: 'print'},
				pocket: {site: 'Pocket', action: 'share'},
				tumblr: {site: 'Tumblr', action: 'share'},
				ok: {site: 'Odnoklassniki', action: 'share'},
				weibo: {site: 'Weibo', action: 'share'},
				xing: {site: 'Xing', action: 'share'},
				managewp: {site: 'ManageWP', action: 'share'},
				whatsapp: {site: 'WhatsApp', action: 'share'},
				meneame: {site: 'Meneame', action: 'share'},
				flipboard: {site: 'Flipboard', action: 'share'},
				digg: {site: 'Digg', action: 'share'}
			};
			ga('send', 'social', tracking[site].site, tracking[site].action);
		}
	}

	/* Potition popups center
	================================================== */
	function PopupCenter(url, title, w, h) {
	// Fixes dual-screen position						 Most browsers		Firefox
		var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

		var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = ((width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((height / 2) - (h / 2)) + dualScreenTop;
		var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
			newWindow.focus();
		}
	}

	function get_short_url(longUrl, callback) {
		if (us_script.bitly === 'true') {
			jQuery.ajax({
				url : us_script.ajaxurl,
				dataType : "json",
				type : "POST",
				data : {
					url : longUrl,
					action : 'us_bitly',
					nonce : us_script.nonce
				},
				async: false,
				success : function(response) {
					if(response.status_txt === "OK"){
						callback( response.data.url );
					} else {
						callback( longUrl );
					}
				},
				error : function() {
					callback( longUrl );
				}
			});
		} else {
			callback( longUrl );
		}
	}

	var opt = [];
	jQuery('.us_button').each(function() {

		if(jQuery(this).hasClass('us_native')) {
			jQuery(this).mouseover(function() {
				us_native.load(this);
			});
		}

		var networkClass = jQuery(this).attr("class").split(' ');
		var network = networkClass[0].substring(3);

		if (network !== 'comments' && network !== 'love' && network !== 'pinterest' && network !== 'more') {
			jQuery(this).find('a').one('click', function() {

				var u = jQuery(this).parent().parent().data('url');

				var count = jQuery(this).find('.us_count').text();
				var countLong = parseInt(long_num(count));
				var countLongPlus = countLong + 1;
				var shortPlus = short_num(countLongPlus);

				jQuery('.us_'+network).each(function() {
					if (!jQuery(this).hasClass('us_no_count') && jQuery(this).parent().data('url') === u) {
						jQuery(this).find('.us_count').text(shortPlus);
					}
				});
				if (!jQuery(this).parent().hasClass('us_no_count')) {
					jQuery('.us_total').each(function() {
						if(jQuery(this).parent().data('url') === u ) {
							var countTotal = jQuery(this).find('.us_count').text();
							var countTotalLong = parseInt(long_num(countTotal));
							var countTotalLongPlus = countTotalLong + 1;
							var shortTotalPlus = short_num(countTotalLongPlus);
							jQuery(this).find('.us_count').text(shortTotalPlus);
						}
					});
				}
				return false;
			});
			jQuery(this).find('a').on('click', function() {
				var url = jQuery(this).parent().parent().data('url');
				var text = jQuery(this).parent().parent().data('text');
				var media = jQuery(this).parent().data('media');

				opt.url = url;
				opt.text = text;

				if (media) {
					opt.media = media;
				}
				if (network !== 'comments' && network !== 'love' && network !== 'more') {
					openPopup(network, opt);
					return false;
				}
			});
		}
	});

	var pinopt = [];
	jQuery('.us_pinterest_image_holder').each(function() {

		var url = jQuery(this).parent().parent().data('url');
		var text = jQuery(this).parent().parent().data('text');

		jQuery(this).find('a').one('click', function() {

			jQuery('.us_pinterest').each(function() {
				var count = jQuery(this).find('.us_count').text();
				var countLong = parseInt(long_num(count));
				var countLongPlus = countLong + 1;
				var shortPlus = short_num(countLongPlus);
				if (!jQuery(this).hasClass('us_no_count') && jQuery(this).parent().data('url') === url) {
					jQuery(this).find('.us_count').text(shortPlus);
				}
			});
			if (!jQuery(this).parent().hasClass('us_no_count')) {
				jQuery('.us_total').each(function() {
					if(jQuery(this).parent().data('url') === url ) {
						var countTotal = jQuery(this).find('.us_count').text();
						var countTotalLong = parseInt(long_num(countTotal));
						var countTotalLongPlus = countTotalLong + 1;
						var shortTotalPlus = short_num(countTotalLongPlus);
						jQuery(this).find('.us_count').text(shortTotalPlus);
					}
				});
			}
			return false;
		});

		jQuery(this).find('a').on('click', function() {

			var media = jQuery(this).find('img').attr('src');

			pinopt.url = url;
			pinopt.text = text;
			pinopt.media = media;
			openPopup('pinterest', pinopt);
			return false;
		});
	});

	function union_arrays (x, y) {
		var obj = {};
		for (var i = x.length-1; i >= 0; -- i) {
			obj[x[i]] = x[i];
		}
		for (var j = y.length-1; j >= 0; -- j) {
			obj[y[j]] = y[j];
		}
		var res = [];
		for (var k in obj) {
			if (obj.hasOwnProperty(k)) {
				res.push(obj[k]);
			}
		}
		return res;
	}

	function long_num (num) {
		var base = parseFloat( num );
		if ( num.match( /k/ ) ){
			return Math.round( base * 1000 );
		} else if ( num.match( /M/ ) ) {
			return Math.round( base * 1000000 );
		} else if ( num.match( /B/ ) ) {
			return Math.round( base * 1000000000 );
		} else {
			return Math.round( num );
		}
	}

	function short_num (num) {
		if (num >= 1e9){
			num = (num / 1e9).toFixed(1) + "B";
		} else if (num >= 1e6){
			num = (num / 1e6).toFixed(1) + "M";
		} else if (num >= 1e3){
			num = (num / 1e3).toFixed(1) + "k";
		}
		return num;
	}

	var urls = [];
	var jsonObj = {};
	var dataAttributes = {};
	jQuery('.us_share_buttons').each(function(){
		if(jQuery(this).data('ajaxnetworks')) {
			var dataAjaxNetworks = jQuery(this).data('ajaxnetworks');
			var ajaxnetworks = dataAjaxNetworks.split(',');
			var url = jQuery(this).data('url');

			if (dataAjaxNetworks) {
				if ( ! (url in dataAttributes) ) {
					dataAttributes[url] = [];
					urls.push({
						"url" : url,
						"networks"	: ajaxnetworks
					});
				} else {
					for( var x in urls) {
						if (url === urls[x].url) {
							urls[x].networks = union_arrays(urls[x].networks, ajaxnetworks);
						}
					}
				}
			}
		}
	});
	jsonObj.urls = urls;
	if (jsonObj.urls.length > 0) {
		jQuery.ajax({
			type: "POST",
			//the url where you want to sent the userName and password to
			url: us_script.ajaxurl,
			//json object to sent to the authentication url
			data: 'action=us_counts&nonce='+ us_script.nonce +'&args=' + JSON.stringify(jsonObj),
			success: function (data) {
				if (data) {
					for (var url in data){
						if (data.hasOwnProperty(url)) {
							jQuery('.us_share_buttons').each(function(){
								var dataurl = jQuery(this).data('url');
								jQuery(this).find(".us_button").each(function(){
									var buttonclass = jQuery(this).attr("class").split(' ');
									if (buttonclass[0].substring(3) in data[url] && dataurl === url ) {
										jQuery(this).find(".us_count").html(short_num(data[url][buttonclass[0].substring(3)].count));
									}
								});
							});
						}
					}
				};
			}
		});
	}
	var jsonObj = {};
	var networks = '';
	jQuery('.us_fan_count_wrapper').each(function(){
		if(jQuery(this).data('ajaxnetworks')) {
			networks = (networks) ? networks + ',' + jQuery(this).data('ajaxnetworks'): jQuery(this).data('ajaxnetworks');
		}
		jQuery('.us_fan_count_desc').fitText(0.7);
		jQuery('.us_fan_count_holder').fitText(0.5);
		jQuery('.us_fan_count_icon_holder').fitText(0.4);
	});
	jsonObj.networks = networks;
	if (jsonObj.networks.length > 0) {
		jQuery.ajax({
			type: "POST",
			//the url where you want to sent the userName and password to
			url: us_script.ajaxurl,
			//json object to sent to the authentication url
			data: 'action=us_fan_counts&nonce='+ us_script.nonce + '&args=' + JSON.stringify(jsonObj),
			success: function (data) {
				if (data) {
					jQuery('.us_fan_count_wrapper').each(function(){
						jQuery(this).find(".us_fan_count").each(function(){
							var buttonType = jQuery(this).data("network");
							if (buttonType in data) {
								jQuery(this).find(".us_fan_count_holder").html(short_num(data[buttonType].count));
							}
						});
					});
				};
			}
		});
	}
});