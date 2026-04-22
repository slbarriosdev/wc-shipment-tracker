( function () {
	function wcstCopy( text ) {
		if ( navigator.clipboard && window.isSecureContext ) {
			return navigator.clipboard.writeText( text );
		}
		var ta = document.createElement( 'textarea' );
		ta.value = text;
		ta.style.cssText = 'position:fixed;opacity:0;pointer-events:none;';
		document.body.appendChild( ta );
		ta.focus();
		ta.select();
		try { document.execCommand( 'copy' ); } catch ( e ) {}
		document.body.removeChild( ta );
		return Promise.resolve();
	}

	document.querySelectorAll( '.wcst-copy-btn' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var text = btn.dataset.copy;
			if ( ! text ) { return; }
			wcstCopy( String( text ) ).then( function () {
				btn.classList.add( 'wcst-copy-btn--copied' );
				setTimeout( function () { btn.classList.remove( 'wcst-copy-btn--copied' ); }, 1500 );
			} );
		} );
	} );
} )();
