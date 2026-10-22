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
	document.addEventListener('click', function (e) {
		var link = e.target.closest('a[href]');
		if (!link) return;
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
