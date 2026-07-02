=== Trackora - Shipment Tracker for WooCommerce ===
Contributors: slbarriosdev
Tags: woocommerce, tracking, shipment, shipping, order-tracking
Requires at least: 6.4
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.2.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add tracking numbers to WooCommerce orders. Supports 60+ carriers worldwide. Shown in emails, My Account, and admin panel.

== Description ==

**Trackora** is the easiest way to add shipment tracking to your WooCommerce store. Let your customers follow their packages in real time — directly from their order confirmation email or their My Account page — without contacting you.

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

Trackora exposes a full REST API:

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

Yes. Trackora requires WooCommerce to be installed and active.

= Can I add more than one tracking number per order? =

Yes. You can add as many tracking numbers as needed to a single order — useful for split shipments or orders shipped with multiple carriers.

= My carrier is not in the list. Can I still use it? =

Yes. Select "Custom Provider" when adding a tracking item and enter your carrier name along with the tracking URL. Use `%1$s` as a placeholder for the tracking number in the URL.

= Does tracking info appear in customer emails? =

Yes. Tracking information is automatically injected into WooCommerce order emails (before the order table) as soon as a tracking number is saved to the order.

= Is this plugin compatible with WooCommerce HPOS (High-Performance Order Storage)? =

Yes. Trackora is fully compatible with HPOS (custom order tables), as well as the legacy CPT-based order storage.

= Can I add tracking numbers via the REST API or programmatically? =

Yes. The plugin provides a full REST API and two PHP helper functions — `wcst_add_tracking()` and `wcst_delete_tracking()` — for programmatic use from themes, plugins, or automation scripts.

= Is it compatible with WooCommerce Subscriptions? =

Yes. The plugin detects WooCommerce Subscriptions and automatically prevents tracking numbers from being copied to renewal orders.

= Where does tracking info appear for customers? =

Tracking info appears in two places for customers: the WooCommerce transactional email they receive when the order is shipped, and the order detail page in their My Account section.

= Is the plugin compatible with the WooCommerce blocks checkout? =

Yes. Trackora declares compatibility with WooCommerce cart and checkout blocks.

== Screenshots ==

1. The Shipment Tracking meta box: add a carrier, tracking number, tracking link, and ship date directly from the order edit screen
2. The Shipment Tracking meta box shown in context on the WooCommerce order edit screen
3. A saved tracking number on the order edit screen, with one-click Track, Edit, and Delete actions
4. Tracking information automatically added to the WooCommerce order confirmation email, before the order details

== External services ==

This plugin generates tracking links pointing to carrier websites. When a tracking number is added to an order, the plugin builds a URL for the selected carrier and displays it to the store admin and customers.

**The plugin does not make any server-side HTTP requests to carrier websites.** Data is only transmitted when a user (admin or customer) actively clicks a tracking link — at that point their browser connects to the carrier's website and the tracking number (and in some cases the shipping postcode) is passed in the URL as required by that carrier's tracking system.

Each carrier operates its own website under its own terms of service and privacy policy. The external carrier services this plugin may link to include:

= Global =
* **Aramex** — [Terms of service](https://www.aramex.com/us/en/terms-of-use) | [Privacy policy](https://www.aramex.com/us/en/legal-details/privacy-policy)
* **DHL Express** — [Terms of service](https://www.dhl.com/global-en/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)

= Argentina =
* **Correo Argentino** — [Terms of service](https://www.correoargentino.com.ar/terminos-de-utilizacion-de-la-pagina-web-de-correo-argentino) | [Privacy policy](https://www.correoargentino.com.ar/terminos-y-condiciones-generales-de-privacidad)
* **OCA** — [Privacy policy](https://www.oca.com.ar/politica-de-privacidad)
* **Andreani** — [Privacy policy](https://www.andreani.com/politica-de-privacidad)
* **DHL Argentina** — [Terms of service](https://www.dhl.com/ar-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **FedEx Argentina** — [Terms of service](https://www.fedex.com/es-ar/terms-of-use.html) | [Privacy policy](https://www.fedex.com/es-ar/privacy-policy.html)
* **Urbano** — [Privacy policy](https://www.urbano.com.ar/politicaprivacidad.php)

= Australia =
* **Australia Post** — [Terms of service](https://auspost.com.au/terms-conditions) | [Privacy policy](https://auspost.com.au/privacy)
* **Fastway Couriers** — [Terms of service](https://www.aramex.com.au/terms-and-conditions/conditions-of-carriage/domestic-conditions-of-carriage/) | [Privacy policy](https://www.aramex.com.au/terms-and-conditions/privacy-policy/)
* **Aramex Australia** — [Terms of service](https://www.aramex.com/us/en/terms-of-use) | [Privacy policy](https://www.aramex.com/us/en/legal-details/privacy-policy)

= Austria =
* **post.at** — [Terms of service](https://www.post.at/en/i/c/data-protection) | [Privacy policy](https://www.post.at/en/i/c/data-protection-letters-parcels)
* **dhl.at** — [Terms of service](https://www.dhl.com/at-de/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **DPD.at** — [Terms of service](https://www.dpd.com/at/de/rechtliches/agb/) | [Privacy policy](https://www.dpd.com/at/de/rechtliches/datenschutz/)

= Belgium =
* **bpost** — [Terms of service](https://www.bpost.be/en/webservice-general-terms-and-conditions) | [Privacy policy](https://www.bpost.be/en/privacy)

= Brazil =
* **Correios** — [Terms of service](https://www.correios.com.br/acesso-a-informacao/institucional/legislacao) | [Privacy policy](https://www.correios.com.br/falecomoscorreios/politica-de-privacidade-e-cookies)

= Canada =
* **Canada Post** — [Terms of service](https://www.canadapost-postescanada.ca/cpc/en/support/kb/company-policies/terms-conditions/legal-terms-of-use-and-conditions.page) | [Privacy policy](https://www.canadapost-postescanada.ca/cpc/en/our-company/transparency-and-trust/privacy-centre/privacy-policy.page)
* **Purolator** — [Terms of service](https://www.purolator.com/en/terms-and-conditions-service) | [Privacy policy](https://www.purolator.com/en/legal/privacy.page)

= Chile =
* **Correos Chile** — [Terms of service](https://www.correos.cl/condiciones-de-servicio) | [Privacy policy](https://www.correos.cl/politicas-de-privacidad)
* **Chilexpress** — [Terms of service](https://www.chilexpress.cl/termino-condiciones-politica-privacidad) | [Privacy policy](https://www.chilexpress.cl/politica-de-privacidad-terminos-de-uso-sitios)
* **Starken** — [Privacy policy](https://www.starken.cl/politica-de-privacidad)
* **DHL Chile** — [Terms of service](https://www.dhl.com/cl-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **Blue Express** — [Privacy policy](https://www.blue.cl/nosotros/politica-privacidad)

= China =
* **China Post / EMS** — Privacy policy currently unavailable (provider website blocks automated access)
* **YTO Express** — [Privacy policy](https://www.ytoexpress.com/privacy)
* **ZTO Express** — [Privacy policy](https://www.zto.com/privacypolicy)
* **SF Express** — [Privacy policy](https://www.sf-express.com/chn/en/privacy)
* **Cainiao** — [Privacy policy](https://privacy.alibabagroup.com/en/global)
* **4PX** — [Privacy policy](https://www.4px.com/view/privacy.html)
* **Yanwen** — [Privacy policy](https://customer-portal.yanwenexpress.com/agreement/Yanwen_privacy_policy)
* **Yunexpress** — [Privacy policy](https://www.yuntrack.com/privacy)

= Colombia =
* **Servientrega** — [Terms of service](https://www.servientrega.com/wps/portal/Colombia/inicio/terminos-y-condiciones) | [Privacy policy](https://www.servientrega.com/wps/portal/Colombia/inicio/politica-de-privacidad)
* **Coordinadora** — [Privacy policy](https://www.coordinadora.com/politica-de-privacidad)
* **Deprisa** — [Privacy policy](https://www.deprisa.com/AvisoPrivacidad)
* **TCC** — [Terms of service](https://tcc.com.co/terminos-y-condiciones/) | [Privacy policy](https://tcc.com.co/corporativo/terminos-y-condiciones/politica-de-proteccion-de-datos/)
* **DHL Colombia** — [Terms of service](https://www.dhl.com/co-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **J&T Express CO** — [Privacy policy](https://www.jtexpress.co/privacy)
* **Interrapidisimo** — [Terms of service](https://interrapidisimo.com/terminos-condiciones-pre-envios/) | [Privacy policy](https://interrapidisimo.com/proteccion-de-datos-personales/)

= Czech Republic =
* **PPL.cz** — [Terms of service](https://www.ppl.cz/en/documents/terms-and-conditions) | [Privacy policy](https://www.ppl.cz/en/privacy-policy)
* **Česká pošta** — [Terms of service](https://www.ceskaposta.cz/ke-stazeni/informace-o-zpracovani-osobnich-udaju) | [Privacy policy](https://www.ceskaposta.cz/ke-stazeni/informace-o-zpracovani-osobnich-udaju)
* **DHL.cz** — [Terms of service](https://www.dhl.com/cz-cs/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **DPD.cz** — [Terms of service](https://www.dpd.com/cz/cs/pravni-informace/podminky-pouzivani/) | [Privacy policy](https://www.dpd.com/cz/cs/pravni-informace/ochrana-osobnich-udaju/)

= Ecuador =
* **Servientrega EC** — [Terms of service](https://www.servientrega.com.ec/TerminosCondiciones/TerminosCondiciones) | [Privacy policy](https://www.servientrega.com.ec/Home/PoliticaProteccionDatos)
* **Laar Courier** — [Privacy policy](https://www.laarcourier.com/politicas/privacidad)
* **Correos Ecuador** — [Privacy policy](https://www.serviciopostal.gob.ec/)
* **DHL Ecuador** — [Terms of service](https://www.dhl.com/ec-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)

= Finland =
* **Itella / Posti** — [Terms of service](https://www.posti.fi/en/customer-support/terms-and-conditions/) | [Privacy policy](https://www.posti.fi/en/customer-support/privacy/)

= France =
* **Colissimo / La Poste** — [Terms of service](https://www.laposte.fr/mentions-legales) | [Privacy policy](https://www.laposte.fr/politique-de-protection-des-donnees)

= Germany =
* **DHL Intraship / Deutsche Post DHL** — [Terms of service](https://www.dhl.de/en/geschaeftskunden/express/allgemeine-geschaeftsbedingungen.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **Hermes** — [Terms of service](https://www.myhermes.de/agb/) | [Privacy policy](https://www.myhermes.de/datenschutz/)
* **UPS Germany** — [Terms of service](https://www.ups.com/de/de/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/de/de/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **DPD.de** — [Terms of service](https://www.dpd.com/de/de/nutzungsbedingungen/) | [Privacy policy](https://www.dpd.com/de/de/datenschutz/)

= India =
* **DTDC** — [Terms of service](https://www.dtdc.in/terms-condition.asp) | [Privacy policy](https://www.dtdc.in/privacy-policy.asp)

= Ireland =
* **DPD.ie** — [Terms of service](https://www.dpd.ie/trading-terms-conditions-parcel-delivery/) | [Privacy policy](https://www.dpd.ie/Privacy-Policy/)
* **An Post** (tracking portal: track.anpost.ie) — [Terms of service](https://www.anpost.com/Terms-Conditions) | [Privacy policy](https://www.anpost.com/Privacy/Group-Data-Privacy-Statement)

= Italy =
* **BRT (Bartolini)** — [Terms of service](https://www.brt.it/note-legali/) | [Privacy policy](https://www.brt.it/privacy/)
* **DHL Express Italy** — [Terms of service](https://www.dhl.com/it-it/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)

= Japan =
* **Japan Post** — [Terms of service](https://www.japanpost.jp/en/usage/) | [Privacy policy](https://www.japanpost.jp/en/corporate/control/privacy.html)
* **Yamato Transport** — [Privacy policy](https://www.kuronekoyamato.co.jp/ytc/privacy/)
* **Sagawa** — [Privacy policy](https://www.sagawa-exp.co.jp/privacy/)

= Malaysia =
* **Pos Malaysia** — [Terms of service](https://www.pos.com.my/footer-links/terms-and-conditions) | [Privacy policy](https://www.pos.com.my/footer-links/privacy-policy)
* **J&T Express MY** — [Privacy policy](https://www.jtexpress.my/legal/privacy-policy)
* **Ninja Van MY** — [Privacy policy](https://www.ninjavan.co/en-my/privacy-policy)
* **DHL Malaysia** — [Terms of service](https://www.dhl.com/my-en/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)

= Mexico =
* **Correos de Mexico** — [Terms of service](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Terminos.aspx) | [Privacy policy](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Aviso.aspx)
* **Estafeta** — [Terms of service](https://www.estafeta.com/en/contrato-de-servicios) | [Privacy policy](https://www.estafeta.com/en/aviso-de-privacidad)
* **Paquetexpress** — [Privacy policy](https://www.paquetexpress.com.mx/aviso-de-privacidad)
* **Redpack** — [Privacy policy](https://www.redpack.com.mx/es/aviso-de-privacidad/)
* **DHL Mexico** — [Terms of service](https://www.dhl.com/mx-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **FedEx Mexico** — [Terms of service](https://www.fedex.com/es-mx/terms-of-use.html) | [Privacy policy](https://www.fedex.com/es-mx/privacy-policy.html)
* **UPS Mexico** — [Terms of service](https://www.ups.com/mx/es/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/mx/es/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **Coordinadora** — [Privacy policy](https://www.coordinadora.com/politica-de-privacidad)
* **J&T Express Mexico** — [Privacy policy](https://www.jtexpress.mx/privacy-policy)

= Netherlands =
* **PostNL** — [Terms of service](https://www.postnl.nl/en/terms-and-conditions/) | [Privacy policy](https://www.postnl.nl/en/privacy-statement/)
* **DPD.NL** — [Terms of service](https://www.dpd.com/nl/en/general-terms-conditions/) | [Privacy policy](https://www.dpd.com/nl/en/privacy-statement/)
* **UPS Netherlands** — [Terms of service](https://www.ups.com/nl/nl/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/nl/nl/support/shipping-support/legal-terms-conditions/privacy-notice.page)

= New Zealand =
* **NZ Post** — [Terms of service](https://www.nzpost.co.nz/about-us/who-we-are/terms-conditions) | [Privacy policy](https://www.nzpost.co.nz/about-us/privacy-centre)
* **Courier Post** — [Terms of service](https://www.nzpost.co.nz/about-us/who-we-are/terms-conditions) | [Privacy policy](https://www.nzpost.co.nz/about-us/privacy-centre)
* **Aramex New Zealand** — [Terms of service](https://www.aramex.com/us/en/terms-of-use) | [Privacy policy](https://www.aramex.com/us/en/legal-details/privacy-policy)

= Nigeria =
* **DHL Nigeria** — [Terms of service](https://www.dhl.com/ng-en/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **GIG Logistics** — [Privacy policy](https://giglogistics.com/privacy-policy)

= Peru =
* **Serpost** — [Terms of service](https://www.serpost.com.pe/Cliente/TerminoCondiciones) | [Privacy policy](https://www.serpost.com.pe/Cliente/TerminoCondiciones)
* **Olva Courier** — [Terms of service](https://www.olvacourier.com/terminos-y-condiciones) | [Privacy policy](https://www.olvacourier.com/politicas-de-privacidad)
* **DHL Peru** — [Terms of service](https://www.dhl.com/pe-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **Shalom** — [Privacy policy](https://shalom.com.pe/faq/data_protection)

= Poland =
* **InPost** — [Terms of service](https://inpost.pl/regulaminy) | [Privacy policy](https://inpost.pl/polityka-prywatnosci)
* **DPD.PL** — [Terms of service](https://www.dpd.com/pl/pl/informacje-prawne/warunki-korzystania/) | [Privacy policy](https://www.dpd.com/pl/pl/informacje-prawne/polityka-prywatnosci/)
* **Poczta Polska** — [Terms of service](https://www.poczta-polska.pl/regulaminy/) | [Privacy policy](https://www.poczta-polska.pl/polityka-prywatnosci/)

= Portugal =
* **CTT** — [Terms of service](https://www.ctt.pt/home/termos-condicoes/grupo-ctt) | [Privacy policy](https://www.ctt.pt/home/politica-privacidade/index)
* **DPD Portugal** — [Terms of service](https://www.dpd.com/pt/pt/informacao-legal/condicoes-de-utilizacao/) | [Privacy policy](https://www.dpd.com/pt/pt/informacao-legal/politica-de-privacidade/)
* **GLS Portugal** — [Terms of service](https://gls-group.com/PT/pt/aviso-legal/) | [Privacy policy](https://gls-group.com/PT/pt/protecao-de-dados/)
* **DHL Portugal** — [Terms of service](https://www.dhl.com/pt-pt/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)

= Romania =
* **Fan Courier** — [Terms of service](https://www.fancourier.ro/en/general-conditions-regarding-the-provision-of-postal-services/) | [Privacy policy](https://www.fancourier.ro/en/privacy-policy/)
* **DPD Romania** — [Terms of service](https://www.dpd.com/ro/en/termeni-si-conditii/) | [Privacy policy](https://www.dpd.com/ro/en/termeni-si-conditii/)
* **Urgent Cargus** — [Terms of service](https://www.urgentcargus.ro/termeni-si-conditii) | [Privacy policy](https://www.urgentcargus.ro/politica-de-confidentialitate)

= Singapore =
* **SingPost** — [Terms of service](https://www.singpost.com/terms-use) | [Privacy policy](https://www.singpost.com/privacy-policy)
* **Ninja Van SG** — [Privacy policy](https://www.ninjavan.co/en-sg/privacy-policy)
* **J&T Express SG** — [Privacy policy](https://www.jtexpress.sg/privacy-policy)

= South Africa =
* **SAPO / South African Post Office** — [Privacy policy](https://www.postoffice.co.za/Legal/disclaimer.html)
* **Fastway SA** — [Privacy policy](https://fastway.co.za/privacy-policy)
* **EPX** — [Terms of service](https://epx.co.za/terms-conditions.php) | [Privacy policy](https://epx.co.za/privacy-policy.php)

= South Korea =
* **Korea Post** — [Privacy policy](https://www.koreapost.go.kr/privacy.do)
* **CJ Logistics** — [Privacy policy](https://www.cjlogistics.com/en/agreement/privacy-policy)
* **Lotte Logistics** — [Privacy policy](https://www.lotteglogis.com/english/csm/ethic/policy)

= Spain =
* **Correos España** — [Terms of service](https://www.correos.es/es/es/particulares/legal/condiciones-de-uso) | [Privacy policy](https://www.correos.es/es/es/particulares/legal/politica-de-privacidad)
* **MRW** — [Terms of service](https://www.mrw.es/informacion/condiciones-de-uso) | [Privacy policy](https://www.mrw.es/informacion/politica-de-privacidad)
* **SEUR** — [Terms of service](https://www.seur.com/es/condiciones-de-uso.shtml) | [Privacy policy](https://www.seur.com/es/politica-de-privacidad.shtml)
* **GLS Spain** — [Terms of service](https://gls-group.com/ES/es/aviso-legal/) | [Privacy policy](https://gls-group.com/ES/es/proteccion-de-datos/)
* **Nacex** — [Terms of service](https://www.nacex.es/irCondiciones.do?seccion=condiciones) | [Privacy policy](https://www.nacex.es/irPolitica.do)
* **DHL Spain** — [Terms of service](https://www.dhl.com/es-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **UPS Spain** — [Terms of service](https://www.ups.com/es/es/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/es/es/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **DPD Spain** — [Terms of service](https://www.geopost.com/en/legal-and-copyright-notice-disclaimer-dispute-settlement) | [Privacy policy](https://www.geopost.com/en/data-privacy-policy)
* **ASM** — [Terms of service](https://gls-group.com/ES/es/aviso-legal/) | [Privacy policy](https://gls-group.com/ES/es/proteccion-de-datos/)
* **Correos Express** — [Terms of service](https://www.correosexpress.es/es/atencion-al-cliente/tyc-transporte) | [Privacy policy](https://www.correosexpress.es/es/legales/privacidad-web-com)
* **Zeleris** — [Privacy policy](https://www.zeleris.com/politica-de-privacidad/)
* **TNT Spain** — [Terms of service](https://www.tnt.com/express/es_es/site/terminos-condiciones.html) | [Privacy policy](https://www.tnt.com/express/es_es/site/politica-privacidad.html)

= Sweden =
* **PostNord** — [Terms of service](https://account.postnord.com/public/about/terms-and-conditions) | [Privacy policy](https://www.postnord.com/privacy-policy/)
* **DHL.se** — [Terms of service](https://www.dhl.com/se-sv/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **Bring.se** — [Terms of service](https://www.bring.se/om-bring/integritetspolicy) | [Privacy policy](https://www.bring.se/om-bring/integritetspolicy)
* **UPS.se** — [Terms of service](https://www.ups.com/se/sv/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/se/sv/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **DB Schenker** (tracking portal: privpakportal.schenker.nu for Privpak service) — [Terms of service](https://www.dbschenker.com/ds-en/legal-notice) | [Privacy policy](https://www.dbschenker.com/global/meta/privacy-policy)

= Thailand =
* **Thailand Post** — [Terms of service](https://www.thailandpost.co.th/en/terms-and-conditions) | [Privacy policy](https://www.thailandpost.co.th/en/privacy-policy)
* **Kerry Express (KEX)** — [Terms of service](https://th.kex-express.com/en/terms-of-use) | [Privacy policy](https://th.kex-express.com/en/privacy-notice)
* **Flash Express** — [Privacy policy](https://www.flashexpress.co.th/fle/our-service/service-agreement/fex-privacy-policy)
* **J&T Express TH** — [Privacy policy](https://www.jtexpress.co.th/privacy-policy)

= Turkey =
* **PTT** — [Privacy policy](https://www.ptt.gov.tr/gizlilik)
* **Aras Cargo** — [Terms of service](https://www.araskargo.com.tr/kullanim-kosullari) | [Privacy policy](https://www.araskargo.com.tr/gizlilik-politikasi)
* **Yurtici Kargo** — [Privacy policy](https://www.yurticikargo.com/en/privacy-and-security)
* **MNG Kargo** — [Privacy policy](https://www.mngkargo.com.tr/genel-aydinlatma-metni)

= United Kingdom =
* **DHL UK** — [Terms of service](https://www.dhl.com/gb-en/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **DPD.co.uk** — [Terms of service](https://www.dpd.co.uk/terms-and-conditions.jsp) | [Privacy policy](https://www.dpd.co.uk/privacy_policy.jsp)
* **DPD Local** — [Terms of service](https://www.dpdlocal.co.uk/standard_terms_and_conditions.jsp) | [Privacy policy](https://www.dpdlocal.co.uk/privacy_policy.jsp)
* **EVRi** — [Terms of service](https://www.evri.com/terms-and-conditions) | [Privacy policy](https://www.evri.com/privacy-policy)
* **ParcelForce** — [Terms of service](https://www.parcelforce.com/terms-and-conditions) | [Privacy policy](https://www.parcelforce.com/help-and-advice/terms-and-conditions/privacy-policy)
* **Royal Mail** — [Terms of service](https://www.royalmail.com/terms-and-conditions) | [Privacy policy](https://www.royalmail.com/privacy-policy)
* **TNT Express** — [Terms of service](https://www.tnt.com/express/en_gb/site/terms-conditions.html) | [Privacy policy](https://www.tnt.com/express/en_gb/site/privacy-policy.html)
* **DHL Parcel UK** — [Terms of service](https://www.dhl.com/gb-en/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **City Link** — [Privacy policy](https://www.citylink.co.uk/privacy-policy/)

= United States =
* **UPS** — [Terms of service](https://www.ups.com/us/en/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/us/en/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **FedEx / FedEx Sameday** (tracking portal: fedexsameday.com for Sameday deliveries) — [Terms of service](https://www.fedex.com/en-us/terms-of-use.html) | [Privacy policy](https://www.fedex.com/en-us/trust-center/privacy.html)
* **USPS** — [Terms of service](https://about.usps.com/termsofuse.htm) | [Privacy policy](https://about.usps.com/who/legal/privacy-policy/full-privacy-policy.htm)
* **DHL US / DHL eCommerce** — [Terms of service](https://www.dhl.com/us-en/home/ecommerce/business-help-center/terms-and-conditions.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)
* **GlobalPost** — [Terms of service](https://www.goglobalpost.com/conditions/) | [Privacy policy](https://auctane.com/legal/privacy-policy/)
* **OnTrac** — [Terms of service](https://www.ontrac.com/terms-conditions/) | [Privacy policy](https://www.ontrac.com/privacy/)

= Venezuela =
* **MRW Venezuela** — [Privacy policy](https://mrwve.com/politica-de-privacidad)
* **Zoom** — [Terms of service](https://zoom.red/aviso-legal/) | [Privacy policy](https://zoom.red/privacidad-web/)
* **DHL Venezuela** — [Terms of service](https://www.dhl.com/ve-es/home/footer/terms-of-use.html) | [Privacy policy](https://group.dhl.com/en/data-protection.html)

== Changelog ==

= 1.2.6 =
* Fix: Public tracking lookup ([wcst_tracking] shortcode) now resolves orders by their visible order number, so it works on stores using sequential or custom order numbers (previously only the internal order ID matched)
* Improvement: Billing email check in the tracking lookup is now trimmed and case-insensitive, and rejects orders with no billing email
* Improvement: Order number field in the lookup form accepts custom formats (prefixes/dashes), not only plain digits
* Improvement: Added the "Track another order" link to the "no tracking yet" screen, so customers can look up a different order without going back

= 1.2.5 =
* Improvement: Added a copy-to-clipboard button next to tracking numbers in the WooCommerce Orders list column
* Improvement: The "Add Tracking Number" button now hides while the tracking form is open and returns after saving or cancelling
* Fix: Removed the unused carrier logo placeholder (empty grey box) from tracking items in the order meta box
* Fix: Removed the top border and extra spacing above the Add Tracking form in the order meta box

= 1.2.3 =
* Fix: Updated 10 broken or outdated carrier URLs in External services section (Blue Express Chile, Yanwen, J&T Express MY, Correos Express, Kerry Express Thailand, PTT Turkey, MNG Kargo Turkey, Fastway Couriers AU now on Aramex AU, EPX SA now points to actual privacy page; China Post/EMS marked unavailable as provider blocks automated access)
* Fix: Removed load_plugin_textdomain() call — not needed for plugins hosted on WordPress.org (WordPress 4.6+)
* Fix: Removed unnecessary wpdb::prepare() wrapping of hardcoded constant in subscriptions renewal query
* Fix: Replaced 9 dead carrier tracking-link domains with current working tracking pages (Kerry Express now KEX th.kex-express.com, Yanwen, ASM now GLS Spain, Correos Ecuador, Shalom, MRW Venezuela, Urbano, Zoom now zoom.red, China Post/EMS)
* Fix: Restored Zoom (Venezuela) Terms and Privacy links now that the provider's new site (zoom.red) is reachable

= 1.2.2 =
* Fix: Updated 5 broken carrier URLs in External services section (4PX, DPD Spain ×2, Correos Express, GlobalPost)
* Fix: REST API POST permission_callback now checks 'edit' capability instead of 'create' when adding tracking to an existing order

= 1.2.1 =
* Fix: Use esc_url_raw() instead of sanitize_text_field() for custom tracking URL fields (meta box, AJAX handlers, REST API)
* Fix: 3 carrier tracking URLs changed from HTTP to HTTPS (Correios Brazil, SAPO South Africa, DB Schenker Sweden)
* Fix: load_plugin_textdomain() moved to init hook (was incorrectly using after_setup_theme)
* Fix: Admin notice updated to use current notice notice-error CSS classes
* Fix: Added uninstall.php with WP_UNINSTALL_PLUGIN guard (tracking data intentionally preserved)
* Fix: Removed donate link pointing to source code repository

= 1.2.0 =
* Fix: Updated all broken carrier Terms of Service and Privacy Policy URLs in the External services section
* Fix: Added explicit documentation for FedEx Sameday (fedexsameday.com), DB Schenker Privpak portal (privpakportal.schenker.nu), and An Post tracking portal (track.anpost.ie)
* Fix: Updated PPL.cz Terms and Privacy links to current working URLs
* Security: Added nonce verification to meta box save, shortcode tracking form, and order lookup
* Security: Resolved unclosed ob_start() pattern flagged by static analyzer
* Fix: REST API /providers endpoint permission_callback documented as intentionally public (read-only carrier catalogue)

= 1.1.1 =
* Fix: Removed external Google favicon calls — carrier icons are no longer loaded from google.com/s2/favicons
* Fix: All built-in carrier tracking URLs are now documented in the readme with Terms of Service and Privacy Policy links
* Fix: REST API permission callbacks now validate against the specific order_id being accessed or modified

= 1.1.0 =
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

= 1.2.6 =
Fixes the public tracking form for stores using sequential or custom order numbers, plus a more robust billing email check. Recommended update.

= 1.2.5 =
UI improvements: copy button in the orders list tracking column, cleaner Add Tracking form flow, and removal of the empty logo placeholder. Safe to update.

= 1.2.3 =
Compliance fixes: updated broken carrier URLs and removed unnecessary load_plugin_textdomain() call. Safe to update.

= 1.2.2 =
Compliance fixes: updated broken carrier URLs and corrected REST API permission check. Safe to update.

= 1.2.1 =
Compliance and security fixes: correct URL sanitization, HTTPS carrier links, textdomain hook fix. Safe to update.

= 1.2.0 =
Security and compliance fixes for WordPress.org guidelines: nonce verification added, carrier documentation URLs updated. Safe to update.

= 1.1.1 =
Compliance fixes for WordPress.org guidelines: removes external Google favicon requests and completes carrier documentation. Safe to update.

= 1.1.0 =
Visual improvement to the orders list tracking column. No database changes. Safe to update.
