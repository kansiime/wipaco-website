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
	// Live product search: filters the product grid as the visitor types.
	// When the catalogue spans several pages, results are fetched from the server instead.
	(function () {
		var input = document.getElementById('product-search');
		var results = document.getElementById('shop-results');
		if (!input || !results) return;
		var form = input.form;
		var originalHTML = results.innerHTML;
		var paginated = !!results.querySelector('.woocommerce-pagination');
		var timer, trackTimer, controller;

		var empty = document.createElement('div');
		empty.className = 'search-empty';
		empty.hidden = true;
		empty.setAttribute('role', 'status');
		results.after(empty);

		function norm(s) {
			return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/\s+/g, ' ').trim();
		}
		function escapeHTML(s) {
			return s.replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; });
		}
		function cards() {
			return Array.prototype.slice.call(results.querySelectorAll('ul.products > li'));
		}
		function countEl() {
			var el = results.querySelector('.woocommerce-result-count');
			if (el) el.setAttribute('aria-live', 'polite');
			return el;
		}
		var originalCount = (countEl() || {}).textContent || '';

		function render(q, n) {
			var count = countEl();
			if (count) {
				if (!q) {
					count.textContent = originalCount;
				} else {
					var scope = form.dataset.scope;
					count.innerHTML = n + (n === 1 ? ' product matches ' : ' products match ') + '&ldquo;' + escapeHTML(q) + '&rdquo;' +
						(scope ? ' in ' + escapeHTML(scope) + ' &middot; <a href="' + form.dataset.all + '?s=' + encodeURIComponent(q) + '&post_type=product">Search all products</a>' : '');
				}
			}
			empty.hidden = !q || n > 0;
			if (q && n === 0) {
				var scope = form.dataset.scope;
				var wa = form.dataset.whatsapp + '?text=' + encodeURIComponent('Hello Wipaco, do you have ' + q + '? Quantity needed: ');
				var all = form.dataset.all + '?s=' + encodeURIComponent(q) + '&post_type=product';
				empty.innerHTML = scope
					? '<p><strong>No products match &ldquo;' + escapeHTML(q) + '&rdquo; in ' + escapeHTML(scope) + '.</strong></p>' +
						'<p class="search-empty__actions"><a class="btn btn--primary" href="' + escapeHTML(all) + '">Search all products</a></p>'
					: '<p><strong>No products match &ldquo;' + escapeHTML(q) + '&rdquo;.</strong> We may still be able to supply it - just ask.</p>' +
						'<p class="search-empty__actions"><a class="btn btn--whatsapp" href="' + escapeHTML(wa) + '" target="_blank" rel="noopener">Ask on WhatsApp</a> ' +
						'<a class="btn btn--primary" href="' + escapeHTML(form.dataset.quote) + '">Request a quote</a></p>';
			}
		}

		function filterLocal(q) {
			var terms = norm(q).split(' ').filter(Boolean);
			var n = 0;
			cards().forEach(function (li) {
				var show = terms.every(function (t) { return norm(li.textContent).indexOf(t) !== -1; });
				li.hidden = !show;
				if (show) n++;
				// Products whose name matches come first (CSS order keeps the DOM untouched).
				var title = li.querySelector('.woocommerce-loop-product__title');
				var named = title && terms.length && terms.every(function (t) { return norm(title.textContent).indexOf(t) !== -1; });
				li.style.order = named ? '-1' : '';
			});
			render(q, n);
		}

		function filterRemote(q) {
			if (controller) controller.abort();
			if (!q) { results.innerHTML = originalHTML; render('', 0); return; }
			controller = new AbortController();
			fetch(form.action + '?s=' + encodeURIComponent(q) + '&post_type=product', { signal: controller.signal })
				.then(function (r) { return r.text(); })
				.then(function (html) {
					var found = new DOMParser().parseFromString(html, 'text/html').getElementById('shop-results');
					results.innerHTML = found ? found.innerHTML : '';
					render(q, cards().length);
				})
				.catch(function () {});
		}

		input.addEventListener('input', function () {
			var q = input.value.trim();
			clearTimeout(timer);
			timer = setTimeout(function () { (paginated ? filterRemote : filterLocal)(q); }, paginated ? 300 : 80);
			clearTimeout(trackTimer);
			if (q.length >= 2) trackTimer = setTimeout(function () { track('search', { search_term: q }); }, 1500);
		});
		input.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') { input.value = ''; input.dispatchEvent(new Event('input')); }
		});
		// Results update as you type, so Enter shouldn't reload the page.
		form.addEventListener('submit', function (e) { e.preventDefault(); });

		if (input.value.trim() && !paginated) filterLocal(input.value.trim());
	})();

	if (new URLSearchParams(location.search).get('quote') === 'sent') {
		track('generate_lead', { method: 'quote_form', page_path: location.pathname });
	}
})();
