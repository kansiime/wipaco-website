# Wipaco Investiments Limited - Website

WordPress + WooCommerce site for an industrial chemicals supplier in Kampala.
**Package 2 (Business Website):** product catalogue with categories and search, quote requests,
WhatsApp ordering, Google Map and SEO. Built so Package 3 (online payments) can be switched on later.

## Run it locally

```bash
docker compose up -d
```

| What | Where |
|---|---|
| Website | http://localhost:8088 |
| Admin panel | http://localhost:8088/wp-admin (login in `local/admin-login.txt`) |
| Test mailbox (quote emails) | http://localhost:8025 |

First-time setup on a fresh machine (after cloning):

```bash
# PDF library for quote request PDFs (not stored in git)
docker run --rm -v "$PWD/theme/wipaco":/app -w /app composer:2 install --no-dev --optimize-autoloader
docker compose up -d
docker compose run --rm -e ADMIN_PASS=choose-a-password cli sh /setup/install.sh
```

When uploading the theme to hosting, include the `theme/wipaco/vendor/` folder.

## Day-to-day tasks (admin panel)

| Task | Where |
|---|---|
| Add a product | **Products > Add New**: name, description, photo (*Product image*), category, then **Publish**. Put specs as a list in *Product short description*. |
| Show a price | In the product, fill *Regular price* (UGX). Empty = "Price on request". |
| Add a category | **Products > Categories** |
| Read quote requests | **Enquiries** (also emailed to the company address with a PDF attached). Each has a reference like `Q261022-67`. Open one for **Download PDF**, **Reply on WhatsApp** and **Reply by email** buttons. After sending the form, the customer gets an **Also send on WhatsApp** button with their request pre-written for the WhatsApp number. |
| Change phone / WhatsApp / email / hours / social links | **Appearance > Customize > Wipaco Contact Details** |
| Edit About / Request a Quote text | **Pages** |
| SEO title & description per product/page | Rank Math box under the editor |
| Product FAQs | **Product FAQs** box when editing a product: question on one line, answer below, blank line between questions |
| Write a guide | **Posts > Add New** (shown under Guides). Set a *Featured image*. |
| Switch on Google Analytics | Create a GA4 property, then paste the `G-...` ID in **Appearance > Customize > Wipaco Contact Details & Analytics**. WhatsApp, call, email clicks and quote requests are tracked as events. |
| Printable product list | `/product-list/`, always up to date; visitors click *Download PDF / Print* |

## Project layout

- `theme/wipaco/` - the custom theme (all design and behaviour)
- `setup/` - installer and starting content (products, pages, menu, SEO text)
- `local/` - local-only files: test mail config and admin login. **Do not upload to the live server.**

## Going live

1. Buy a domain (e.g. `wipaco.co.ug`) and WordPress hosting.
2. Move the site with the *All-in-One WP Migration* or *Duplicator* plugin.
3. Install *WP Mail SMTP* and connect a business email, so quote emails are delivered reliably.
4. Change the admin password; add an SSL certificate (https).
5. Submit `https://<domain>/sitemap_index.xml` in Google Search Console.
6. Create a **Google Business Profile** for the Johnson Street shop and link the website.

## Package 3 - online payments (later)

1. In `theme/wipaco/functions.php` set `WIPACO_CATALOGUE_MODE` to `false`.
2. Publish the Cart, Checkout and My Account pages (currently drafts).
3. Install a payment plugin: Flutterwave or Pesapal (MTN MoMo, Airtel Money, cards).
4. Enter prices on all products, set up delivery zones under **WooCommerce > Settings > Shipping**.
