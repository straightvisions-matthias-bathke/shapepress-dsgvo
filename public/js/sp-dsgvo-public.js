function getCookieValue(a) {
    var b = document.cookie.match('(^|;)\\s*' + a + '\\s*=\\s*([^;]+)');
    return b ? b.pop() : '';
}

( function ( $ ) {

	// set Cookie Notice
	$.fn.setCookieNotice = function ( cookie_value ) {
		if ( cnArgs.onScroll === 'yes' ) {
			$( window ).off( 'scroll', cnHandleScroll );
		}

		var cnTime = new Date(),
			cnLater = new Date(),
			cnDomNode = $( '#cookie-notice' ),
			cnSelf = this;

		// set expiry time in seconds
		cnLater.setTime( parseInt( cnTime.getTime() ) + parseInt( cnArgs.cookieTime ) * 1000 );

		// set cookie
		cookie_value = cookie_value === 'accept' ? true : false;

		if (cookie_value == false && cnArgs.declineNoCookie === '1') {
			// nothing to do here, user should see notice again
		}
		else {
			document.cookie = cnArgs.cookieName + '=' + cookie_value + ';expires=' + cnLater.toGMTString() + ';' + ( cnArgs.cookieDomain !== undefined && cnArgs.cookieDomain !== '' ? 'domain=' + cnArgs.cookieDomain + ';' : '' ) + ( cnArgs.cookiePath !== undefined && cnArgs.cookiePath !== '' ? 'path=' + cnArgs.cookiePath + ';' : '' );
		}
		
		// trigger custom event
		$.event.trigger( {
			type: 'setCookieNotice',
			value: cookie_value,
			time: cnTime,
			expires: cnLater
		} );

		// hide message container
		if ( cnArgs.hideEffect === 'fade' ) {
			cnDomNode.fadeOut( 300, function () {
				cnSelf.removeCookieNotice();
			} );
		} else if ( cnArgs.hideEffect === 'slide' ) {
			cnDomNode.slideUp( 300, function () {
				cnSelf.removeCookieNotice();
			} );
		} else {
			cnSelf.removeCookieNotice();
		}

		if (cookie_value)
		{
			window['ga-disable-'+cnArgs.gaTagNumber] = false;
		} else
		{
			window['ga-disable-'+cnArgs.gaTagNumber] = true;
		}
		
		if ( cookie_value && cnArgs.redirection === '1' ) {
			var url = window.location.protocol + '//',
				hostname = window.location.host + '/' + window.location.pathname;

			if ( cnArgs.cache === '1' ) {
				url = url + hostname.replace( '//', '/' ) + ( window.location.search === '' ? '?' : window.location.search + '&' ) + 'cn-reloaded=1' + window.location.hash;

				window.location.href = url;
			} else {
				url = url + hostname.replace( '//', '/' ) + window.location.search + window.location.hash;

				window.location.reload( true );
			}

			return;
		}else if(cookie_value == false && cnArgs.declineTargetUrl !== '') {
			window.location = cnArgs.declineTargetUrl;
		}
	};

	// remove Cookie Notice
	$.fn.removeCookieNotice = function ( cookie_value ) {
		$( '#cookie-notice' ).remove();
		$( '#cookie-notice-blocker' ).remove();
		$( 'body' ).removeClass( 'cookies-not-accepted' );
	};

	$( document ).ready( function () {
		var cnDomNode = $( '#cookie-notice' );

		// handle on scroll
		if ( cnArgs.onScroll === 'yes' ) {
			cnHandleScroll = function () {
				var win = $( this );

				if ( win.scrollTop() > parseInt( cnArgs.onScrollOffset ) ) {
					// accept cookie
					win.setCookieNotice( 'accept' );

					// remove itself after cookie accept
					win.off( 'scroll', cnHandleScroll );
				}
			};
		}

		// handle set-cookie button click
		$( document ).on( 'click', '.cn-set-cookie', function ( e ) {
			e.preventDefault();

			$( this ).setCookieNotice( $( this ).data( 'cookie-set' ) );
		} );

		// display cookie notice
		if ( document.cookie.indexOf( cnArgs.cookieName ) === -1 ) {
			// handle on scroll
			if ( cnArgs.onScroll === 'yes' ) {
				$( window ).on( 'scroll', cnHandleScroll );
			}

			if ( cnArgs.hideEffect === 'fade' ) {
				cnDomNode.fadeIn( 300 );
			} else if ( cnArgs.hideEffect === 'slide' ) {
				cnDomNode.slideDown( 300 );
			} else {
				cnDomNode.show();
			}

			$( 'body' ).addClass( 'cookies-not-accepted' );
		} else {
			cnDomNode.removeCookieNotice();
		}
		
		// set the correct state of the ga opt-out tracker		
		if (cnArgs.trackerInitMoment == 'on_load') {
			// it tracks until user denies cn
			window['ga-disable-'+cnArgs.gaTagNumber] =  getCookieValue(cnArgs.cookieName) == 'false';
		} else if (cnArgs.trackerInitMoment == 'after_confirm') {
			// it only tracks if user confirms
			window['ga-disable-'+cnArgs.gaTagNumber] =  getCookieValue(cnArgs.cookieName) != 'true';
		}

		// find checkbox
	    // on document change dissable submit button when checkbox is not
		// checked
		if ( cnArgs.commentsCb === '1' ) {
		    var gdpr_checkbox = $('input#gdpr-cb');
		    var errorText = $('.gdpr-cb-info-text');
		    var comments_submit_button = $('#commentform').find(':submit');
		    //var comments_submit_button = $('#send_comment');
		    // on document load disable button to add comments
		    comments_submit_button.prop('disabled', true);
		    comments_submit_button.addClass('gdpr-disabled');
	
		    $(document).on('change', function (e) {
		        if (gdpr_checkbox.prop('checked') === true) {
		            comments_submit_button.prop('disabled', false);
		            comments_submit_button.removeClass('gdpr-disabled');
		            errorText.css('display', 'none');
	
		        }else{
		            comments_submit_button.prop('disabled', true);
		            comments_submit_button.addClass('gdpr-disabled');
		            errorText.css('display', 'inline-block');
		        }
		        // TODO add event listenter for disabled button
		        // when is clicked and has class disabled
		        // show info that user has to check checkbox to submit comment
		    });
		}
		
		if ( cnArgs.cf7AccReplace === '1' ) {
			 var acceptanceLabel = $('.wpcf7-acceptance .wpcf7-list-item-label');
			 if (acceptanceLabel != null) {
				 acceptanceLabel.html(cnArgs.cf7AccText);
			 }
		}
		
	} );
	
	

	    

} )( jQuery );