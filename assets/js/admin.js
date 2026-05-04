/* global wcstAdmin, jQuery */
( function ( $ ) {
	'use strict';

	var WCSTAdmin = {

		// ----------------------------------------------------------------
		// Init
		// ----------------------------------------------------------------
		init: function () {
			this.initProviderSelect();
			this.bindToggleForm();
			this.bindProviderChange();
			this.bindSaveTracking();
			this.bindEditTracking();
			this.bindDeleteTracking();
			this.bindCopyTracking();

			// Trigger provider change to set initial state.
			$( '#wcst_tracking_provider' ).trigger( 'change' );
		},

		// ----------------------------------------------------------------
		// Searchable provider select via SelectWoo (WC enhanced select)
		// ----------------------------------------------------------------
		providerTemplate: function ( option ) {
			return option.text;
		},

		initProviderSelect: function () {
			var $select = $( '#wcst_tracking_provider' );
			if ( ! $select.length || ! $.fn.selectWoo ) {
				return;
			}

			$select.selectWoo( {
				placeholder:       wcstAdmin.i18n.searchProvider,
				allowClear:        true,
				width:             '100%',
				templateResult:    WCSTAdmin.providerTemplate,
				templateSelection: function ( option ) { return option.text; },
			} );
		},

		// ----------------------------------------------------------------
		// Show / hide form
		// ----------------------------------------------------------------
		bindToggleForm: function () {
			$( document ).on( 'click', '.wcst-toggle-form', function ( e ) {
				e.preventDefault();
				var $form = $( '#wcst-tracking-form' );
				WCSTAdmin.resetForm();
				$form.toggle();
				if ( $form.is( ':visible' ) ) {
					$( '#wcst_tracking_number' ).focus();
				}
			} );

			$( document ).on( 'click', '.wcst-cancel-form', function ( e ) {
				e.preventDefault();
				WCSTAdmin.resetForm();
				$( '#wcst-tracking-form' ).hide();
			} );
		},

		// ----------------------------------------------------------------
		// Edit tracking — populate form with existing item data
		// ----------------------------------------------------------------
		bindEditTracking: function () {
			$( document ).on( 'click', '.wcst-edit-item', function ( e ) {
				e.preventDefault();

				var $btn        = $( this );
				var trackingId  = $btn.data( 'tracking-id' );
				var provider    = $btn.data( 'provider' );
				var customProv  = $btn.data( 'custom-provider' );
				var customLink  = $btn.data( 'custom-link' );
				var number      = $btn.data( 'tracking-number' );
				var date        = $btn.data( 'date-shipped' );

				// Store the id being edited.
				$( '#wcst_editing_id' ).val( trackingId );

				// Populate fields.
				$( '#wcst_tracking_number' ).val( number );
				$( '#wcst_custom_tracking_provider' ).val( customProv );
				$( '#wcst_custom_tracking_link' ).val( customLink );
				$( '#wcst_date_shipped' ).val( date );

				// Set provider — trigger change so SelectWoo updates its displayed value.
				$( '#wcst_tracking_provider' ).val( provider ).trigger( 'change' );

				WCSTAdmin.updatePreview();
				$( '#wcst-tracking-form' ).show();
				$( '#wcst_tracking_number' ).focus();
			} );
		},

		// ----------------------------------------------------------------
		// Auto-detect provider from tracking number format
		// ----------------------------------------------------------------
		providerPatterns: [
			// UPS — always starts with 1Z + 16 alphanumeric chars
			{ pattern: /^1Z[A-Z0-9]{16}$/i,                          provider: 'UPS' },
			// FedEx Sameday
			{ pattern: /^[0-9]{15}$/,                                 provider: 'FedEx Sameday' },
			// FedEx — 12, 20 or 22 pure digits
			{ pattern: /^[0-9]{12}$/,                                 provider: 'Fedex' },
			{ pattern: /^96[0-9]{20}$/,                               provider: 'Fedex' },
			// USPS — 22 digits starting with 9 series
			{ pattern: /^9[234][0-9]{20}$/,                           provider: 'USPS' },
			// DHL Express — 10 or 11 digits
			{ pattern: /^[0-9]{10,11}$/,                              provider: 'DHL' },
			// Royal Mail UK — 2 letters + 8 digits + 2 letters
			{ pattern: /^[A-Z]{2}[0-9]{8}[A-Z]{2}$/i,                provider: 'Royal Mail' },
			// Evri UK — H + 16 digits
			{ pattern: /^H[0-9]{16}$/i,                               provider: 'EVRi' },
			// PostNL Netherlands
			{ pattern: /^3S[A-Z0-9]{13}$/i,                           provider: 'PostNL' },
			{ pattern: /^JVGL[0-9]{14}$/i,                            provider: 'PostNL' },
			// InPost Poland — 24 digits
			{ pattern: /^[0-9]{24}$/,                                 provider: 'InPost' },
			// DPD — 14 digits
			{ pattern: /^[0-9]{14}$/,                                 provider: 'DPD.de' },
			// SF Express China — starts with SF
			{ pattern: /^SF[0-9]{12,15}$/i,                           provider: 'SF Express' },
			// Cainiao — JD prefix
			{ pattern: /^JD[0-9]{18,22}$/i,                           provider: 'Cainiao' },
			// YTO Express China
			{ pattern: /^YT[0-9]{16}$/i,                              provider: 'YTO Express' },
			// 4PX China
			{ pattern: /^4PX[0-9A-Z]+$/i,                             provider: '4PX' },
			// Yanwen China
			{ pattern: /^(UE|UV|XS|XX)[0-9]{9}CN$/i,                 provider: 'Yanwen' },
			// Correios Brazil — ends BR
			{ pattern: /^[A-Z]{2}[0-9]{9}BR$/i,                      provider: 'Correios' },
			// Correos Espana — ends ES
			{ pattern: /^[A-Z]{2}[0-9]{9}ES$/i,                      provider: 'Correos Espana' },
			// CTT Portugal — ends PT
			{ pattern: /^[A-Z]{2}[0-9]{9}PT$/i,                      provider: 'CTT' },
			// Japan Post — ends JP
			{ pattern: /^[A-Z]{2}[0-9]{9}JP$/i,                      provider: 'Japan Post' },
			// Korea Post — ends KR
			{ pattern: /^[A-Z]{2}[0-9]{9}KR$/i,                      provider: 'Korea Post' },
			// China Post EMS — ends CN
			{ pattern: /^[ER][A-Z][0-9]{9}CN$/i,                     provider: 'China Post' },
			// Australia Post — ends AU
			{ pattern: /^[A-Z]{2}[0-9]{9}AU$/i,                      provider: 'Australia Post' },
			// Estafeta Mexico — 22 digits
			{ pattern: /^[0-9]{22}$/,                                 provider: 'Estafeta' },
			// Correos de Mexico — ends MX
			{ pattern: /^[A-Z]{2}[0-9]{9}MX$/i,                      provider: 'Correos de Mexico' },
			// Correo Argentino — ends AR
			{ pattern: /^[A-Z]{2}[0-9]{9}AR$/i,                      provider: 'Correo Argentino' },
			// Correos Chile — ends CL
			{ pattern: /^[A-Z]{2}[0-9]{9}CL$/i,                      provider: 'Correos Chile' },
			// Serpost Peru — ends PE
			{ pattern: /^[A-Z]{2}[0-9]{9}PE$/i,                      provider: 'Serpost' },
			// SingPost — ends SG
			{ pattern: /^[A-Z]{2}[0-9]{9}SG$/i,                      provider: 'SingPost' },
			// Thailand Post — ends TH
			{ pattern: /^[A-Z]{2}[0-9]{9}TH$/i,                      provider: 'Thailand Post' },
			// Pos Malaysia — ends MY
			{ pattern: /^[A-Z]{2}[0-9]{9}MY$/i,                      provider: 'Pos Malaysia' },
			// PTT Turkey — ends TR
			{ pattern: /^[A-Z]{2}[0-9]{9}TR$/i,                      provider: 'PTT' },
			// Israel Post — ends IL
			{ pattern: /^[A-Z]{2}[0-9]{9}IL$/i,                      provider: 'Israel Post' },
			// Saudi Post — ends SA
			{ pattern: /^[A-Z]{2}[0-9]{9}SA$/i,                      provider: 'Saudi Post' },
			// Ninja Van — NV prefix
			{ pattern: /^NV[A-Z0-9]{14,18}$/i,                       provider: 'Ninja Van SG' },
			// J&T Express — JT prefix
			{ pattern: /^JT[0-9]{15,18}$/i,                          provider: 'J&T Express SG' },
			// Aramex — 13 digits starting with 6
			{ pattern: /^6[0-9]{12}$/,                                provider: 'Aramex' },
			// Poczta Polska — ends PL
			{ pattern: /^[A-Z]{2}[0-9]{9}PL$/i,                      provider: 'Poczta Polska' },
			// GLS — 8 to 9 digits
			{ pattern: /^[0-9]{8,9}$/,                                provider: 'GLS Spain' },
		],

		detectProvider: function ( trackingNumber ) {
			var number = trackingNumber.trim().toUpperCase();
			if ( number.length < 8 ) {
				return null;
			}
			var patterns = WCSTAdmin.providerPatterns;
			for ( var i = 0; i < patterns.length; i++ ) {
				if ( patterns[ i ].pattern.test( number ) ) {
					return patterns[ i ].provider;
				}
			}
			return null;
		},

		// Flag: true when the provider was set by auto-detect (not manually).
		_autoDetected: false,

		autoDetectAndSetProvider: function ( trackingNumber ) {
			var detected = WCSTAdmin.detectProvider( trackingNumber );
			var $select  = $( '#wcst_tracking_provider' );

			if ( ! detected ) {
				return;
			}

			// Find the option whose text matches the detected provider name.
			var $option = $select.find( 'option' ).filter( function () {
				return $( this ).text().trim() === detected;
			} );

			if ( ! $option.length ) {
				return;
			}

			// Mark as auto-detected so the change handler knows it wasn't manual.
			WCSTAdmin._autoDetected = true;

			// Set the value and fire change — Select2/SelectWoo will update its input display.
			$select.val( $option.val() ).trigger( 'change' );
		},

		clearAutoDetect: function () {
			var $select = $( '#wcst_tracking_provider' );

			WCSTAdmin._autoDetected = false;

			// Clear the provider select — Select2/SelectWoo will update its input display.
			$select.val( '' ).trigger( 'change' );
		},

		// ----------------------------------------------------------------
		// Provider select → show/hide custom fields + live preview
		// ----------------------------------------------------------------
		bindProviderChange: function () {
			$( document ).on(
				'change keyup',
				'#wcst_tracking_provider, #wcst_tracking_number, #wcst_custom_tracking_link',
				function () {
					WCSTAdmin.updatePreview();
				}
			);

			// Auto-detect provider when typing/pasting the tracking number.
			$( document ).on( 'input', '#wcst_tracking_number', function () {
				var val = $( this ).val().trim();

				// If the field is cleared, reset everything so custom provider works again.
				if ( val === '' ) {
					if ( WCSTAdmin._autoDetected ) {
						WCSTAdmin.clearAutoDetect();
					}
					return;
				}

				// Only auto-detect if no provider is selected, or the current one was auto-detected.
				var hasProvider = $( '#wcst_tracking_provider' ).val();
				if ( ! hasProvider || WCSTAdmin._autoDetected ) {
					WCSTAdmin.autoDetectAndSetProvider( val );
				}
			} );

			// When provider changes: if triggered by auto-detect, reset flag; if manual, just keep flag false.
			$( document ).on( 'change', '#wcst_tracking_provider', function () {
				if ( WCSTAdmin._autoDetected ) {
					WCSTAdmin._autoDetected = false;
				}
			} );
		},

		updatePreview: function () {
			var provider     = $( '#wcst_tracking_provider' ).val();
			var trackingNum  = $( '#wcst_tracking_number' ).val();
			var customLink   = $( '#wcst_custom_tracking_link' ).val();
			var providers    = wcstAdmin.providers;
			var link         = '';

			if ( provider && providers[ provider ] ) {
				// Hide custom fields when a known provider is selected.
				$( '.wcst-custom-fields' ).hide();

				link = decodeURIComponent( providers[ provider ] );
				link = link.replace( '%1$s', encodeURIComponent( trackingNum ) );
				link = link.replace( '%2$s', '' ); // postcode – not available in meta box
				link = link.replace( '%3$s', '' ); // country
				link = decodeURIComponent( link );
			} else {
				// Show custom fields for custom providers.
				$( '.wcst-custom-fields' ).show();
				link = customLink;
			}

			if ( link && trackingNum ) {
				$( '.wcst-preview-link a' ).attr( 'href', link );
				$( '.wcst-preview-link' ).show();
			} else {
				$( '.wcst-preview-link' ).hide();
			}
		},

		// ----------------------------------------------------------------
		// Save tracking via AJAX
		// ----------------------------------------------------------------
		showFieldError: function ( $input, message ) {
			$input.addClass( 'wcst-input-error' );
			var $err = $input.siblings( '.wcst-field-error' );
			if ( ! $err.length ) {
				$err = $( '<span class="wcst-field-error"></span>' ).insertAfter( $input );
			}
			$err.text( message ).show();
		},

		clearFieldError: function ( $input ) {
			$input.removeClass( 'wcst-input-error' );
			$input.siblings( '.wcst-field-error' ).hide();
		},

		bindSaveTracking: function () {
			// Clear error as user types.
			$( document ).on( 'input', '#wcst_tracking_number', function () {
				WCSTAdmin.clearFieldError( $( this ) );
			} );

			$( document ).on( 'click', '.wcst-save-tracking', function ( e ) {
				e.preventDefault();

				var $trackingInput = $( '#wcst_tracking_number' );
				var trackingNumber = $trackingInput.val().trim();
				if ( ! trackingNumber ) {
					WCSTAdmin.showFieldError( $trackingInput, wcstAdmin.i18n.trackingNumberRequired );
					$trackingInput.focus();
					return;
				}
				WCSTAdmin.clearFieldError( $trackingInput );

				var editingId = $( '#wcst_editing_id' ).val();
				var isEdit    = editingId !== '';
				var $btn      = $( this );
				var $spinner  = $btn.siblings( '.wcst-spinner' );

				$btn.prop( 'disabled', true );
				$spinner.addClass( 'is-active' );

				var data = {
					action:                   isEdit ? 'wcst_update_tracking' : 'wcst_save_tracking',
					security:                 isEdit ? wcstAdmin.updateNonce   : wcstAdmin.createNonce,
					order_id:                 wcstAdmin.orderId,
					tracking_provider:        $( '#wcst_tracking_provider' ).val(),
					custom_tracking_provider: $( '#wcst_custom_tracking_provider' ).val(),
					custom_tracking_link:     $( '#wcst_custom_tracking_link' ).val(),
					tracking_number:          trackingNumber,
					date_shipped:             $( '#wcst_date_shipped' ).val(),
				};

				if ( isEdit ) {
					data.tracking_id = editingId;
				}

				$.ajax( {
					url:    wcstAdmin.ajaxUrl,
					method: 'POST',
					data:   data,
					success: function ( response ) {
						if ( response.success ) {
							if ( isEdit ) {
								$( '#wcst-item-' + editingId ).replaceWith( response.data.html );
							} else {
								$( '#wcst-tracking-items' ).append( response.data.html );
							}
							WCSTAdmin.resetForm();
							$( '#wcst-tracking-form' ).hide();
						} else {
							alert( ( response.data && response.data.message ) ? response.data.message : wcstAdmin.i18n.error );
						}
					},
					error: function () {
						alert( wcstAdmin.i18n.error );
					},
					complete: function () {
						$btn.prop( 'disabled', false );
						$spinner.removeClass( 'is-active' );
					},
				} );
			} );
		},

		resetForm: function () {
			$( '#wcst_tracking_provider' ).val( '' ).trigger( 'change' );
			$( '#wcst_custom_tracking_provider' ).val( '' );
			$( '#wcst_tracking_number' ).val( '' );
			$( '#wcst_custom_tracking_link' ).val( '' );
			$( '#wcst_editing_id' ).val( '' );
			WCSTAdmin.clearFieldError( $( '#wcst_tracking_number' ) );
		},

		// ----------------------------------------------------------------
		// Copy tracking number to clipboard
		// ----------------------------------------------------------------
		copyToClipboard: function ( text ) {
			if ( navigator.clipboard && window.isSecureContext ) {
				return navigator.clipboard.writeText( text );
			}
			// Fallback: textarea + execCommand (HTTP / older browsers).
			var ta = document.createElement( 'textarea' );
			ta.value = text;
			ta.style.cssText = 'position:fixed;opacity:0;pointer-events:none;';
			document.body.appendChild( ta );
			ta.focus();
			ta.select();
			try { document.execCommand( 'copy' ); } catch ( e ) {}
			document.body.removeChild( ta );
			return Promise.resolve();
		},

		bindCopyTracking: function () {
			$( document ).on( 'click', '.wcst-copy-btn', function () {
				var $btn = $( this );
				var text = $btn.data( 'copy' );

				if ( ! text ) {
					return;
				}

				WCSTAdmin.copyToClipboard( String( text ) ).then( function () {
					$btn.addClass( 'wcst-copy-btn--copied' );
					setTimeout( function () {
						$btn.removeClass( 'wcst-copy-btn--copied' );
					}, 1500 );
				} );
			} );
		},

		// ----------------------------------------------------------------
		// Delete tracking via AJAX
		// ----------------------------------------------------------------
		bindDeleteTracking: function () {
			$( document ).on( 'click', '.wcst-delete-item', function ( e ) {
				e.preventDefault();

				if ( ! window.confirm( wcstAdmin.i18n.confirmDelete ) ) {
					return;
				}

				var $item      = $( this ).closest( '.wcst-tracking-item' );
				var trackingId = $( this ).data( 'tracking-id' );
				var orderId    = $( this ).data( 'order-id' );

				$item.css( 'opacity', '0.5' );

				$.ajax( {
					url:    wcstAdmin.ajaxUrl,
					method: 'POST',
					data:   {
						action:      'wcst_delete_tracking',
						security:    wcstAdmin.deleteNonce,
						order_id:    orderId,
						tracking_id: trackingId,
					},
					success: function ( response ) {
						if ( response.success ) {
							$item.fadeOut( 200, function () {
								$( this ).remove();
							} );
						} else {
							$item.css( 'opacity', '1' );
							alert( ( response.data && response.data.message ) ? response.data.message : wcstAdmin.i18n.error );
						}
					},
					error: function () {
						$item.css( 'opacity', '1' );
						alert( wcstAdmin.i18n.error );
					},
				} );
			} );
		},
	};

	$( document ).ready( function () {
		WCSTAdmin.init();
	} );

} )( jQuery );
