=== Trackora - Shipment Tracker for WooCommerce ===
Contributors: slbarriosdev
Donate link: https://github.com/slbarriosdev/wc-shipment-tracker
Tags: woocommerce, tracking, shipment, shipping, order-tracking
Requires at least: 6.4
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add tracking numbers to WooCommerce orders. Supports 60+ carriers worldwide. Shown in emails, My Account, and admin panel.

== Description ==

**WC Shipment Tracker** is the easiest way to add shipment tracking to your WooCommerce store. Let your customers follow their packages in real time — directly from their order confirmation email or their My Account page — without contacting you.

Stop answering "Where is my order?" emails. Give customers a one-click tracking link the moment their order ships.

= Key Features =

* **Add multiple tracking numbers per order** — perfect for split shipments
* **60+ pre-built shipping carriers** across 20+ countries (UPS, FedEx, USPS, DHL, Royal Mail, Australia Post, Correos, and many more)
* **Custom carrier support** — use any carrier not on the list by entering a custom tracking URL
* **Tracking info in order emails** — automatically added before the order table in WooCommerce transactional emails
* **My Account integration** — customers see their tracking link on the order detail page
* **Admin orders list column** — see tracking numbers at a glance in the WooCommerce orders list
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

= Source Code =

The source code is publicly available on GitHub: [https://github.com/slbarriosdev/wc-shipment-tracker](https://github.com/slbarriosdev/wc-shipment-tracker)

Bug reports and contributions are welcome.


== Installation ==

1. Upload the `trackora` folder to the `/wp-content/plugins/` directory, or install directly from the WordPress plugin repository
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
4. Tracking column in the WooCommerce orders list

== External services ==

This plugin generates tracking links pointing to carrier websites. When a tracking number is added to an order, the plugin builds a URL for the selected carrier and displays it to the store admin and customers.

**The plugin does not make any server-side HTTP requests to carrier websites.** Data is only transmitted when a user (admin or customer) actively clicks a tracking link — at that point their browser connects to the carrier's website and the tracking number (and in some cases the shipping postcode) is passed in the URL as required by that carrier's tracking system.

Each carrier operates its own website under its own terms of service and privacy policy. The external carrier services this plugin may link to include:

= United States =
* **UPS** — [Terms of service](https://www.ups.com/us/en/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/us/en/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **FedEx** — [Terms of service](https://www.fedex.com/en-us/terms-of-use.html) | [Privacy policy](https://www.fedex.com/en-us/privacy-policy.html)
* **FedEx Sameday** — [Terms of service](https://www.fedex.com/en-us/terms-of-use.html) | [Privacy policy](https://www.fedex.com/en-us/privacy-policy.html)
* **USPS** — [Terms of service](https://www.usps.com/terms-of-use.htm) | [Privacy policy](https://www.usps.com/privacypolicy.htm)
* **DHL US / DHL eCommerce** — [Terms of service](https://www.dhl.com/us-en/home/our-divisions/ecommerce/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/us-en/home/our-divisions/ecommerce/legal/privacy-notice.html)
* **GlobalPost** — [Terms of service](https://www.goglobalpost.com/terms/) | [Privacy policy](https://www.goglobalpost.com/privacy/)
* **OnTrac** — [Terms of service](https://www.ontrac.com/termsconditions.asp) | [Privacy policy](https://www.ontrac.com/privacy.asp)

= United Kingdom =
* **Royal Mail** — [Terms of service](https://www.royalmail.com/terms-and-conditions) | [Privacy policy](https://www.royalmail.com/privacy-policy)
* **DHL Parcel UK** — [Terms of service](https://www.dhl.com/gb-en/home/our-divisions/parcel/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/gb-en/home/our-divisions/parcel/legal/privacy-notice.html)
* **DPD UK** — [Terms of service](https://www.dpd.co.uk/content/legal_info/terms_conditions.jsp) | [Privacy policy](https://www.dpd.co.uk/content/legal_info/privacy_policy.jsp)
* **DPD Local** — [Terms of service](https://www.dpdlocal.co.uk/terms-and-conditions/) | [Privacy policy](https://www.dpdlocal.co.uk/privacy-policy/)
* **EVRi** — [Terms of service](https://www.evri.com/terms-and-conditions) | [Privacy policy](https://www.evri.com/privacy-policy)
* **ParcelForce** — [Terms of service](https://www.parcelforce.com/terms-conditions) | [Privacy policy](https://www.parcelforce.com/privacy-cookies)
* **TNT Express** — [Terms of service](https://www.tnt.com/express/en_gb/site/terms-conditions.html) | [Privacy policy](https://www.tnt.com/express/en_gb/site/privacy-policy.html)
* **City Link** — [Privacy policy](https://www.citylink.co.uk/privacy-policy/)

= Spain =
* **Correos España** — [Terms of service](https://www.correos.es/es/es/particulares/legal/condiciones-de-uso) | [Privacy policy](https://www.correos.es/es/es/particulares/legal/politica-de-privacidad)
* **MRW** — [Terms of service](https://www.mrw.es/informacion/condiciones-de-uso) | [Privacy policy](https://www.mrw.es/informacion/politica-de-privacidad)
* **SEUR** — [Terms of service](https://www.seur.com/es/condiciones-de-uso.shtml) | [Privacy policy](https://www.seur.com/es/politica-de-privacidad.shtml)
* **GLS Spain** — [Terms of service](https://gls-group.com/ES/es/informacion-legal) | [Privacy policy](https://gls-group.com/ES/es/politica-de-privacidad)
* **Nacex** — [Terms of service](https://www.nacex.es/condiciones-legales-de-uso-de-la-web.do) | [Privacy policy](https://www.nacex.es/politica-de-privacidad.do)
* **Correos Express** — [Terms of service](https://www.correosexpress.com/web/correosexpress/condiciones-de-uso) | [Privacy policy](https://www.correosexpress.com/web/correosexpress/politica-de-privacidad)
* **Zeleris** — [Privacy policy](https://www.zeleris.com/en/privacy-policy/)

= Mexico =
* **Correos de Mexico** — [Terms of service](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Terminos.aspx) | [Privacy policy](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Aviso.aspx)
* **Estafeta** — [Terms of service](https://www.estafeta.com/aviso-legal) | [Privacy policy](https://www.estafeta.com/aviso-de-privacidad)
* **Paquetexpress** — [Privacy policy](https://www.paquetexpress.com.mx/aviso-de-privacidad)
* **Redpack** — [Privacy policy](https://www.redpack.com.mx/es/aviso-de-privacidad/)

= Colombia =
* **Servientrega** — [Terms of service](https://www.servientrega.com/wps/portal/terminos-y-condiciones) | [Privacy policy](https://www.servientrega.com/wps/portal/politica-de-privacidad)
* **Interrapidisimo** — [Privacy policy](https://www.interrapidisimo.com/politica-de-privacidad/)
* **Deprisa** — [Privacy policy](https://www.deprisa.com/politica-de-privacidad/)

= Ireland =
* **An Post** — [Terms of service](https://www.anpost.com/terms-and-conditions) | [Privacy policy](https://www.anpost.com/privacy)

= Germany =
* **DHL Intraship / Deutsche Post DHL** — [Terms of service](https://www.dhl.de/de/privatkunden/hilfe/rechtliche-hinweise.html) | [Privacy policy](https://www.dhl.de/de/privatkunden/hilfe/datenschutz.html)
* **Hermes** — [Terms of service](https://www.myhermes.de/agb/) | [Privacy policy](https://www.myhermes.de/datenschutz/)
* **DPD.de** — [Terms of service](https://www.dpd.com/de/de/nutzungsbedingungen/) | [Privacy policy](https://www.dpd.com/de/de/datenschutz/)

= Sweden =
* **PostNord** — [Terms of service](https://www.postnord.com/en/terms-and-conditions) | [Privacy policy](https://www.postnord.com/en/privacy)
* **DB Schenker** — [Terms of service](https://www.dbschenker.com/global-en/meta/legal-notice) | [Privacy policy](https://www.dbschenker.com/global-en/meta/privacy-policy)
* **Bring.se** — [Terms of service](https://www.bring.se/om-bring/integritetspolicy) | [Privacy policy](https://www.bring.se/om-bring/integritetspolicy)

= Romania =
* **Fan Courier** — [Terms of service](https://www.fancourier.ro/termeni-conditii/) | [Privacy policy](https://www.fancourier.ro/politica-de-confidentialitate/)
* **DPD Romania** — [Terms of service](https://www.dpd.com/ro/ro/termeni-si-conditii/) | [Privacy policy](https://www.dpd.com/ro/ro/politica-de-confidentialitate/)
* **Urgent Cargus** — [Terms of service](https://www.urgentcargus.ro/termeni-si-conditii) | [Privacy policy](https://www.urgentcargus.ro/politica-de-confidentialitate)

= Czech Republic =
* **PPL.cz** — [Terms of service](https://www.ppl.cz/main2.aspx?cls=ArticleDetail&idart=141) | [Privacy policy](https://www.ppl.cz/main2.aspx?cls=ArticleDetail&idart=140)
* **Česká pošta** — [Terms of service](https://www.ceskaposta.cz/ke-stazeni/informace-o-zpracovani-osobnich-udaju) | [Privacy policy](https://www.ceskaposta.cz/ke-stazeni/informace-o-zpracovani-osobnich-udaju)

= Netherlands =
* **PostNL** — [Terms of service](https://www.postnl.nl/algemene-voorwaarden/) | [Privacy policy](https://www.postnl.nl/privacy/)

= Australia =
* **Australia Post** — [Terms of service](https://auspost.com.au/terms-conditions) | [Privacy policy](https://auspost.com.au/privacy)
* **Aramex Australia** — [Terms of service](https://www.aramex.com/au/en/legal/terms-conditions) | [Privacy policy](https://www.aramex.com/au/en/legal/privacy-policy)

= Canada =
* **Canada Post** — [Terms of service](https://www.canadapost-postescanada.ca/cpc/en/our-company/about-canada-post/corporate-responsibility/terms-of-use.page) | [Privacy policy](https://www.canadapost-postescanada.ca/cpc/en/our-company/about-canada-post/corporate-responsibility/privacy-policy.page)
* **Purolator** — [Terms of service](https://www.purolator.com/en/terms-and-conditions) | [Privacy policy](https://www.purolator.com/en/privacy-policy)

= Brazil =
* **Correios** — [Terms of service](https://www.correios.com.br/acesso-a-informacao/institucional/termos-de-uso) | [Privacy policy](https://www.correios.com.br/acesso-a-informacao/institucional/politica-de-privacidade)

= Belgium =
* **bpost** — [Terms of service](https://www.bpost.be/en/terms-and-conditions) | [Privacy policy](https://www.bpost.be/en/privacy-policy)

= Poland =
* **InPost** — [Terms of service](https://inpost.pl/regulaminy) | [Privacy policy](https://inpost.pl/polityka-prywatnosci)

= Ireland =
* **DPD.ie** — [Terms of service](https://dpd.ie/terms-and-conditions) | [Privacy policy](https://dpd.ie/privacy-policy)

= Italy =
* **BRT (Bartolini)** — [Terms of service](https://www.brt.it/note-legali/) | [Privacy policy](https://www.brt.it/privacy/)

= India =
* **DTDC** — [Terms of service](https://www.dtdc.in/terms-condition.asp) | [Privacy policy](https://www.dtdc.in/privacy-policy.asp)

= Global =
* **Aramex** — [Terms of service](https://www.aramex.com/us/en/legal/terms-conditions) | [Privacy policy](https://www.aramex.com/us/en/legal/privacy-policy)
* **DHL Express** — [Terms of service](https://www.dhl.com/global-en/home/our-divisions/express/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/global-en/home/our-divisions/express/legal/privacy-notice.html)

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
