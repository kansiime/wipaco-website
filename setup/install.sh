#!/bin/sh
# Runs inside the wp-cli container:  docker compose run --rm -e ADMIN_PASS=... cli sh /setup/install.sh
set -e
cd /var/www/html

echo "Waiting for database..."
until wp db query "SELECT 1" >/dev/null 2>&1; do sleep 2; done

if ! wp core is-installed 2>/dev/null; then
	wp core install \
		--url="${SITE_URL:-http://localhost:8088}" \
		--title="Wipaco Investiments Limited" \
		--admin_user=wipaco-admin \
		--admin_password="$ADMIN_PASS" \
		--admin_email=sales@wipacoinvestiments.com \
		--skip-email
fi

wp option update blogdescription "Industrial Chemicals Supplier in Kampala, Uganda"
wp option update timezone_string "Africa/Kampala"
wp option update date_format "j F Y"
wp option update default_comment_status closed
wp option update default_ping_status closed
wp rewrite structure '/%postname%/'

wp plugin delete akismet hello >/dev/null 2>&1 || true
wp plugin install woocommerce seo-by-rank-math --activate
wp theme activate wipaco
for t in twentytwentythree twentytwentyfour; do wp theme delete "$t" >/dev/null 2>&1 || true; done

wp post delete 1 2 --force >/dev/null 2>&1 || true

wp eval-file /setup/content.php
wp rewrite flush --hard
echo "Done."
