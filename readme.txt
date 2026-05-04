=== Trackora - Shipment Tracker for WooCommerce ===
Contributors: slbarriosdev
Donate link: https://github.com/slbarriosdev/wc-shipment-tracker
Tags: woocommerce, tracking, shipment, shipping, order-tracking
Requires at least: 6.4
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.1.1
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

= Global =
* **Aramex** — [Terms of service](https://www.aramex.com/us/en/legal/terms-conditions) | [Privacy policy](https://www.aramex.com/us/en/legal/privacy-policy)
* **DHL Express** — [Terms of service](https://www.dhl.com/global-en/home/our-divisions/express/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/global-en/home/our-divisions/express/legal/privacy-notice.html)

= Argentina =
* **Correo Argentino** — [Terms of service](https://www.correoargentino.com.ar/terminos-y-condiciones) | [Privacy policy](https://www.correoargentino.com.ar/politica-de-privacidad)
* **OCA** — [Privacy policy](https://www.oca.com.ar/politica-de-privacidad)
* **Andreani** — [Privacy policy](https://www.andreani.com/politica-de-privacidad)
* **DHL Argentina** — [Terms of service](https://www.dhl.com/ar-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/ar-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)
* **FedEx Argentina** — [Terms of service](https://www.fedex.com/es-ar/terms-of-use.html) | [Privacy policy](https://www.fedex.com/es-ar/privacy-policy.html)
* **Urbano** — [Privacy policy](https://www.urbanoargentina.com.ar/politica-de-privacidad)

= Australia =
* **Australia Post** — [Terms of service](https://auspost.com.au/terms-conditions) | [Privacy policy](https://auspost.com.au/privacy)
* **Fastway Couriers** — [Terms of service](https://www.fastway.com.au/tools/track/terms-and-conditions) | [Privacy policy](https://www.fastway.com.au/privacy-policy)
* **Aramex Australia** — [Terms of service](https://www.aramex.com/au/en/legal/terms-conditions) | [Privacy policy](https://www.aramex.com/au/en/legal/privacy-policy)

= Austria =
* **post.at** — [Terms of service](https://www.post.at/en/footer/legal-information/terms-and-conditions) | [Privacy policy](https://www.post.at/en/footer/legal-information/privacy-policy)
* **dhl.at** — [Terms of service](https://www.dhl.com/at-de/home/rechtliche-hinweise/agb.html) | [Privacy policy](https://www.dhl.com/at-de/home/rechtliche-hinweise/datenschutz.html)
* **DPD.at** — [Terms of service](https://www.dpd.com/at/de/rechtliches/agb/) | [Privacy policy](https://www.dpd.com/at/de/rechtliches/datenschutz/)

= Belgium =
* **bpost** — [Terms of service](https://www.bpost.be/en/terms-and-conditions) | [Privacy policy](https://www.bpost.be/en/privacy-policy)

= Brazil =
* **Correios** — [Terms of service](https://www.correios.com.br/acesso-a-informacao/institucional/termos-de-uso) | [Privacy policy](https://www.correios.com.br/acesso-a-informacao/institucional/politica-de-privacidade)

= Canada =
* **Canada Post** — [Terms of service](https://www.canadapost-postescanada.ca/cpc/en/our-company/about-canada-post/corporate-responsibility/terms-of-use.page) | [Privacy policy](https://www.canadapost-postescanada.ca/cpc/en/our-company/about-canada-post/corporate-responsibility/privacy-policy.page)
* **Purolator** — [Terms of service](https://www.purolator.com/en/terms-and-conditions) | [Privacy policy](https://www.purolator.com/en/privacy-policy)

= Chile =
* **Correos Chile** — [Terms of service](https://www.correos.cl/web/guest/terminos-y-condiciones) | [Privacy policy](https://www.correos.cl/web/guest/politica-de-privacidad)
* **Chilexpress** — [Terms of service](https://www.chilexpress.cl/terminos-y-condiciones) | [Privacy policy](https://www.chilexpress.cl/politica-de-privacidad)
* **Starken** — [Privacy policy](https://www.starken.cl/politica-de-privacidad)
* **DHL Chile** — [Terms of service](https://www.dhl.com/cl-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/cl-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)
* **Blue Express** — [Privacy policy](https://www.blue.cl/politica-de-privacidad/)

= China =
* **China Post / EMS** — [Privacy policy](https://www.ems.com.cn/help/privacy.html)
* **YTO Express** — [Privacy policy](https://www.ytoexpress.com/privacy)
* **ZTO Express** — [Privacy policy](https://www.zto.com/privacypolicy)
* **SF Express** — [Privacy policy](https://www.sf-express.com/us/en/service_support/service_agreement/privacy_policy.html)
* **Cainiao** — [Privacy policy](https://privacy.alibabagroup.com/en/global)
* **4PX** — [Privacy policy](https://www.4px.com/privacy-policy)
* **Yanwen** — [Privacy policy](https://www.yanwen.com/en/privacy.html)
* **Yunexpress** — [Privacy policy](https://www.yuntrack.com/privacy)

= Colombia =
* **Servientrega** — [Terms of service](https://www.servientrega.com/wps/portal/Colombia/inicio/terminos-y-condiciones) | [Privacy policy](https://www.servientrega.com/wps/portal/Colombia/inicio/politica-de-privacidad)
* **Coordinadora** — [Privacy policy](https://www.coordinadora.com/politica-de-privacidad)
* **Deprisa** — [Privacy policy](https://www.deprisa.com/politica-de-privacidad/)
* **TCC** — [Privacy policy](https://www.tcc.com.co/politica-de-privacidad)
* **DHL Colombia** — [Terms of service](https://www.dhl.com/co-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/co-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)
* **J&T Express CO** — [Privacy policy](https://www.jtexpress.co/privacy)
* **Interrapidisimo** — [Privacy policy](https://www.interrapidisimo.com/politica-de-privacidad/)

= Czech Republic =
* **PPL.cz** — [Terms of service](https://www.ppl.cz/main2.aspx?cls=ArticleDetail&idart=141) | [Privacy policy](https://www.ppl.cz/main2.aspx?cls=ArticleDetail&idart=140)
* **Česká pošta** — [Terms of service](https://www.ceskaposta.cz/ke-stazeni/informace-o-zpracovani-osobnich-udaju) | [Privacy policy](https://www.ceskaposta.cz/ke-stazeni/informace-o-zpracovani-osobnich-udaju)
* **DHL.cz** — [Terms of service](https://www.dhl.com/cz-cs/home/nase-divize/express/pravni-informace/obchodni-podminky.html) | [Privacy policy](https://www.dhl.com/cz-cs/home/nase-divize/express/pravni-informace/ochrana-osobnich-udaju.html)
* **DPD.cz** — [Terms of service](https://www.dpd.com/cz/cs/pravni-informace/podminky-pouzivani/) | [Privacy policy](https://www.dpd.com/cz/cs/pravni-informace/ochrana-osobnich-udaju/)

= Ecuador =
* **Servientrega EC** — [Privacy policy](https://www.servientrega.com.ec/politica-de-privacidad)
* **Laar Courier** — [Privacy policy](https://www.laarcourier.com/privacidad)
* **Correos Ecuador** — [Privacy policy](https://www.correos.gob.ec/politica-de-privacidad/)
* **DHL Ecuador** — [Terms of service](https://www.dhl.com/ec-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/ec-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)

= Finland =
* **Itella / Posti** — [Terms of service](https://www.posti.fi/en/customer-support/terms-and-conditions/) | [Privacy policy](https://www.posti.fi/en/customer-support/privacy/)

= France =
* **Colissimo / La Poste** — [Terms of service](https://www.laposte.fr/mentions-legales) | [Privacy policy](https://www.laposte.fr/politique-de-protection-des-donnees)

= Germany =
* **DHL Intraship / Deutsche Post DHL** — [Terms of service](https://www.dhl.de/de/privatkunden/hilfe/rechtliche-hinweise.html) | [Privacy policy](https://www.dhl.de/de/privatkunden/hilfe/datenschutz.html)
* **Hermes** — [Terms of service](https://www.myhermes.de/agb/) | [Privacy policy](https://www.myhermes.de/datenschutz/)
* **UPS Germany** — [Terms of service](https://www.ups.com/de/de/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/de/de/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **DPD.de** — [Terms of service](https://www.dpd.com/de/de/nutzungsbedingungen/) | [Privacy policy](https://www.dpd.com/de/de/datenschutz/)

= India =
* **DTDC** — [Terms of service](https://www.dtdc.in/terms-condition.asp) | [Privacy policy](https://www.dtdc.in/privacy-policy.asp)

= Ireland =
* **DPD.ie** — [Terms of service](https://dpd.ie/terms-and-conditions) | [Privacy policy](https://dpd.ie/privacy-policy)
* **An Post** — [Terms of service](https://www.anpost.com/terms-and-conditions) | [Privacy policy](https://www.anpost.com/privacy)

= Italy =
* **BRT (Bartolini)** — [Terms of service](https://www.brt.it/note-legali/) | [Privacy policy](https://www.brt.it/privacy/)
* **DHL Express Italy** — [Terms of service](https://www.dhl.com/it-it/home/divisioni/express/informazioni-legali/termini-e-condizioni.html) | [Privacy policy](https://www.dhl.com/it-it/home/divisioni/express/informazioni-legali/informativa-sulla-privacy.html)

= Japan =
* **Japan Post** — [Terms of service](https://www.post.japanpost.jp/legal/) | [Privacy policy](https://www.japanpost.jp/privacy/)
* **Yamato Transport** — [Privacy policy](https://www.kuronekoyamato.co.jp/ytc/privacy/)
* **Sagawa** — [Privacy policy](https://www.sagawa-exp.co.jp/privacy/)

= Malaysia =
* **Pos Malaysia** — [Terms of service](https://www.pos.com.my/footer-links/terms-and-conditions) | [Privacy policy](https://www.pos.com.my/footer-links/privacy-policy)
* **J&T Express MY** — [Privacy policy](https://www.jtexpress.my/privacy-policy)
* **Ninja Van MY** — [Privacy policy](https://www.ninjavan.co/en-my/privacy-policy)
* **DHL Malaysia** — [Terms of service](https://www.dhl.com/my-en/home/our-divisions/express/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/my-en/home/our-divisions/express/legal/privacy-notice.html)

= Mexico =
* **Correos de Mexico** — [Terms of service](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Terminos.aspx) | [Privacy policy](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Aviso.aspx)
* **Estafeta** — [Terms of service](https://www.estafeta.com/aviso-legal) | [Privacy policy](https://www.estafeta.com/aviso-de-privacidad)
* **Paquetexpress** — [Privacy policy](https://www.paquetexpress.com.mx/aviso-de-privacidad)
* **Redpack** — [Privacy policy](https://www.redpack.com.mx/es/aviso-de-privacidad/)
* **DHL Mexico** — [Terms of service](https://www.dhl.com/mx-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/mx-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)
* **FedEx Mexico** — [Terms of service](https://www.fedex.com/es-mx/terms-of-use.html) | [Privacy policy](https://www.fedex.com/es-mx/privacy-policy.html)
* **UPS Mexico** — [Terms of service](https://www.ups.com/mx/es/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/mx/es/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **Coordinadora** — [Privacy policy](https://www.coordinadora.com/politica-de-privacidad)
* **J&T Express Mexico** — [Privacy policy](https://www.jtexpress.mx/privacy-policy)

= Netherlands =
* **PostNL** — [Terms of service](https://www.postnl.nl/algemene-voorwaarden/) | [Privacy policy](https://www.postnl.nl/privacy/)
* **DPD.NL** — [Terms of service](https://www.dpd.com/nl/nl/juridische-informatie/gebruiksvoorwaarden/) | [Privacy policy](https://www.dpd.com/nl/nl/juridische-informatie/privacybeleid/)
* **UPS Netherlands** — [Terms of service](https://www.ups.com/nl/nl/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/nl/nl/support/shipping-support/legal-terms-conditions/privacy-notice.page)

= New Zealand =
* **NZ Post** — [Terms of service](https://www.nzpost.co.nz/about-nz-post/terms-and-conditions) | [Privacy policy](https://www.nzpost.co.nz/about-nz-post/privacy-policy)
* **Courier Post** — [Terms of service](https://www.courierpost.co.nz/help/terms-conditions) | [Privacy policy](https://www.courierpost.co.nz/help/privacy-policy)
* **Aramex New Zealand** — [Terms of service](https://www.aramex.co.nz/legal/terms-conditions) | [Privacy policy](https://www.aramex.co.nz/legal/privacy-policy)

= Nigeria =
* **DHL Nigeria** — [Terms of service](https://www.dhl.com/ng-en/home/our-divisions/express/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/ng-en/home/our-divisions/express/legal/privacy-notice.html)
* **GIG Logistics** — [Privacy policy](https://giglogistics.com/privacy-policy)

= Peru =
* **Serpost** — [Privacy policy](https://www.serpost.com.pe/aviso-de-privacidad)
* **Olva Courier** — [Privacy policy](https://www.olvacourier.com/politica-de-privacidad)
* **DHL Peru** — [Terms of service](https://www.dhl.com/pe-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/pe-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)
* **Shalom** — [Privacy policy](https://www.gremcorp.com.pe/shalomweb/politica-de-privacidad)

= Poland =
* **InPost** — [Terms of service](https://inpost.pl/regulaminy) | [Privacy policy](https://inpost.pl/polityka-prywatnosci)
* **DPD.PL** — [Terms of service](https://www.dpd.com/pl/pl/informacje-prawne/warunki-korzystania/) | [Privacy policy](https://www.dpd.com/pl/pl/informacje-prawne/polityka-prywatnosci/)
* **Poczta Polska** — [Terms of service](https://www.poczta-polska.pl/regulaminy/) | [Privacy policy](https://www.poczta-polska.pl/polityka-prywatnosci/)

= Portugal =
* **CTT** — [Terms of service](https://www.ctt.pt/ctt/termos-e-condicoes) | [Privacy policy](https://www.ctt.pt/ctt/politica-de-privacidade)
* **DPD Portugal** — [Terms of service](https://www.dpd.com/pt/pt/informacao-legal/condicoes-de-utilizacao/) | [Privacy policy](https://www.dpd.com/pt/pt/informacao-legal/politica-de-privacidade/)
* **GLS Portugal** — [Terms of service](https://gls-group.com/PT/pt/informacao-legal) | [Privacy policy](https://gls-group.com/PT/pt/politica-de-privacidade)
* **DHL Portugal** — [Terms of service](https://www.dhl.com/pt-pt/home/as-nossas-divisoes/express/informacao-legal/termos-e-condicoes.html) | [Privacy policy](https://www.dhl.com/pt-pt/home/as-nossas-divisoes/express/informacao-legal/aviso-de-privacidade.html)

= Romania =
* **Fan Courier** — [Terms of service](https://www.fancourier.ro/termeni-conditii/) | [Privacy policy](https://www.fancourier.ro/politica-de-confidentialitate/)
* **DPD Romania** — [Terms of service](https://www.dpd.com/ro/ro/informatii-legale/termeni-si-conditii/) | [Privacy policy](https://www.dpd.com/ro/ro/informatii-legale/politica-de-confidentialitate/)
* **Urgent Cargus** — [Terms of service](https://www.urgentcargus.ro/termeni-si-conditii) | [Privacy policy](https://www.urgentcargus.ro/politica-de-confidentialitate)

= Singapore =
* **SingPost** — [Terms of service](https://www.singpost.com/terms-of-use) | [Privacy policy](https://www.singpost.com/privacy-policy)
* **Ninja Van SG** — [Privacy policy](https://www.ninjavan.co/en-sg/privacy-policy)
* **J&T Express SG** — [Privacy policy](https://www.jtexpress.sg/privacy-policy)

= South Africa =
* **SAPO / South African Post Office** — [Privacy policy](https://www.postoffice.co.za/privacy-policy)
* **Fastway SA** — [Privacy policy](https://fastway.co.za/privacy-policy)
* **EPX** — [Privacy policy](https://epx.pperfect.com/privacy)

= South Korea =
* **Korea Post** — [Privacy policy](https://www.koreapost.go.kr/privacy.do)
* **CJ Logistics** — [Privacy policy](https://www.cjlogistics.com/ko/privacy)
* **Lotte Logistics** — [Privacy policy](https://www.lotteglogis.com/home/about/privacy)

= Spain =
* **Correos España** — [Terms of service](https://www.correos.es/es/es/particulares/legal/condiciones-de-uso) | [Privacy policy](https://www.correos.es/es/es/particulares/legal/politica-de-privacidad)
* **MRW** — [Terms of service](https://www.mrw.es/informacion/condiciones-de-uso) | [Privacy policy](https://www.mrw.es/informacion/politica-de-privacidad)
* **SEUR** — [Terms of service](https://www.seur.com/es/condiciones-de-uso.shtml) | [Privacy policy](https://www.seur.com/es/politica-de-privacidad.shtml)
* **GLS Spain** — [Terms of service](https://gls-group.com/ES/es/informacion-legal) | [Privacy policy](https://gls-group.com/ES/es/politica-de-privacidad)
* **Nacex** — [Terms of service](https://www.nacex.es/condiciones-legales-de-uso-de-la-web.do) | [Privacy policy](https://www.nacex.es/politica-de-privacidad.do)
* **DHL Spain** — [Terms of service](https://www.dhl.com/es-es/home/divisiones/express/informacion-legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/es-es/home/divisiones/express/informacion-legal/aviso-de-privacidad.html)
* **UPS Spain** — [Terms of service](https://www.ups.com/es/es/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/es/es/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **DPD Spain** — [Terms of service](https://www.dpd.com/es/es/informacion-legal/condiciones-de-uso/) | [Privacy policy](https://www.dpd.com/es/es/informacion-legal/politica-de-privacidad/)
* **ASM** — [Privacy policy](https://www.asm-spain.com/politica-de-privacidad/)
* **Correos Express** — [Terms of service](https://www.correosexpress.com/web/correosexpress/condiciones-de-uso) | [Privacy policy](https://www.correosexpress.com/web/correosexpress/politica-de-privacidad)
* **Zeleris** — [Privacy policy](https://www.zeleris.com/en/privacy-policy/)
* **TNT Spain** — [Terms of service](https://www.tnt.com/express/es_es/site/terminos-y-condiciones.html) | [Privacy policy](https://www.tnt.com/express/es_es/site/politica-de-privacidad.html)

= Sweden =
* **PostNord** — [Terms of service](https://www.postnord.com/en/terms-and-conditions) | [Privacy policy](https://www.postnord.com/en/privacy)
* **DHL.se** — [Terms of service](https://www.dhl.com/se-sv/home/vara-divisioner/express/juridisk-information/allmanna-villkor.html) | [Privacy policy](https://www.dhl.com/se-sv/home/vara-divisioner/express/juridisk-information/integritetspolicy.html)
* **Bring.se** — [Terms of service](https://www.bring.se/om-bring/integritetspolicy) | [Privacy policy](https://www.bring.se/om-bring/integritetspolicy)
* **UPS.se** — [Terms of service](https://www.ups.com/se/sv/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/se/sv/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **DB Schenker** — [Terms of service](https://www.dbschenker.com/global-en/meta/legal-notice) | [Privacy policy](https://www.dbschenker.com/global-en/meta/privacy-policy)

= Thailand =
* **Thailand Post** — [Terms of service](https://www.thailandpost.co.th/en/terms-and-conditions) | [Privacy policy](https://www.thailandpost.co.th/en/privacy-policy)
* **Kerry Express** — [Privacy policy](https://th.kerryexpress.com/en/privacy-policy/)
* **Flash Express** — [Privacy policy](https://www.flashexpress.co.th/privacy-policy/)
* **J&T Express TH** — [Privacy policy](https://www.jtexpress.co.th/privacy-policy)

= Turkey =
* **PTT** — [Privacy policy](https://www.ptt.gov.tr/gizlilik-politikasi)
* **Aras Cargo** — [Terms of service](https://www.araskargo.com.tr/kullanim-kosullari) | [Privacy policy](https://www.araskargo.com.tr/gizlilik-politikasi)
* **Yurtici Kargo** — [Privacy policy](https://www.yurticikargo.com/tr/hakkimizda/gizlilik-politikasi)
* **MNG Kargo** — [Privacy policy](https://www.mngkargo.com.tr/gizlilik-politikasi)

= United Kingdom =
* **DHL UK** — [Terms of service](https://www.dhl.com/gb-en/home/our-divisions/express/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/gb-en/home/our-divisions/express/legal/privacy-notice.html)
* **DPD.co.uk** — [Terms of service](https://www.dpd.co.uk/content/legal_info/terms_conditions.jsp) | [Privacy policy](https://www.dpd.co.uk/content/legal_info/privacy_policy.jsp)
* **DPD Local** — [Terms of service](https://www.dpdlocal.co.uk/terms-and-conditions/) | [Privacy policy](https://www.dpdlocal.co.uk/privacy-policy/)
* **EVRi** — [Terms of service](https://www.evri.com/terms-and-conditions) | [Privacy policy](https://www.evri.com/privacy-policy)
* **ParcelForce** — [Terms of service](https://www.parcelforce.com/terms-conditions) | [Privacy policy](https://www.parcelforce.com/privacy-cookies)
* **Royal Mail** — [Terms of service](https://www.royalmail.com/terms-and-conditions) | [Privacy policy](https://www.royalmail.com/privacy-policy)
* **TNT Express** — [Terms of service](https://www.tnt.com/express/en_gb/site/terms-conditions.html) | [Privacy policy](https://www.tnt.com/express/en_gb/site/privacy-policy.html)
* **DHL Parcel UK** — [Terms of service](https://www.dhl.com/gb-en/home/our-divisions/parcel/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/gb-en/home/our-divisions/parcel/legal/privacy-notice.html)
* **City Link** — [Privacy policy](https://www.citylink.co.uk/privacy-policy/)

= United States =
* **UPS** — [Terms of service](https://www.ups.com/us/en/support/shipping-support/legal-terms-conditions.page) | [Privacy policy](https://www.ups.com/us/en/support/shipping-support/legal-terms-conditions/privacy-notice.page)
* **FedEx / FedEx Sameday** — [Terms of service](https://www.fedex.com/en-us/terms-of-use.html) | [Privacy policy](https://www.fedex.com/en-us/privacy-policy.html)
* **USPS** — [Terms of service](https://www.usps.com/terms-of-use.htm) | [Privacy policy](https://www.usps.com/privacypolicy.htm)
* **DHL US / DHL eCommerce** — [Terms of service](https://www.dhl.com/us-en/home/our-divisions/ecommerce/legal/terms-and-conditions.html) | [Privacy policy](https://www.dhl.com/us-en/home/our-divisions/ecommerce/legal/privacy-notice.html)
* **GlobalPost** — [Terms of service](https://www.goglobalpost.com/terms/) | [Privacy policy](https://www.goglobalpost.com/privacy/)
* **OnTrac** — [Terms of service](https://www.ontrac.com/termsconditions.asp) | [Privacy policy](https://www.ontrac.com/privacy.asp)

= Venezuela =
* **MRW Venezuela** — [Privacy policy](https://www.mrw.com.ve/aviso-de-privacidad/)
* **Zoom** — [Privacy policy](https://www.zoom.com.ve/aviso-de-privacidad/)
* **DHL Venezuela** — [Terms of service](https://www.dhl.com/ve-es/home/nuestras-divisiones/express/legal/terminos-y-condiciones.html) | [Privacy policy](https://www.dhl.com/ve-es/home/nuestras-divisiones/express/legal/aviso-de-privacidad.html)

== Changelog ==

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

= 1.1.1 =
Compliance fixes for WordPress.org guidelines: removes external Google favicon requests and completes carrier documentation. Safe to update.

= 1.1.0 =
Visual improvement to the orders list tracking column. No database changes. Safe to update.
