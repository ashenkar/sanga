window.us_native = (function(window, document, undefined)
{
	'use strict';

	var uid		 = 0,
		instances = [ ],
		networks	= { },
		widgets	 = { },
		rstate	= /^($|loaded|complete)/,
		euc		 = window.encodeURIComponent;

	var usnative = {

		settings: { },

		trim: function(str)
		{
			return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
		},

		hasClass: function(el, cn)
		{
			return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
		},

		addClass: function(el, cn)
		{
			if (!usnative.hasClass(el, cn)) {
				el.className = (el.className === '') ? cn : el.className + ' ' + cn;
			}
		},

		removeClass: function(el, cn)
		{
			el.className = usnative.trim(' ' + el.className + ' '.replace(' ' + cn + ' ', ' '));
		},

		extendObject: function(to, from, overwrite)
		{
			for (var prop in from) {
				var hasProp = to[prop] !== undefined;
				if (hasProp && typeof from[prop] === 'object') {
					usnative.extendObject(to[prop], from[prop], overwrite);
				} else if (overwrite || !hasProp) {
					to[prop] = from[prop];
				}
			}
		},

		getElements: function(context, cn)
		{
			var i	 = 0,
				el	= [ ],
				gcn = !!context.getElementsByClassName,
				all = gcn ? context.getElementsByClassName(cn) : context.getElementsByTagName('*');
			for (; i < all.length; i++) {
				if (gcn || usnative.hasClass(all[i], cn)) {
					el.push(all[i]);
				}
			}
			return el;
		},

		getDataAttributes: function(el, noprefix, nostr)
		{
			var i	= 0,
				str	= '',
				obj	= { },
				attr = el.attributes;
			for (; i < attr.length; i++) {
				var key = attr[i].name,
					val = attr[i].value;
				if (val.length && key.indexOf('data-') === 0) {
					if (noprefix) {
						key = key.substring(5);
					}
					if (nostr) {
						obj[key] = val;
					} else {
						str += euc(key) + '=' + euc(val) + '&';
					}
				}
			}
			return nostr ? obj : str;
		},

		copyDataAttributes: function(from, to, noprefix, nohyphen)
		{
			var attr = usnative.getDataAttributes(from, noprefix, true);
			for (var i in attr) {
				to.setAttribute(nohyphen ? i.replace(/-/g, '_') : i, attr[i]);
			}
		},

		createIframe: function(src, instance)
		{
			var iframe = document.createElement('iframe');
			iframe.style.cssText = 'overflow: hidden; border: none;';
			usnative.extendObject(iframe, { src: src, allowtransparency: 'true', frameborder: '0', scrolling: 'no' }, true);
			if (instance) {
				iframe.onload = iframe.onreadystatechange = function ()
				{
					if (rstate.test(iframe.readyState || '')) {
						iframe.onload = iframe.onreadystatechange = null;
						usnative.activateInstance(instance);
					}
				};
			}
			return iframe;
		},

		networkReady: function(name)
		{
			return networks[name] ? networks[name].loaded : undefined;
		},

		appendNetwork: function(network)
		{

			if (!network || network.appended) {
				return;
			}
			if (typeof network.append === 'function' && network.append(network) === false) {
				network.appended = network.loaded = true;
				usnative.activateAll(network);
				return;
			}

			if (network.script) {
				network.el = document.createElement('script');
				usnative.extendObject(network.el, network.script, true);
				network.el.async = true;
				network.el.onload = network.el.onreadystatechange = function()
				{
					if (rstate.test(network.el.readyState || '')) {
						network.el.onload = network.el.onreadystatechange = null;
						network.loaded = true;
						if (typeof network.onload === 'function' && network.onload(network) === false) {
							return;
						}
						usnative.activateAll(network);
					}
				};
				document.body.appendChild(network.el);
			}
			network.appended = true;
		},

		removeNetwork: function(network)
		{
			if (!usnative.networkReady(network.name)) {
				return false;
			}
			if (network.el.parentNode) {
				network.el.parentNode.removeChild(network.el);
			}
			return !(network.appended = network.loaded = false);
		},

		reloadNetwork: function(name)
		{
			var network = networks[name];
			if (network && usnative.removeNetwork(network)) {
				usnative.appendNetwork(network);
			}
		},

		createInstance: function(el, widget)
		{
			var proceed	= true,
				instance = {
					el		: el,
					uid	 : uid++,
					widget	: widget
				};
			instances.push(instance);
			if (widget.process !== undefined) {
				proceed = (typeof widget.process === 'function') ? widget.process(instance) : false;
			}
			if (proceed) {
				usnative.processInstance(instance);
			}
			instance.el.setAttribute('data-usnative', instance.uid);
			instance.el.className = 'usnative ' + widget.name + ' usnative-instance';
			return instance;
		},

		processInstance: function(instance)
		{
			var el = instance.el;
			instance.el = document.createElement('div');
			instance.el.className = el.className;
			usnative.copyDataAttributes(el, instance.el);
			// stop over-zealous scripts from activating all instances
			if (el.nodeName.toLowerCase() === 'a' && !el.getAttribute('data-default-href')) {
				instance.el.setAttribute('data-default-href', el.getAttribute('href'));
			}
			var parent = el.parentNode;
			parent.insertBefore(instance.el, el);
			parent.removeChild(el);
		},

		activateInstance: function(instance)
		{
			if (instance && !instance.loaded) {
				instance.loaded = true;
				if (typeof instance.widget.activate === 'function') {
					instance.widget.activate(instance);
				}
				usnative.addClass(instance.el, 'usnative-loaded');
				return instance.onload ? instance.onload(instance.el) : null;
			}
		},

		activateAll: function(network)
		{
			if (typeof network === 'string') {
				network = networks[network];
			}
			for (var i = 0; i < instances.length; i++) {
				var instance = instances[i];
				if (instance.init && instance.widget.network === network) {
					usnative.activateInstance(instance);
				}
			}
		},

		load: function(context, el, w, onload, process)
		{
			context = (context && typeof context === 'object' && context.nodeType === 1) ? context : document;

			if (!el || typeof el !== 'object') {
				usnative.load(context, usnative.getElements(context, 'usnative'), w, onload, process);
				return;
			}

			var i;

			if (/Array/.test(Object.prototype.toString.call(el))) {
				for (i = 0; i < el.length; i++) {
					usnative.load(context, el[i], w, onload, process);
				}
				return;
			}

			if (el.nodeType !== 1) {
				return;
			}

			if (!w || !widgets[w]) {
				w = null;
				var classes = el.className.split(' ');
				for (i = 0; i < classes.length; i++) {
					if (widgets[classes[i]]) {
						w = classes[i];
						break;
					}
				}
				if (!w) {
					return;
				}
			}

			var instance,
				widget = widgets[w],
				sid	= parseInt(el.getAttribute('data-usnative'), 10);
			if (!isNaN(sid)) {
				for (i = 0; i < instances.length; i++) {
					if (instances[i].uid === sid) {
						instance = instances[i];
						break;
					}
				}
			} else {
				instance = usnative.createInstance(el, widget);
			}

			if (process || !instance) {
				return;
			}

			if (!instance.init) {
				instance.init = true;
				instance.onload = (typeof onload === 'function') ? onload : null;
				widget.init(instance);
			}

			if (!widget.network.appended) {
				usnative.appendNetwork(widget.network);
			} else {
				if (usnative.networkReady(widget.network.name)) {
					usnative.activateInstance(instance);
				}
			}
		},

		activate: function(el, w, onload)
		{
			window.us_native.load(null, el, w, onload);
		},

		process: function(context, el, w)
		{
			window.us_native.load(context, el, w, null, true);
		},

		network: function(n, params)
		{
			networks[n] = {
				name	 : n,
				el		 : null,
				appended : false,
				loaded	 : false,
				widgets	: { }
			};
			if (params) {
				usnative.extendObject(networks[n], params);
			}
		},

		widget: function(n, w, params)
		{
			params.name = n + '-' + w;
			if (!networks[n] || widgets[params.name]) {
				return;
			}
			params.network = networks[n];
			networks[n].widgets[w] = widgets[params.name] = params;
		},

		setup: function(params)
		{
			usnative.extendObject(usnative.settings, params, true);
		}

	};

	return usnative;

})(window, window.document);

(function() {
	var s = window._usnative;
	if (/Array/.test(Object.prototype.toString.call(s))) {
		for (var i = 0, len = s.length; i < len; i++) {
			if (typeof s[i] === 'function') {
				s[i]();
			}
		}
	}
})();

(function(window, document, us_native, undefined){

	us_native.setup({
		googleplus: {
			lang: 'en-GB',
			onstartinteraction : function(el, e) {
				if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
					ga('send', 'social', 'GooglePlus', '+1', url);
				}
			}
		}
	});

	us_native.network('googleplus', {
		script: {
			src: '//apis.google.com/js/plusone.js'
		},
		append: function(network)
		{
			if (window.gapi) {
				return false;
			}
			window.___gcfg = {
				lang: us_native.settings.googleplus.lang,
				parsetags: 'explicit'
			};
		}
	});

	var googleplusInit = function(instance)
	{
		var el = document.createElement('div');
		el.className = 'g-' + instance.widget.gtype;
		us_native.copyDataAttributes(instance.el, el);
		instance.el.appendChild(el);
		instance.gplusEl = el;
	};

	var googleplusEvent = function(instance, callback) {
		return (typeof callback !== 'function') ? null : function(data) {
			callback(instance.el, data);
		};
	};

	var googleplusActivate = function(instance)
	{
		var type = instance.widget.gtype;
		if (window.gapi && window.gapi[type]) {
			var settings = us_native.settings.googleplus,
				params	 = us_native.getDataAttributes(instance.el, true, true),
				events	 = ['onstartinteraction', 'onendinteraction', 'callback'];
			for (var i = 0; i < events.length; i++) {
				params[events[i]] = googleplusEvent(instance, settings[events[i]]);
			}
			window.gapi[type].render(instance.gplusEl, params);
		}
	};

	us_native.widget('googleplus', 'one',	 { init: googleplusInit, activate: googleplusActivate, gtype: 'plusone' });
	us_native.widget('googleplus', 'share', { init: googleplusInit, activate: googleplusActivate, gtype: 'plus' });
	us_native.widget('googleplus', 'badge', { init: googleplusInit, activate: googleplusActivate, gtype: 'plus' });

})(window, window.document, window.us_native);

(function(window, document, us_native, undefined){

	us_native.setup({
		facebook: {
			lang: 'en_US',
			appId: us_native_script.facebook_appid,
			onlike	 : function(url) {
				if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
					ga('send', 'social', 'facebook', 'like', url);
				}
			},
			onunlike : function(url) {
				if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
					ga('send', 'social', 'facebook', 'unlike', url);
				}
			}
		}
	});

	us_native.network('facebook', {
		script: {
			src : '//connect.facebook.net/{{language}}/sdk.js',
			id	: 'facebook-jssdk'
		},
		append: function(network)
		{
			var fb		 = document.createElement('div'),
				settings = us_native.settings.facebook,
				events	 = {
					onlike: 'edge.create',
					onunlike: 'edge.remove',
					onsend: 'message.send' ,
					oncomment: 'comment.create',
					onuncomment: 'comment.remove'
				};
			fb.id = 'fb-root';
			document.body.appendChild(fb);
			network.script.src = network.script.src.replace('{{language}}', settings.lang);
			window.fbAsyncInit = function() {
				window.FB.init({
						appId: settings.appId,
						xfbml: true,
						version: 'v2.2'
				});
				for (var e in events) {
					if (typeof settings[e] === 'function') {
						window.FB.Event.subscribe(events[e], settings[e]);
					}
				}
			};
		}
	});

	us_native.widget('facebook', 'like', {
		init: function(instance)
		{
			var el = document.createElement('div');
			el.className = 'fb-like';
			us_native.copyDataAttributes(instance.el, el);
			instance.el.appendChild(el);
			if (window.FB && window.FB.XFBML) {
				window.FB.XFBML.parse(instance.el);
			}
		}
	});

})(window, window.document, window.us_native);

(function(window, document, us_native, undefined){

	var VKCallbacks = [];
	us_native.setup({
		vkontakte: {
			apiId: us_native_script.vkontakte_appid,
			group: {
				id: 0,
				mode: 0,
				width: 48,
				height: 20
			},
			like: {
				type: 'mini',
				pageUrl: null
			}
		}
	});

	us_native.network('vkontakte', {
		script: {
			src : '//vk.com/js/api/openapi.js?105',
			id	: 'vk-jsapi'
		},
		onload: function(network) {
			 var settings = us_native.settings.vkontakte;
			 VK.init({apiId: settings.apiId, onlyWidgets: true});
			 for (var i = 0, i$l = VKCallbacks.length; i < i$l; VKCallbacks[i].call(this), i++);
		}
	});

	var extendConfWithAttributes = function(el, attributes, original) {
		var result = {}, key;
		for (var k = 0, k$l = attributes.length; k < k$l; key = attributes[k], result[key] = el.getAttribute('data-' + key) || original[key], k++);
		return result;
	}

	us_native.widget('vkontakte', 'like', {
		init: function(instance)
		{
			if (typeof window.VK !== 'object') VKCallbacks.push(function(){
				var el		 = document.createElement('div'),
					settings = us_native.settings.vkontakte;
				el.className = 'vk-like';
				el.id = 'vkontakte-like-' + (new Date()).getTime() + Math.random().toString().replace('.', '-');
				us_native.copyDataAttributes(instance.el, el);
				like = extendConfWithAttributes(instance.el, ['pageUrl', 'type'], settings.like);
				instance.el.appendChild(el);
				VK.Widgets.Like(el.id, like);
			});
		}
	});

})(window, window.document, window.us_native);