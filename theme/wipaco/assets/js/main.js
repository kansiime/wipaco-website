// Mobile menu toggle, header shadow on scroll, and analytics events.
(function () {
	var toggle = document.querySelector('.nav-toggle');
	var nav = document.getElementById('site-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
		});
	}

	var header = document.querySelector('.site-header');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 10); };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	document.querySelectorAll('[data-print]').forEach(function (button) {
		button.addEventListener('click', function () { window.print(); });
	});

	// Google Analytics events (only sent when Analytics is switched on in the Customizer).
	function track(name, params) {
		if (typeof window.gtag === 'function') {
			window.gtag('event', name, params || {});
		}
	}
	// Share buttons: phone share sheet where supported, and copy link.
	document.querySelectorAll('.share').forEach(function (box) {
		var url = box.getAttribute('data-share-url');
		var title = box.getAttribute('data-share-title');
		var native = box.querySelector('[data-share-native]');
		if (native && navigator.share) {
			native.hidden = false;
			native.addEventListener('click', function () {
				navigator.share({ title: title, text: title, url: url }).then(function () {
					track('share', { method: 'device', content_type: 'page', item_id: location.pathname });
				}).catch(function () {});
			});
		}
		var copy = box.querySelector('[data-share-copy]');
		if (copy) {
			copy.addEventListener('click', function () {
				var done = function () {
					copy.classList.add('is-copied');
					copy.querySelector('.share__copied').textContent = 'Link copied';
					setTimeout(function () { copy.classList.remove('is-copied'); copy.querySelector('.share__copied').textContent = ''; }, 2000);
					track('share', { method: 'copy_link', content_type: 'page', item_id: location.pathname });
				};
				if (navigator.clipboard) {
					navigator.clipboard.writeText(url).then(done, function () { window.prompt('Copy this link:', url); });
				} else {
					window.prompt('Copy this link:', url);
				}
			});
		}
	});

	document.addEventListener('click', function (e) {
		var link = e.target.closest('a[href]');
		if (!link) return;
		var network = link.getAttribute('data-share-network');
		if (network) {
			track('share', { method: network, content_type: 'page', item_id: location.pathname });
			return;
		}
		var href = link.getAttribute('href');
		var where = { link_text: link.textContent.trim().slice(0, 60), page_path: location.pathname };
		if (href.indexOf('https://wa.me/') === 0) track('whatsapp_click', where);
		else if (href.indexOf('tel:') === 0) track('phone_click', where);
		else if (href.indexOf('mailto:') === 0) track('email_click', where);
	});
	if (new URLSearchParams(location.search).get('quote') === 'sent') {
		track('generate_lead', { method: 'quote_form', page_path: location.pathname });
	}
})();
