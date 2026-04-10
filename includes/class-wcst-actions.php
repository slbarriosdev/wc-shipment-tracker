<?php
/**
 * WCST_Actions – business logic, meta box, admin columns, emails.
 *
 * @package WC_Shipment_Tracker
 */

defined( 'ABSPATH' ) || exit;

use WCShipmentTracker\Order_Util;

class WCST_Actions {

	use Order_Util;

	/** @var self */
	private static $instance;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	// =========================================================================
	// PROVIDERS
	// =========================================================================

	/**
	 * Returns all shipping providers grouped by country/region.
	 *
	 * @return array
	 */
	public function get_providers() {
		return apply_filters(
			'wcst_get_providers',
			array(
				'United States'  => array(
					'DHL US'        => 'https://www.logistics.dhl/us-en/home/tracking/tracking-ecommerce.html?tracking-id=%1$s',
					'DHL eCommerce' => 'https://webtrack.dhlecs.com/orders?trackingNumber=%1$s',
					'Fedex'         => 'https://www.fedex.com/apps/fedextrack/?action=track&action=track&tracknumbers=%1$s',
					'FedEx Sameday' => 'https://www.fedexsameday.com/fdx_dotracking_ua.aspx?tracknum=%1$s',
					'GlobalPost'    => 'https://www.goglobalpost.com/track-detail/?t=%1$s',
					'OnTrac'        => 'https://www.ontrac.com/tracking/?number=%1$s',
					'UPS'           => 'https://www.ups.com/track?loc=en_US&tracknum=%1$s',
					'USPS'          => 'https://tools.usps.com/go/TrackConfirmAction_input?qtc_tLabels1=%1$s',
				),
				'Global'         => array(
					'Aramex' => 'https://www.aramex.com/track/track-results-new?ShipmentNumber=%1$s',
				),
				'Australia'      => array(
					'Australia Post'   => 'https://auspost.com.au/mypost/track/#/details/%1$s',
					'Fastway Couriers' => 'https://www.fastway.com.au/tools/track/?l=%1$s',
					'Aramex Australia' => 'https://www.aramex.com.au/tools/track?l=%1$s',
				),
				'Austria'        => array(
					'post.at' => 'https://www.post.at/sv/sendungsdetails?snr=%1$s',
					'dhl.at'  => 'https://www.dhl.at/content/at/de/express/sendungsverfolgung.html?brand=DHL&AWB=%1$s',
					'DPD.at'  => 'https://tracking.dpd.de/parcelstatus?locale=de_AT&query=%1$s',
				),
				'Brazil'         => array(
					'Correios' => 'http://websro.correios.com.br/sro_bin/txect01$.QueryList?P_LINGUA=001&P_TIPO=001&P_COD_UNI=%1$s',
				),
				'Belgium'        => array(
					'bpost' => 'https://track.bpost.be/btr/web/#/search?itemCode=%1$s&postalCode=%2$s',
				),
				'Canada'         => array(
					'Canada Post' => 'https://www.canadapost-postescanada.ca/track-reperage/en#/resultList?searchFor=%1$s',
					'Purolator'   => 'https://www.purolator.com/purolator/ship-track/tracking-summary.page?pin=%1$s',
				),
				'Czech Republic' => array(
					'PPL.cz'      => 'https://www.ppl.cz/main2.aspx?cls=Package&idSearch=%1$s',
					'Česká pošta' => 'https://www.postaonline.cz/trackandtrace/-/zasilka/cislo?parcelNumbers=%1$s',
					'DHL.cz'      => 'https://www.dhl.cz/cs/express/sledovani_zasilek.html?AWB=%1$s',
					'DPD.cz'      => 'https://tracking.dpd.de/parcelstatus?locale=cs_CZ&query=%1$s',
				),
				'Finland'        => array(
					'Itella' => 'https://www.posti.fi/itemtracking/posti/search_by_shipment_id?lang=en&ShipmentId=%1$s',
				),
				'France'         => array(
					'Colissimo' => 'https://www.laposte.fr/outils/suivre-vos-envois?code=%1$s',
				),
				'Germany'        => array(
					'DHL Intraship (DE)' => 'https://www.dhl.de/de/privatkunden/pakete-empfangen/verfolgen.html?lang=de&idc=%1$s&rfn=&extendedSearch=true',
					'Hermes'             => 'https://www.myhermes.de/empfangen/sendungsverfolgung/sendungsinformation/#%1$s',
					'Deutsche Post DHL'  => 'https://www.dhl.de/de/privatkunden/pakete-empfangen/verfolgen.html?lang=de&idc=%1$s',
					'UPS Germany'        => 'https://wwwapps.ups.com/WebTracking?sort_by=status&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=de_DE&InquiryNumber1=%1$s',
					'DPD.de'             => 'https://tracking.dpd.de/parcelstatus?query=%1$s&locale=en_DE',
				),
				'Ireland'        => array(
					'DPD.ie'  => 'https://dpd.ie/tracking?deviceType=5&consignmentNumber=%1$s',
					'An Post' => 'https://track.anpost.ie/TrackingResults.aspx?rtt=1&items=%1$s',
				),
				'Italy'          => array(
					'BRT (Bartolini)' => 'https://vas.brt.it/vas/sped_det_show.hsm?Nspediz=%1$s',
					'DHL Express'     => 'https://www.dhl.it/it/express/ricerca.html?AWB=%1$s&brand=DHL',
				),
				'India'          => array(
					'DTDC' => 'https://www.dtdc.in/tracking/tracking_results.asp?Ttype=awb_no&strCnno=%1$s&TrkType2=awb_no',
				),
				'Netherlands'    => array(
					'PostNL'          => 'https://postnl.nl/tracktrace/?B=%1$s&P=%2$s&D=%3$s&T=C',
					'DPD.NL'          => 'https://tracking.dpd.de/status/en_US/parcel/%1$s',
					'UPS Netherlands' => 'https://wwwapps.ups.com/WebTracking?sort_by=status&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=nl_NL&InquiryNumber1=%1$s',
				),
				'New Zealand'    => array(
					'Courier Post'       => 'https://trackandtrace.courierpost.co.nz/Search/%1$s',
					'NZ Post'            => 'https://www.nzpost.co.nz/tools/tracking?trackid=%1$s',
					'Aramex New Zealand' => 'https://www.aramex.co.nz/tools/track?l=%1$s',
				),
				'Poland'         => array(
					'InPost'        => 'https://inpost.pl/sledzenie-przesylek?number=%1$s',
					'DPD.PL'        => 'https://tracktrace.dpd.com.pl/parcelDetails?p1=%1$s',
					'Poczta Polska' => 'https://emonitoring.poczta-polska.pl/?numer=%1$s',
				),
				'Romania'        => array(
					'Fan Courier'   => 'https://www.fancourier.ro/awb-tracking/?tracking=%1$s',
					'DPD Romania'   => 'https://tracking.dpd.de/parcelstatus?query=%1$s&locale=ro_RO',
					'Urgent Cargus' => 'https://app.urgentcargus.ro/Private/Tracking.aspx?CodBara=%1$s',
				),
				'South Africa'   => array(
					'SAPO'    => 'http://sms.postoffice.co.za/TrackingParcels/Parcel.aspx?id=%1$s',
					'Fastway' => 'https://fastway.co.za/our-services/track-your-parcel?l=%1$s',
					'EPX'     => 'https://epx.pperfect.com/?w=%1$s',
				),
				'Sweden'         => array(
					'PostNord Sverige AB' => 'https://portal.postnord.com/tracking/details/%1$s',
					'DHL.se'              => 'https://www.dhl.com/se-sv/home/tracking.html?submit=1&tracking-id=%1$s',
					'Bring.se'            => 'https://tracking.bring.se/tracking/%1$s',
					'UPS.se'              => 'https://www.ups.com/track?loc=sv_SE&tracknum=%1$s&requester=WT/',
					'DB Schenker'         => 'http://privpakportal.schenker.nu/TrackAndTrace/packagesearch.aspx?packageId=%1$s',
				),
				'United Kingdom' => array(
					'DHL'                       => 'https://www.dhl.com/content/g0/en/express/tracking.shtml?brand=DHL&AWB=%1$s',
					'DPD.co.uk'                 => 'https://www.dpd.co.uk/apps/tracking/?reference=%1$s#results',
					'DPD Local'                 => 'https://apis.track.dpdlocal.co.uk/v1/track?postcode=%2$s&parcel=%1$s',
					'EVRi'                      => 'https://www.evri.com/track/parcel/%1$s',
					'EVRi (international)'      => 'https://international.evri.com/tracking/%1$s',
					'ParcelForce'               => 'https://www.parcelforce.com/track-trace?trackNumber=%1$s',
					'Royal Mail'                => 'https://www3.royalmail.com/track-your-item#/tracking-results/%1$s',
					'TNT Express (consignment)' => 'https://www.tnt.com/express/en_gb/site/shipping-tools/tracking.html?searchType=con&cons=%1$s',
					'TNT Express (reference)'   => 'https://www.tnt.com/express/en_gb/site/shipping-tools/tracking.html?searchType=ref&cons=%1$s',
					'DHL Parcel UK'             => 'https://track.dhlparcel.co.uk/?con=%1$s',
					'City Link'                 => 'https://www.citylink.co.uk/citylink_v6/track-my-parcel/?con=%1$s',
				),
				'Spain'          => array(
					'Correos Espana'  => 'https://www.correos.es/ss/Satellite/site/aplicacion-1363966029554-rastreador_busqueda/sidioma=es_ES&tracking=%1$s',
					'MRW'             => 'https://www.mrw.es/seguimiento_envios/MRW_internet.asp?Franq=&Ag=&Ser=0&Numero=%1$s',
					'SEUR'            => 'https://www.seur.com/es/seguimiento/?referencia=%1$s',
					'GLS Spain'       => 'https://gls-group.com/ES/es/seguimiento-envio?match=%1$s',
					'Nacex'           => 'https://www.nacex.es/go.do?urlAProxy=https://nacex.es/nacex/Seguimiento/SeguimientoEnvio.aspx?nEnv=%1$s',
					'DHL Spain'       => 'https://www.dhl.com/es-es/home/tracking.html?tracking-id=%1$s',
					'UPS Spain'       => 'https://www.ups.com/track?loc=es_ES&tracknum=%1$s',
					'DPD Spain'       => 'https://tracking.dpd.de/parcelstatus?locale=es_ES&query=%1$s',
					'ASM'             => 'https://www.asm-spain.com/herramientas/seguimiento/?expedicion=%1$s',
					'Correos Express' => 'https://www.correosexpress.com/web/correosexpress/home?numerosEnvio=%1$s',
					'Zeleris'         => 'https://www.zeleris.com/en/tracking/?lang=es&track=%1$s',
					'TNT Spain'       => 'https://www.tnt.com/express/es_es/site/shipping-tools/tracking.html?searchType=con&cons=%1$s',
				),
				'Mexico'         => array(
					'Estafeta'           => 'https://www.estafeta.com/Rastreo/Estado?wayBillNumber=%1$s',
					'Paquetexpress'      => 'https://www.paquetexpress.com.mx/rastreo?guia=%1$s',
					'Redpack'            => 'https://www.redpack.com.mx/es/rastreo/?tracking=%1$s',
					'DHL Mexico'         => 'https://www.dhl.com/mx-es/home/rastreo.html?tracking-id=%1$s',
					'FedEx Mexico'       => 'https://www.fedex.com/es-mx/tracking.html?tracknumbers=%1$s',
					'UPS Mexico'         => 'https://www.ups.com/track?loc=es_MX&tracknum=%1$s',
					'Correos de Mexico'  => 'https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Rastreo.aspx?num=%1$s',
					'Coordinadora MX'    => 'https://www.coordinadora.com/portafolio-de-servicios/servicios-en-linea/rastrear-guias/?guia=%1$s',
					'J&T Express Mexico' => 'https://www.jtexpress.mx/trajectoryQuery?billCode=%1$s',
				),
				'Colombia'       => array(
					'Servientrega'       => 'https://www.servientrega.com/wps/portal/rastreo-envios?tracking=%1$s',
					'Coordinadora CO'    => 'https://www.coordinadora.com/portafolio-de-servicios/servicios-en-linea/rastrear-guias/?guia=%1$s',
					'Deprisa'            => 'https://www.deprisa.com/rastreo/?numero=%1$s',
					'TCC'                => 'https://www.tcc.com.co/rastreo?guia=%1$s',
					'DHL Colombia'       => 'https://www.dhl.com/co-es/home/rastreo.html?tracking-id=%1$s',
					'J&T Express CO'     => 'https://www.jtexpress.co/trajectoryQuery?billCode=%1$s',
					'Interrapidisimo'    => 'https://www.interrapidisimo.com/rastreo/?numero=%1$s',
				),
				'Argentina'      => array(
					'Correo Argentino'   => 'https://www.correoargentino.com.ar/formularios/spi?id=%1$s',
					'OCA'                => 'https://www.oca.com.ar/home/rastreoseguimiento?numero=%1$s',
					'Andreani'           => 'https://www.andreani.com/#!/rastreo?tracking=%1$s',
					'DHL Argentina'      => 'https://www.dhl.com/ar-es/home/rastreo.html?tracking-id=%1$s',
					'FedEx Argentina'    => 'https://www.fedex.com/es-ar/tracking.html?tracknumbers=%1$s',
					'Urbano'             => 'https://www.urbanoargentina.com.ar/tracking?numero=%1$s',
				),
				'Chile'          => array(
					'Correos Chile'  => 'https://www.correos.cl/SitePages/rastreo/rastreo.aspx?envio=%1$s',
					'Chilexpress'    => 'https://www.chilexpress.cl/realizar-un-envio/rastrear-envio/?tracking=%1$s',
					'Starken'        => 'https://www.starken.cl/seguimiento?codigo=%1$s',
					'DHL Chile'      => 'https://www.dhl.com/cl-es/home/rastreo.html?tracking-id=%1$s',
					'Blue Express'   => 'https://www.blue.cl/seguimiento/?numero=%1$s',
				),
				'Peru'           => array(
					'Serpost'        => 'https://www.serpost.com.pe/trackingW/tracking?nroenvio=%1$s',
					'Olva Courier'   => 'https://www.olvacourier.com/rastreo?codigo=%1$s',
					'DHL Peru'       => 'https://www.dhl.com/pe-es/home/rastreo.html?tracking-id=%1$s',
					'Shalom'         => 'https://www.gremcorp.com.pe/shalomweb/seguimiento?tracking=%1$s',
				),
				'Ecuador'        => array(
					'Servientrega EC'    => 'https://www.servientrega.com.ec/wps/portal/Servientrega/rastreo?tracking=%1$s',
					'Laar Courier'       => 'https://www.laarcourier.com/rastreo?guia=%1$s',
					'Correos Ecuador'    => 'https://www.correos.gob.ec/rastreo-de-envios/?tracking=%1$s',
					'DHL Ecuador'        => 'https://www.dhl.com/ec-es/home/rastreo.html?tracking-id=%1$s',
				),
				'Venezuela'      => array(
					'MRW Venezuela'  => 'https://www.mrw.com.ve/seguimiento/?numero=%1$s',
					'Zoom'           => 'https://www.zoom.com.ve/rastreo/?guia=%1$s',
					'DHL Venezuela'  => 'https://www.dhl.com/ve-es/home/rastreo.html?tracking-id=%1$s',
				),
				'Portugal'       => array(
					'CTT'            => 'https://www.ctt.pt/feapl_2/app/open/objectSearch/objectSearch.jspx?lang=def&s=%1$s',
					'DPD Portugal'   => 'https://tracking.dpd.de/parcelstatus?locale=pt_PT&query=%1$s',
					'GLS Portugal'   => 'https://gls-group.com/PT/pt/seguimento-envio?match=%1$s',
					'DHL Portugal'   => 'https://www.dhl.com/pt-pt/home/rastreio.html?tracking-id=%1$s',
				),
				'China'          => array(
					'China Post'     => 'https://yjcx.ems.com.cn/qps/english/yjcx?mailno=%1$s',
					'YTO Express'    => 'https://www.ytoexpress.com/track?no=%1$s',
					'ZTO Express'    => 'https://www.zto.com/GuestService/Trace?billcode=%1$s',
					'SF Express'     => 'https://www.sf-express.com/cn/en/dynamic_function/waybill/#search/bill-number/%1$s',
					'Cainiao'        => 'https://global.cainiao.com/detail.htm?mailNo=%1$s',
					'4PX'            => 'https://track.4px.com/#/result/0/%1$s',
					'Yanwen'         => 'https://track.yanwen.com/track?tracking_no=%1$s',
					'Yunexpress'     => 'https://www.yuntrack.com/track?id=%1$s',
				),
				'Japan'          => array(
					'Japan Post'         => 'https://trackings.post.japanpost.jp/services/srv/search/direct?locale=en&reqCodeNo1=%1$s',
					'Yamato Transport'   => 'https://toi.kuronekoyamato.co.jp/cgi-bin/tneko?number=%1$s',
					'Sagawa'             => 'https://k2k.sagawa-exp.co.jp/p/sagawa/web/okurijoinput.jsp?okurijoi=%1$s',
				),
				'South Korea'    => array(
					'Korea Post'         => 'https://service.epost.go.kr/trace.RetrieveEmsRigiTraceList.comm?POST_CODE=%1$s',
					'CJ Logistics'       => 'https://www.cjlogistics.com/ko/tool/parcel/tracking?gnbInvcNo=%1$s',
					'Lotte Logistics'    => 'https://www.lotteglogis.com/home/reservation/tracking/index?invNo=%1$s',
				),
				'Singapore'      => array(
					'SingPost'       => 'https://www.singpost.com/track-items?trackingNumber=%1$s',
					'Ninja Van SG'   => 'https://www.ninjavan.co/en-sg/tracking?id=%1$s',
					'J&T Express SG' => 'https://www.jtexpress.sg/trajectoryQuery?billCode=%1$s',
				),
				'Malaysia'       => array(
					'Pos Malaysia'   => 'https://www.pos.com.my/postal-services/parcel-mail-services/?trackNo=%1$s',
					'J&T Express MY' => 'https://www.jtexpress.my/trajectoryQuery?billCode=%1$s',
					'Ninja Van MY'   => 'https://www.ninjavan.co/en-my/tracking?id=%1$s',
					'DHL Malaysia'   => 'https://www.dhl.com/my-en/home/tracking.html?tracking-id=%1$s',
				),
				'Thailand'       => array(
					'Thailand Post'  => 'https://track.thailandpost.co.th/?trackNumber=%1$s',
					'Kerry Express'  => 'https://th.kerryexpress.com/en/track/?track=%1$s',
					'Flash Express'  => 'https://www.flashexpress.co.th/tracking/?se=%1$s',
					'J&T Express TH' => 'https://www.jtexpress.co.th/trajectoryQuery?billCode=%1$s',
				),
				'Turkey'         => array(
					'PTT'            => 'https://gonderitakip.ptt.gov.tr/Track/Verify?q=%1$s',
					'Aras Cargo'     => 'https://kargotakip.araskargo.com.tr/mainpage.aspx?code=%1$s',
					'Yurtici Kargo'  => 'https://www.yurticikargo.com/tr/online-islemler/gonderi-sorgula?code=%1$s',
					'MNG Kargo'      => 'https://www.mngkargo.com.tr/kargotakip?trackingNumber=%1$s',
				),
				'Nigeria'        => array(
					'DHL Nigeria'    => 'https://www.dhl.com/ng-en/home/tracking.html?tracking-id=%1$s',
					'GIG Logistics'  => 'https://giglogistics.com/track?waybill=%1$s',
				),
			)
		);
	}

	// =========================================================================
	// CRUD – tracking items stored as order meta (_wc_shipment_tracking_items)
	// =========================================================================

	/**
	 * Get all tracking items for an order.
	 *
	 * @param int  $order_id
	 * @param bool $formatted Whether to include resolved link/provider fields.
	 * @return array
	 */
	public function get_tracking_items( $order_id, $formatted = false ) {
		$order = wc_get_order( $order_id );
		if ( ! $order instanceof WC_Order ) {
			return array();
		}

		$items = $order->get_meta( '_wc_shipment_tracking_items' );

		if ( ! is_array( $items ) ) {
			return array();
		}

		if ( $formatted ) {
			foreach ( $items as &$item ) {
				$item = array_merge( $item, $this->get_formatted_tracking_item( $order_id, $item ) );
			}
			unset( $item );
		}

		return $items;
	}

	/**
	 * Get a single tracking item by its tracking_id.
	 *
	 * @param int    $order_id
	 * @param string $tracking_id
	 * @param bool   $formatted
	 * @return array|null
	 */
	public function get_tracking_item( $order_id, $tracking_id, $formatted = false ) {
		foreach ( $this->get_tracking_items( $order_id, $formatted ) as $item ) {
			if ( $item['tracking_id'] === $tracking_id ) {
				return $item;
			}
		}
		return null;
	}

	/**
	 * Add a tracking item to an order.
	 *
	 * @param int   $order_id
	 * @param array $args {
	 *   tracking_provider, custom_tracking_provider, custom_tracking_link,
	 *   tracking_number, date_shipped
	 * }
	 * @return array The new tracking item.
	 */
	public function add_tracking_item( $order_id, $args ) {
		$item = array(
			'tracking_provider'        => wc_clean( isset( $args['tracking_provider'] )        ? $args['tracking_provider']        : '' ),
			'custom_tracking_provider' => wc_clean( isset( $args['custom_tracking_provider'] ) ? $args['custom_tracking_provider'] : '' ),
			'custom_tracking_link'     => wc_clean( isset( $args['custom_tracking_link'] )     ? $args['custom_tracking_link']     : '' ),
			'tracking_number'          => wc_clean( isset( $args['tracking_number'] )          ? $args['tracking_number']          : '' ),
			'date_shipped'             => isset( $args['date_shipped'] ) ? (int) wc_clean( strtotime( $args['date_shipped'] ) ) : 0,
		);

		if ( 0 === $item['date_shipped'] ) {
			$item['date_shipped'] = time();
		}

		$id_base           = $item['custom_tracking_provider'] ?: $item['tracking_provider'];
		$item['tracking_id'] = md5( $id_base . '-' . $item['tracking_number'] . microtime() );

		$items   = $this->get_tracking_items( $order_id );
		$items[] = $item;

		/**
		 * Filter tracking items before persisting (add).
		 *
		 * @param array $items    Full list after adding the new item.
		 * @param array $item     The new item.
		 * @param int   $order_id
		 */
		$items = apply_filters( 'wcst_before_add_tracking_items', $items, $item, $order_id );

		$this->save_tracking_items( $order_id, $items );

		return $item;
	}

	/**
	 * Delete a tracking item from an order.
	 *
	 * @param int    $order_id
	 * @param string $tracking_id
	 * @return bool
	 */
	public function delete_tracking_item( $order_id, $tracking_id ) {
		$items      = $this->get_tracking_items( $order_id );
		$deleted    = null;
		$found      = false;

		foreach ( $items as $key => $item ) {
			if ( $item['tracking_id'] === $tracking_id ) {
				$deleted = $item;
				unset( $items[ $key ] );
				$found = true;
				break;
			}
		}

		if ( $found ) {
			/**
			 * Filter tracking items before persisting (delete).
			 *
			 * @param array $items   Remaining items.
			 * @param array $deleted The item being deleted.
			 * @param int   $order_id
			 */
			$items = apply_filters( 'wcst_before_delete_tracking_items', $items, $deleted, $order_id );
			$this->save_tracking_items( $order_id, $items );
		}

		return $found;
	}

	/**
	 * Update an existing tracking item in an order.
	 *
	 * @param int    $order_id
	 * @param string $tracking_id
	 * @param array  $args
	 * @return array|null Updated item or null if not found.
	 */
	public function update_tracking_item( $order_id, $tracking_id, $args ) {
		$items = $this->get_tracking_items( $order_id );
		$found = false;
		$updated_item = null;

		foreach ( $items as $key => $item ) {
			if ( $item['tracking_id'] === $tracking_id ) {
				$items[ $key ]['tracking_provider']        = wc_clean( isset( $args['tracking_provider'] )        ? $args['tracking_provider']        : '' );
				$items[ $key ]['custom_tracking_provider'] = wc_clean( isset( $args['custom_tracking_provider'] ) ? $args['custom_tracking_provider'] : '' );
				$items[ $key ]['custom_tracking_link']     = wc_clean( isset( $args['custom_tracking_link'] )     ? $args['custom_tracking_link']     : '' );
				$items[ $key ]['tracking_number']          = wc_clean( isset( $args['tracking_number'] )          ? $args['tracking_number']          : '' );

				if ( ! empty( $args['date_shipped'] ) ) {
					$ts = (int) strtotime( $args['date_shipped'] );
					$items[ $key ]['date_shipped'] = $ts > 0 ? $ts : $item['date_shipped'];
				}

				$updated_item = $items[ $key ];
				$found = true;
				break;
			}
		}

		if ( $found ) {
			$this->save_tracking_items( $order_id, $items );
		}

		return $updated_item;
	}

	/**
	 * Save tracking items array to order meta.
	 *
	 * @param int   $order_id
	 * @param array $items
	 */
	public function save_tracking_items( $order_id, $items ) {
		$order = wc_get_order( $order_id );
		if ( ! $order instanceof WC_Order ) {
			return;
		}
		$order->update_meta_data( '_wc_shipment_tracking_items', array_values( $items ) );
		$order->save();
	}

	// =========================================================================
	// FORMATTING
	// =========================================================================

	/**
	 * Resolve the human-readable provider name, the final tracking URL, and
	 * the formatted date_shipped for a raw tracking item.
	 *
	 * @param int   $order_id
	 * @param array $item
	 * @return array Associative array with formatted_* keys.
	 */
	public function get_formatted_tracking_item( $order_id, $item ) {
		$order = wc_get_order( $order_id );
		if ( ! $order instanceof WC_Order ) {
			return array();
		}

		$postcode     = $order->get_shipping_postcode() ?: $order->get_billing_postcode();
		$country_code = $order->get_shipping_country();

		$formatted = array(
			'formatted_tracking_provider'  => '',
			'formatted_tracking_link'      => '',
			'formatted_date_shipped_ymd'   => '',
			'formatted_date_shipped_wc'    => '',
			'formatted_date_shipped_i18n'  => '',
		);

		if ( ! empty( $item['custom_tracking_provider'] ) ) {
			$formatted['formatted_tracking_provider'] = $item['custom_tracking_provider'];
			$formatted['formatted_tracking_link']     = $this->build_tracking_link(
				$item,
				$postcode,
				$country_code,
				$order_id,
				$item['custom_tracking_link']
			);
		} else {
			$link_format = '';
			foreach ( $this->get_providers() as $providers ) {
				foreach ( $providers as $p_name => $p_format ) {
					if ( wc_clean( $p_name ) === $item['tracking_provider'] || sanitize_title( $p_name ) === $item['tracking_provider'] ) {
						$link_format                              = $p_format;
						$formatted['formatted_tracking_provider'] = $p_name;
						break 2;
					}
				}
			}
			if ( $link_format ) {
				$formatted['formatted_tracking_link'] = $this->build_tracking_link( $item, $postcode, $country_code, $order_id, $link_format );
			}
		}

		if ( ! empty( $item['date_shipped'] ) && is_numeric( $item['date_shipped'] ) ) {
			$formatted['formatted_date_shipped_ymd']  = gmdate( 'Y-m-d', $item['date_shipped'] );
			$formatted['formatted_date_shipped_wc']   = gmdate( wc_date_format(), $item['date_shipped'] );
			$formatted['formatted_date_shipped_i18n'] = date_i18n( wc_date_format(), $item['date_shipped'] );
		}

		/**
		 * Filter the fully formatted tracking item.
		 *
		 * @param array          $formatted
		 * @param int            $order_id
		 * @param array          $item
		 * @param WCST_Actions   $this
		 */
		return apply_filters( 'wcst_formatted_item', $formatted, $order_id, $item, $this );
	}

	/**
	 * Build the final tracking URL by substituting placeholders.
	 *
	 * Placeholders: %1$s = tracking number, %2$s = postcode, %3$s = country code, %4$s = order_id
	 *
	 * @param array       $item
	 * @param string|null $postcode
	 * @param string|null $country_code
	 * @param int         $order_id
	 * @param string|null $link_format
	 * @return string
	 */
	public function build_tracking_link( array $item, $postcode, $country_code, $order_id, $link_format ) {
		$values = apply_filters(
			'wcst_provider_url_values',
			array(
				$item['tracking_number'],
				rawurlencode( wc_normalize_postcode( (string) $postcode ) ),
				(string) $country_code,
				(int) $order_id,
			),
			$item
		);

		$link_format = is_string( $link_format ) ? $link_format : '';
		array_unshift( $values, $link_format );

		return call_user_func_array( 'sprintf', $values );
	}

	// =========================================================================
	// ADMIN: META BOX
	// =========================================================================

	public function admin_styles() {
		wp_enqueue_style( 'wcst-admin', WCST_URL . '/assets/css/admin.css', array(), WCST_VERSION );
	}

	public function frontend_styles() {
		if ( is_wc_endpoint_url( 'view-order' ) || is_wc_endpoint_url( 'orders' ) || $this->current_page_has_shortcode( 'wcst_tracking' ) ) {
			wp_enqueue_style( 'wcst-frontend', WCST_URL . '/assets/css/frontend.css', array(), WCST_VERSION );
		}
	}

	/**
	 * Check if the current page's content contains a given shortcode.
	 *
	 * @param string $shortcode
	 * @return bool
	 */
	private function current_page_has_shortcode( $shortcode ) {
		global $post;
		return $post instanceof WP_Post && has_shortcode( $post->post_content, $shortcode );
	}

	public function add_meta_box() {
		add_meta_box(
			'wcst-shipment-tracking',
			__( 'Shipment Tracking', 'wc-shipment-tracker' ),
			array( $this, 'render_meta_box' ),
			$this->get_order_admin_screen(),
			'side',
			'high'
		);
	}

	/**
	 * Render the meta box HTML.
	 *
	 * @param \WP_Post|\WC_Order $post_or_order
	 */
	public function render_meta_box( $post_or_order ) {
		$order          = $this->init_theorder_object( $post_or_order );
		$order_id       = $order->get_id();
		$tracking_items = $this->get_tracking_items( $order_id );
		$providers      = $this->get_providers();

		// Build flat provider map for JS preview (provider_slug => encoded_url).
		$provider_map = array();
		foreach ( $providers as $providers_in_group ) {
			foreach ( $providers_in_group as $p_name => $p_url ) {
				$provider_map[ wc_clean( $p_name ) ] = rawurlencode( $p_url );
			}
		}
		?>
		<div id="wcst-tracking-items">
			<?php foreach ( $tracking_items as $item ) : ?>
				<?php $this->render_tracking_item_html( $order_id, $item ); ?>
			<?php endforeach; ?>
		</div>

		<p>
			<button type="button" class="button wcst-toggle-form">
				<?php esc_html_e( 'Add Tracking Number', 'wc-shipment-tracker' ); ?>
			</button>
		</p>

		<div id="wcst-tracking-form" style="display:none;">

			<?php wp_nonce_field( 'wcst_create_tracking', 'wcst_create_nonce' ); ?>
			<?php wp_nonce_field( 'wcst_update_tracking', 'wcst_update_nonce' ); ?>
			<?php wp_nonce_field( 'wcst_delete_tracking', 'wcst_delete_nonce' ); ?>
			<?php wp_nonce_field( 'wcst_get_items',       'wcst_get_nonce' ); ?>

			<!-- Provider select -->
			<p class="form-field">
				<label for="wcst_tracking_provider"><?php esc_html_e( 'Provider:', 'wc-shipment-tracker' ); ?></label>
				<select id="wcst_tracking_provider" name="wcst_tracking_provider" class="wcst-provider-select">
					<option value=""><?php esc_html_e( 'Custom Provider', 'wc-shipment-tracker' ); ?></option>
					<?php
					$default = apply_filters( 'wcst_default_provider', '' );
					foreach ( $providers as $group => $group_providers ) :
						echo '<optgroup label="' . esc_attr( $group ) . '">';
						foreach ( $group_providers as $p_name => $p_url ) :
							$val = wc_clean( $p_name );
							echo '<option value="' . esc_attr( $val ) . '"' . selected( $val, $default, false ) . '>' . esc_html( $p_name ) . '</option>';
						endforeach;
						echo '</optgroup>';
					endforeach;
					?>
				</select>
			</p>

			<!-- Custom provider name -->
			<p class="form-field wcst-custom-fields">
				<label for="wcst_custom_tracking_provider"><?php esc_html_e( 'Provider Name:', 'wc-shipment-tracker' ); ?></label>
				<input type="text" id="wcst_custom_tracking_provider" name="wcst_custom_tracking_provider" value="" />
			</p>

			<!-- Tracking number -->
			<p class="form-field">
				<label for="wcst_tracking_number"><?php esc_html_e( 'Tracking Number:', 'wc-shipment-tracker' ); ?></label>
				<input type="text" id="wcst_tracking_number" name="wcst_tracking_number" value="" />
			</p>

			<!-- Tracking link (custom) -->
			<p class="form-field wcst-custom-fields">
				<label for="wcst_custom_tracking_link"><?php esc_html_e( 'Tracking Link:', 'wc-shipment-tracker' ); ?></label>
				<input type="url" id="wcst_custom_tracking_link" name="wcst_custom_tracking_link" value="" placeholder="https://" />
			</p>

			<!-- Date shipped -->
			<p class="form-field">
				<label for="wcst_date_shipped"><?php esc_html_e( 'Date Shipped:', 'wc-shipment-tracker' ); ?></label>
				<input type="text" id="wcst_date_shipped" name="wcst_date_shipped"
					value="<?php echo esc_attr( wp_date( 'Y-m-d', time() ) ); ?>"
					placeholder="<?php echo esc_attr( wp_date( 'Y-m-d', time() ) ); ?>"
					class="date-picker-field" />
			</p>

			<!-- Preview -->
			<p class="wcst-preview-link" style="display:none;">
				<?php esc_html_e( 'Preview:', 'wc-shipment-tracker' ); ?>
				<a href="#" target="_blank"><?php esc_html_e( 'Click here to track your shipment', 'wc-shipment-tracker' ); ?></a>
			</p>

			<input type="hidden" id="wcst_editing_id" value="" />

			<p class="wcst-form-actions">
				<button type="button" class="button button-primary wcst-save-tracking">
					<?php esc_html_e( 'Save Tracking', 'wc-shipment-tracker' ); ?>
				</button>
				<button type="button" class="button wcst-cancel-form">
					<?php esc_html_e( 'Cancel', 'wc-shipment-tracker' ); ?>
				</button>
				<span class="wcst-spinner spinner" style="float:none; margin-top:0;"></span>
			</p>

		</div><!-- #wcst-tracking-form -->

		<?php
		// Pass providers map and order ID to JS.
		wp_enqueue_script(
			'wcst-admin',
			WCST_URL . '/assets/js/admin.js',
			array( 'jquery', 'wc-enhanced-select' ),
			WCST_VERSION,
			true
		);

		wp_localize_script(
			'wcst-admin',
			'wcstAdmin',
			array(
				'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
				'orderId'        => $order_id,
				'providers'      => $provider_map,
				'createNonce'    => wp_create_nonce( 'wcst_create_tracking' ),
				'updateNonce'    => wp_create_nonce( 'wcst_update_tracking' ),
				'deleteNonce'    => wp_create_nonce( 'wcst_delete_tracking' ),
				'getNonce'       => wp_create_nonce( 'wcst_get_items' ),
				'i18n'           => array(
					'confirmDelete'          => __( 'Are you sure you want to delete this tracking number?', 'wc-shipment-tracker' ),
					'error'                  => __( 'An error occurred. Please try again.', 'wc-shipment-tracker' ),
					'trackingNumberRequired' => __( 'Please enter a tracking number.', 'wc-shipment-tracker' ),
					'searchProvider'         => __( 'Search provider…', 'wc-shipment-tracker' ),
					'editTitle'              => __( 'Edit Tracking', 'wc-shipment-tracker' ),
					'addTitle'               => __( 'Add Tracking Number', 'wc-shipment-tracker' ),
					'cancel'                 => __( 'Cancel', 'wc-shipment-tracker' ),
				),
			)
		);
	}

	/**
	 * Render a single tracking item card inside the meta box.
	 *
	 * @param int   $order_id
	 * @param array $item
	 */
	public function render_tracking_item_html( $order_id, $item ) {
		$formatted = $this->get_formatted_tracking_item( $order_id, $item );

		$date_text = ! empty( $formatted['formatted_date_shipped_i18n'] )
			/* translators: %s = formatted date */
			? sprintf( __( 'Shipped on %s', 'wc-shipment-tracker' ), $formatted['formatted_date_shipped_i18n'] )
			: __( 'No shipping date', 'wc-shipment-tracker' );

		$favicon_url = '';
		if ( ! empty( $formatted['formatted_tracking_link'] ) ) {
			$parsed = wp_parse_url( $formatted['formatted_tracking_link'] );
			if ( ! empty( $parsed['host'] ) ) {
				$favicon_url = 'https://www.google.com/s2/favicons?domain=' . rawurlencode( $parsed['host'] ) . '&sz=32';
			}
		}
		?>
		<div class="wcst-tracking-item" id="wcst-item-<?php echo esc_attr( $item['tracking_id'] ); ?>">
			<div class="wcst-item-main">
				<div class="wcst-item-logo">
					<?php if ( $favicon_url ) : ?>
						<img src="<?php echo esc_url( $favicon_url ); ?>" width="20" height="20" alt="" />
					<?php else : ?>
						<span class="wcst-item-logo-placeholder"></span>
					<?php endif; ?>
				</div>
				<div class="wcst-item-info">
					<strong><?php echo esc_html( $formatted['formatted_tracking_provider'] ); ?></strong>
					<span class="wcst-item-number-row">
						<span class="wcst-item-number"><?php echo esc_html( $item['tracking_number'] ); ?></span>
						<button type="button"
							class="wcst-copy-btn"
							data-copy="<?php echo esc_attr( $item['tracking_number'] ); ?>"
							title="<?php esc_attr_e( 'Copy tracking number', 'wc-shipment-tracker' ); ?>"
							aria-label="<?php esc_attr_e( 'Copy tracking number', 'wc-shipment-tracker' ); ?>">
							<svg class="wcst-icon-copy" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
							<svg class="wcst-icon-check" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
						</button>
					</span>
				</div>
				<?php if ( $formatted['formatted_tracking_link'] ) : ?>
					<a href="<?php echo esc_url( $formatted['formatted_tracking_link'] ); ?>" class="wcst-item-track-btn" target="_blank">
						<?php esc_html_e( 'Track', 'wc-shipment-tracker' ); ?> &#8599;
					</a>
				<?php endif; ?>
			</div>
			<div class="wcst-item-footer">
				<span class="wcst-item-date"><?php echo esc_html( $date_text ); ?></span>
				<span class="wcst-item-actions">
					<a href="#"
						class="wcst-edit-item"
						data-tracking-id="<?php echo esc_attr( $item['tracking_id'] ); ?>"
						data-order-id="<?php echo esc_attr( $order_id ); ?>"
						data-provider="<?php echo esc_attr( $item['tracking_provider'] ); ?>"
						data-custom-provider="<?php echo esc_attr( $item['custom_tracking_provider'] ); ?>"
						data-custom-link="<?php echo esc_attr( $item['custom_tracking_link'] ); ?>"
						data-tracking-number="<?php echo esc_attr( $item['tracking_number'] ); ?>"
						data-date-shipped="<?php echo esc_attr( $formatted['formatted_date_shipped_ymd'] ); ?>">
						<?php esc_html_e( 'Edit', 'wc-shipment-tracker' ); ?>
					</a>
					<a href="#"
						class="wcst-delete-item"
						data-tracking-id="<?php echo esc_attr( $item['tracking_id'] ); ?>"
						data-order-id="<?php echo esc_attr( $order_id ); ?>">
						<?php esc_html_e( 'Delete', 'wc-shipment-tracker' ); ?>
					</a>
				</span>
			</div>
		</div>
		<?php
	}

	// =========================================================================
	// SAVE (form submit – non-AJAX fallback)
	// =========================================================================

	/**
	 * Save tracking from classic meta box form submit.
	 *
	 * @param int $post_id
	 */
	public function save_meta_box( $post_id ) {
		// Nonce already checked by WooCommerce before firing this hook.
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( ! empty( $_POST['wcst_tracking_number'] ) ) {
			$this->add_tracking_item(
				$post_id,
				array(
					'tracking_provider'        => isset( $_POST['wcst_tracking_provider'] )        ? sanitize_text_field( wp_unslash( $_POST['wcst_tracking_provider'] ) )        : '',
					'custom_tracking_provider' => isset( $_POST['wcst_custom_tracking_provider'] ) ? sanitize_text_field( wp_unslash( $_POST['wcst_custom_tracking_provider'] ) ) : '',
					'custom_tracking_link'     => isset( $_POST['wcst_custom_tracking_link'] )     ? sanitize_text_field( wp_unslash( $_POST['wcst_custom_tracking_link'] ) )     : '',
					'tracking_number'          => isset( $_POST['wcst_tracking_number'] )          ? sanitize_text_field( wp_unslash( $_POST['wcst_tracking_number'] ) )          : '',
					'date_shipped'             => isset( $_POST['wcst_date_shipped'] )             ? sanitize_text_field( wp_unslash( $_POST['wcst_date_shipped'] ) )             : '',
				)
			);
		}
		// phpcs:enable WordPress.Security.NonceVerification.Missing
	}

	// =========================================================================
	// AJAX HANDLERS
	// =========================================================================

	public function ajax_save_tracking() {
		check_ajax_referer( 'wcst_create_tracking', 'security' );

		if ( empty( $_POST['tracking_number'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Tracking number is required.', 'wc-shipment-tracker' ) ) );
		}

		$order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
		$item     = $this->add_tracking_item(
			$order_id,
			array(
				'tracking_provider'        => isset( $_POST['tracking_provider'] )        ? sanitize_text_field( wp_unslash( $_POST['tracking_provider'] ) )        : '',
				'custom_tracking_provider' => isset( $_POST['custom_tracking_provider'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_tracking_provider'] ) ) : '',
				'custom_tracking_link'     => isset( $_POST['custom_tracking_link'] )     ? sanitize_text_field( wp_unslash( $_POST['custom_tracking_link'] ) )     : '',
				'tracking_number'          => isset( $_POST['tracking_number'] )          ? sanitize_text_field( wp_unslash( $_POST['tracking_number'] ) )          : '',
				'date_shipped'             => isset( $_POST['date_shipped'] )             ? sanitize_text_field( wp_unslash( $_POST['date_shipped'] ) )             : '',
			)
		);

		ob_start();
		$this->render_tracking_item_html( $order_id, $item );
		$html = ob_get_clean();

		wp_send_json_success( array( 'html' => $html ) );
	}

	public function ajax_update_tracking() {
		check_ajax_referer( 'wcst_update_tracking', 'security' );

		if ( empty( $_POST['tracking_number'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Tracking number is required.', 'wc-shipment-tracker' ) ) );
		}

		$order_id    = isset( $_POST['order_id'] )    ? absint( $_POST['order_id'] )                            : 0;
		$tracking_id = isset( $_POST['tracking_id'] ) ? wc_clean( wp_unslash( $_POST['tracking_id'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		$item = $this->update_tracking_item(
			$order_id,
			$tracking_id,
			array(
				'tracking_provider'        => isset( $_POST['tracking_provider'] )        ? sanitize_text_field( wp_unslash( $_POST['tracking_provider'] ) )        : '',
				'custom_tracking_provider' => isset( $_POST['custom_tracking_provider'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_tracking_provider'] ) ) : '',
				'custom_tracking_link'     => isset( $_POST['custom_tracking_link'] )     ? sanitize_text_field( wp_unslash( $_POST['custom_tracking_link'] ) )     : '',
				'tracking_number'          => isset( $_POST['tracking_number'] )          ? sanitize_text_field( wp_unslash( $_POST['tracking_number'] ) )          : '',
				'date_shipped'             => isset( $_POST['date_shipped'] )             ? sanitize_text_field( wp_unslash( $_POST['date_shipped'] ) )             : '',
			)
		);

		if ( ! $item ) {
			wp_send_json_error( array( 'message' => __( 'Could not update tracking item.', 'wc-shipment-tracker' ) ) );
		}

		ob_start();
		$this->render_tracking_item_html( $order_id, $item );
		$html = ob_get_clean();

		wp_send_json_success( array( 'html' => $html ) );
	}

	public function ajax_delete_tracking() {
		check_ajax_referer( 'wcst_delete_tracking', 'security' );

		$order_id    = isset( $_POST['order_id'] )    ? absint( $_POST['order_id'] )                              : 0;
		$tracking_id = isset( $_POST['tracking_id'] ) ? wc_clean( wp_unslash( $_POST['tracking_id'] ) ) : '';  // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		$deleted = $this->delete_tracking_item( $order_id, $tracking_id );

		if ( $deleted ) {
			wp_send_json_success();
		} else {
			wp_send_json_error( array( 'message' => __( 'Could not delete tracking item.', 'wc-shipment-tracker' ) ) );
		}
	}

	public function ajax_get_items() {
		check_ajax_referer( 'wcst_get_items', 'security' );

		$order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
		$items    = $this->get_tracking_items( $order_id );

		ob_start();
		foreach ( $items as $item ) {
			$this->render_tracking_item_html( $order_id, $item );
		}
		wp_send_json_success( array( 'html' => ob_get_clean() ) );
	}

	// =========================================================================
	// ADMIN: ORDERS LIST COLUMN
	// =========================================================================

	public function add_orders_list_column( $columns ) {
		$columns['wcst_shipment_tracking'] = __( 'Shipment Tracking', 'wc-shipment-tracker' );
		return $columns;
	}

	/** Legacy CPT screen */
	public function render_orders_list_column_legacy( $column_name, $post_id ) {
		if ( 'wcst_shipment_tracking' === $column_name ) {
			echo wp_kses_post( $this->get_column_html( $post_id ) );
		}
	}

	/** HPOS screen */
	public function render_orders_list_column_hpos( $column_name, $order ) {
		if ( 'wcst_shipment_tracking' === $column_name ) {
			echo wp_kses_post( $this->get_column_html( $order->get_id() ) );
		}
	}

	/**
	 * Build HTML for the orders list Shipment Tracking column.
	 *
	 * @param int $order_id
	 * @return string
	 */
	private function get_column_html( $order_id ) {
		$items = array_reverse( $this->get_tracking_items( $order_id ) );
		$count = count( $items );

		ob_start();
		echo '<div class="wcst-column-tracking">';

		if ( 0 === $count ) {
			echo '&ndash;';
		} elseif ( 1 === $count ) {
			$f           = $this->get_formatted_tracking_item( $order_id, $items[0] );
			$parsed      = wp_parse_url( $f['formatted_tracking_link'] );
			$favicon_url = ! empty( $parsed['host'] ) ? 'https://www.google.com/s2/favicons?domain=' . rawurlencode( $parsed['host'] ) . '&sz=32' : '';
			printf(
				'<span class="wcst-tracking-cell">%s<a href="%s" target="_blank">%s</a></span>',
				$favicon_url ? '<img src="' . esc_url( $favicon_url ) . '" width="16" height="16" alt="" />' : '',
				esc_url( $f['formatted_tracking_link'] ),
				esc_html( $items[0]['tracking_number'] )
			);
		} else {
			echo '<details>';
			foreach ( $items as $idx => $item ) {
				$f           = $this->get_formatted_tracking_item( $order_id, $item );
				$parsed      = wp_parse_url( $f['formatted_tracking_link'] );
				$favicon_url = ! empty( $parsed['host'] ) ? 'https://www.google.com/s2/favicons?domain=' . rawurlencode( $parsed['host'] ) . '&sz=32' : '';
				$favicon_img = $favicon_url ? '<img src="' . esc_url( $favicon_url ) . '" width="16" height="16" alt="" />' : '';
				if ( 0 === $idx ) {
					printf(
						'<summary><span class="wcst-tracking-cell">%s<a href="%s" target="_blank">%s</a></span> (+%d more…)</summary><ul>',
						$favicon_img,
						esc_url( $f['formatted_tracking_link'] ),
						esc_html( $item['tracking_number'] ),
						$count - 1
					);
				} else {
					printf(
						'<li><span class="wcst-tracking-cell">%s<a href="%s" target="_blank">%s</a></span></li>',
						$favicon_img,
						esc_url( $f['formatted_tracking_link'] ),
						esc_html( $item['tracking_number'] )
					);
				}
			}
			echo '</ul></details>';
		}

		echo '</div>';
		return ob_get_clean();
	}

	// =========================================================================
	// FRONTEND: MY ACCOUNT VIEW ORDER
	// =========================================================================

	/**
	 * Display tracking info on the My Account > View Order page.
	 *
	 * @param int $order_id
	 */
	public function display_tracking_info( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order instanceof WC_Order ) {
			return;
		}

		wc_get_template(
			'myaccount/tracking-info.php',
			array(
				'order'          => $order,
				'tracking_items' => $this->get_tracking_items( $order_id, true ),
			),
			'wc-shipment-tracker/',
			WCST_DIR . '/templates/'
		);
	}

	// =========================================================================
	// SHORTCODE [wcst_tracking]
	// =========================================================================

	/**
	 * Renders the public tracking shortcode.
	 *
	 * Usage:
	 *   [wcst_tracking]                           — shows lookup form or results from URL params
	 *   ?order_id=123&key=wc_order_xxx            — direct link (from email)
	 *
	 * Authentication options (either is accepted):
	 *   1. order_id + order_key (?key=wc_order_xxx)
	 *   2. order_id + billing email (lookup form)
	 *
	 * @return string HTML output.
	 */
	public function shortcode_tracking() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$order_id  = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
		$order_key = isset( $_GET['key'] )      ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : '';
		$email     = isset( $_POST['wcst_email'] ) ? sanitize_email( wp_unslash( $_POST['wcst_email'] ) ) : '';
		$post_id   = isset( $_POST['wcst_order_id'] ) ? absint( $_POST['wcst_order_id'] ) : 0;
		// phpcs:enable

		$order  = null;
		$error  = '';
		$state  = 'form'; // 'form' | 'results' | 'no_tracking' | 'error'

		// — Direct link via order_key (from email) —
		if ( $order_id && $order_key ) {
			$order = wc_get_order( $order_id );
			if ( $order instanceof WC_Order && hash_equals( $order->get_order_key(), $order_key ) ) {
				$state = 'results';
			} else {
				$order = null;
				$error = __( 'Invalid order or tracking link. Please check your email and try again.', 'wc-shipment-tracker' );
				$state = 'error';
			}
		}

		// — Lookup form submitted (order ID + billing email) —
		if ( 'form' === $state && $post_id && $email ) {
			if ( ! isset( $_POST['wcst_lookup_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wcst_lookup_nonce'] ) ), 'wcst_tracking_lookup' ) ) {
				$error = __( 'Security check failed. Please try again.', 'wc-shipment-tracker' );
				$state = 'error';
			} else {
				$candidate = wc_get_order( $post_id );
				if (
					$candidate instanceof WC_Order &&
					strtolower( $candidate->get_billing_email() ) === strtolower( $email )
				) {
					$order = $candidate;
					$state = 'results';
				} else {
					$error = __( 'No order found with that order number and email address.', 'wc-shipment-tracker' );
					$state = 'error';
				}
			}
		}

		if ( 'results' === $state ) {
			$tracking_items = $this->get_tracking_items( $order->get_id(), true );
			if ( empty( $tracking_items ) ) {
				$state = 'no_tracking';
			}
		}

		ob_start();
		wc_get_template(
			'shortcode/tracking.php',
			array(
				'state'          => $state,
				'order'          => $order,
				'tracking_items' => ( 'results' === $state ) ? $this->get_tracking_items( $order->get_id(), true ) : array(),
				'error'          => $error,
			),
			'wc-shipment-tracker/',
			WCST_DIR . '/templates/'
		);
		return ob_get_clean();
	}

	// =========================================================================
	// EMAILS
	// =========================================================================

	/**
	 * @return array Email class names that should NOT receive tracking info.
	 */
	public function get_excluded_email_classes() {
		return apply_filters(
			'wcst_excluded_email_classes',
			array( 'WC_Email_Customer_Refunded_Order' )
		);
	}

	/**
	 * Inject tracking info into order emails (before the order table).
	 *
	 * @param WC_Order $order
	 * @param bool     $sent_to_admin
	 * @param bool     $plain_text
	 * @param WC_Email $email
	 */
	public function email_display( $order, $sent_to_admin, $plain_text = false, $email = null ) {
		foreach ( $this->get_excluded_email_classes() as $class ) {
			if ( is_a( $email, $class ) ) {
				return;
			}
		}

		$template = $plain_text ? 'email/plain/tracking-info.php' : 'email/tracking-info.php';

		wc_get_template(
			$template,
			array( 'tracking_items' => $this->get_tracking_items( $order->get_id(), true ) ),
			'wc-shipment-tracker/',
			WCST_DIR . '/templates/'
		);
	}

	// =========================================================================
	// SUBSCRIPTIONS: prevent copying tracking to renewal orders
	// =========================================================================

	public function prevent_copying_tracking_data( $data ) {
		unset( $data['_wc_shipment_tracking_items'] );
		return $data;
	}

	public function exclude_tracking_from_renewal_query( $query ) {
		global $wpdb;
		$query .= $wpdb->prepare( " AND meta_key NOT IN ( %s )", '_wc_shipment_tracking_items' );
		return $query;
	}
}
