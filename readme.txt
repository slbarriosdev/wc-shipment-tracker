=== WC Shipment Tracker ===
Contributors: slbarriosdev
Tags: woocommerce tracking, shipment tracking, order tracking, shipping tracker, tracking number
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add shipment tracking numbers to WooCommerce orders. Supports 60+ carriers worldwide. Tracking info shown in emails, My Account, and the order admin panel.

== Description ==

**WC Shipment Tracker** is the easiest way to add shipment tracking to your WooCommerce store. Let your customers follow their packages in real time — directly from their order confirmation email or their My Account page — without contacting you.

Stop answering "Where is my order?" emails. Give customers a one-click tracking link the moment their order ships.

= Key Features =

* **Add multiple tracking numbers per order** — perfect for split shipments
* **60+ pre-built shipping carriers** across 20+ countries (UPS, FedEx, USPS, DHL, Royal Mail, Australia Post, Correos, and many more)
* **Custom carrier support** — use any carrier not on the list by entering a custom tracking URL
* **Tracking info in order emails** — automatically added before the order table in WooCommerce transactional emails
* **My Account integration** — customers see their tracking link on the order detail page
* **Admin orders list column** — see tracking numbers at a glance in the WooCommerce orders list, with carrier favicon for quick identification
* **Inline meta box** — add, edit, and delete tracking items directly from the order edit screen without leaving the page
* **REST API** — full CRUD API (`wc-shipment-tracker/v1`) compatible with WooCommerce API namespaces `wc/v1` and `wc/v2`
* **Shortcode** — display tracking info anywhere with `[wcst_tracking]`
* **WooCommerce HPOS compatible** — fully supports High-Performance Order Storage (custom order tables)
* **WooCommerce Blocks compatible**
* **WooCommerce Subscriptions compatible** — prevents tracking numbers from being copied to renewal orders
* **Developer-friendly** — helper functions (`wcst_add_tracking()`, `wcst_delete_tracking()`) and filter hooks for full customization

= Supported Carriers =

**United States:** UPS, FedEx, USPS, DHL US, DHL eCommerce, FedEx Sameday, GlobalPost, OnTrac
**United Kingdom:** Royal Mail, DHL, DPD, DPD Local, EVRi, ParcelForce, TNT Express, DHL Parcel UK, City Link
**Spain:** Correos España, MRW, SEUR, GLS Spain, Nacex, DHL Spain, UPS Spain, DPD Spain, ASM, Correos Express, Zeleris, TNT Spain
**Mexico:** DHL Mexico, FedEx Mexico, UPS Mexico, Estafeta, Paquetexpress, Redpack, Correos de Mexico, Coordinadora, J&T Express
**Colombia:** Servientrega, Coordinadora CO, Deprisa, TCC, DHL Colombia, J&T Express CO, Interrapidisimo
**Germany:** DHL Intraship, Deutsche Post DHL, Hermes, UPS Germany, DPD.de
**Australia:** Australia Post, Fastway Couriers, Aramex Australia
**Canada:** Canada Post, Purolator
**Netherlands:** PostNL, DPD.NL, UPS Netherlands
**Sweden:** PostNord, DHL.se, Bring.se, UPS.se, DB Schenker
**Poland:** InPost, DPD.PL, Poczta Polska
**New Zealand:** NZ Post, Courier Post, Aramex New Zealand
**Romania:** Fan Courier, DPD Romania, Urgent Cargus
**Italy:** BRT (Bartolini), DHL Express
**Ireland:** DPD.ie, An Post
**Czech Republic:** PPL.cz, Česká pošta, DHL.cz, DPD.cz
**France:** Colissimo
**Belgium:** bpost
**Brazil:** Correios
**Austria:** post.at, dhl.at, DPD.at
**South Africa:** SAPO, Fastway, EPX
**Finland:** Itella
**India:** DTDC
**Global:** Aramex

Don't see your carrier? Add it as a custom provider with a custom tracking URL — no coding needed.

= Use Cases =

* eCommerce stores shipping domestically or internationally
* Dropshipping businesses needing to pass through supplier tracking numbers
* Stores using multiple carriers for different product types
* Developers automating order fulfillment via the REST API or PHP helper functions

= REST API =

WC Shipment Tracker exposes a full REST API:

* `GET /wc-shipment-tracker/v1/orders/{order_id}/trackings` — list tracking items
* `POST /wc-shipment-tracker/v1/orders/{order_id}/trackings` — add a tracking item
* `GET /wc-shipment-tracker/v1/orders/{order_id}/trackings/{id}` — get a single item
* `DELETE /wc-shipment-tracker/v1/orders/{order_id}/trackings/{id}` — delete a tracking item
* `GET /wc-shipment-tracker/v1/providers` — list all available carriers

Compatible with the `wc/v1` and `wc/v2` namespaces for backward compatibility with third-party integrations.

= For Developers =

Add tracking programmatically:

`wcst_add_tracking( $order_id, '1Z9999999', 'UPS' );`

Delete tracking programmatically:

`wcst_delete_tracking( $order_id, '1Z9999999' );`

Extend the carrier list with the `wcst_get_providers` filter:

`add_filter( 'wcst_get_providers', function( $providers ) {
    $providers['My Region']['My Carrier'] = 'https://mycarrier.com/track?id=%1$s';
    return $providers;
} );`

= External Services =

This plugin makes requests to an external service to display carrier logos:

* **Google Favicon Service** (`https://www.google.com/s2/favicons`) — used to fetch carrier icons in the admin orders list and provider selector. The carrier's domain name is sent to Google to retrieve the favicon. No personal data or order information is transmitted.
  * [Google Privacy Policy](https://policies.google.com/privacy)

== Installation ==

1. Upload the `wc-shipment-tracker` folder to the `/wp-content/plugins/` directory, or install directly from the WordPress plugin repository
2. Activate the plugin through the **Plugins** menu in WordPress
3. Make sure WooCommerce is installed and active
4. Open any WooCommerce order and find the **Shipment Tracking** meta box to add your first tracking number

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes. WC Shipment Tracker requires WooCommerce to be installed and active.

= Can I add more than one tracking number per order? =

Yes. You can add as many tracking numbers as needed to a single order — useful for split shipments or orders shipped with multiple carriers.

= My carrier is not in the list. Can I still use it? =

Yes. Select "Custom Provider" when adding a tracking item and enter your carrier name along with the tracking URL. Use `%1$s` as a placeholder for the tracking number in the URL.

= Does tracking info appear in customer emails? =

Yes. Tracking information is automatically injected into WooCommerce order emails (before the order table) as soon as a tracking number is saved to the order.

= Is this plugin compatible with WooCommerce HPOS (High-Performance Order Storage)? =

Yes. WC Shipment Tracker is fully compatible with HPOS (custom order tables), as well as the legacy CPT-based order storage.

= Can I add tracking numbers via the REST API or programmatically? =

Yes. The plugin provides a full REST API and two PHP helper functions — `wcst_add_tracking()` and `wcst_delete_tracking()` — for programmatic use from themes, plugins, or automation scripts.

= Is it compatible with WooCommerce Subscriptions? =

Yes. The plugin detects WooCommerce Subscriptions and automatically prevents tracking numbers from being copied to renewal orders.

= Where does tracking info appear for customers? =

Tracking info appears in two places for customers: the WooCommerce transactional email they receive when the order is shipped, and the order detail page in their My Account section.

= Is the plugin compatible with the WooCommerce blocks checkout? =

Yes. WC Shipment Tracker declares compatibility with WooCommerce cart and checkout blocks.

== Screenshots ==

1. Shipment Tracking meta box on the order edit screen — add, edit, and delete tracking items inline
2. Tracking info displayed in the order confirmation email
3. Tracking info on the customer My Account order detail page
4. Tracking column in the WooCommerce orders list with carrier favicon

== Changelog ==

= 1.1.0 =
* Improved: Carrier favicon now displays inline with the tracking number in the orders list column (no wrapping)
* Improved: Orders list tracking column layout uses flexbox for consistent alignment

= 1.0.9 =
* Initial public release
* Support for 60+ carriers across 20+ countries
* REST API with full CRUD support
* HPOS and WooCommerce Blocks compatibility declared
* WooCommerce Subscriptions integration
* Shortcode [wcst_tracking]
* Developer helper functions: wcst_add_tracking(), wcst_delete_tracking()

== Upgrade Notice ==

= 1.1.0 =
Visual improvement to the orders list tracking column. No database changes. Safe to update.
