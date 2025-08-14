( function( $ ) {

	'use strict';

	$( document ).ready( function() {

		var fableExtraWooLoadingClass = 'loading',
			fableExtraWooAddedClass   = 'added in_wishlist',
			buttonSelector    = '.fable-extra-woowishlist-button';

		function productButtonsInit() {

			$( buttonSelector ).each( function() {

				var button = $( this );

				button.on( 'click', function ( event ) {

					event.preventDefault();

					if( button.hasClass( 'in_wishlist' ) ) {

						return;
					}

					var url  = fableExtraWoowishlist.ajaxurl,
						data = {
							action: 'fable_extra_woowishlist_add',
							pid:    button.data( 'id' ),
							nonce:  button.data( 'nonce' ),
							single: button.hasClass( '.fable-extra-woowishlist-button-single' )
						};

					button
						.removeClass( fableExtraWooAddedClass )
						.addClass( fableExtraWooLoadingClass );

					$.post(
						url,
						data,
						function( response ) {

							button.removeClass( fableExtraWooLoadingClass );

							if( response.success ) {

								button
									.addClass( fableExtraWooAddedClass )
									.find( '.text' )
									.html( fableExtraWoowishlist.addedText );

								if( response.data.wishlistPageBtn ) {

									button.after( response.data.wishlistPageBtn );
								}
								var data = {
									action: 'fable_extra_woowishlist_update'
								};
								fableExtraWoowishlistAjax( null, data );
							}
						}
					);
				} );
			} );
		}

		function fableExtraWoowishlistAjax( event, data ) {

			if( event ) {
				event.preventDefault();
			}

			var url           = fableExtraWoowishlist.ajaxurl,
				widgetWrapper = $( 'div.fable-extra-woocomerce-wishlist-widget-wrapper' ),
				wishList      = $( 'div.fable-extra-woowishlist' );

			data.isWishlistPage = !!wishList.length;
			data.isWidget       = !!widgetWrapper.length;

			if ( 'fable_extra_woowishlist_update' === data.action && !data.isWishlistPage && !data.isWidget ) {
				return;
			}
			if( data.isWishlistPage ) {

				data.wishListData = JSON.stringify( wishList.data() );
			}
			wishList.addClass( fableExtraWooLoadingClass );

			widgetWrapper.addClass( fableExtraWooLoadingClass );

			$.post(
				url,
				data,
				function( response ) {

					wishList.removeClass( fableExtraWooLoadingClass );

					widgetWrapper.removeClass( fableExtraWooLoadingClass );

					if( response.success ) {

						if( data.isWishlistPage ) {

							$( '.fable-extra-woowishlist-wrapper' ).html( response.data.wishList );
						}
						if( data.isWidget ) {

							widgetWrapper.html( response.data.widget );
						}
						if ( 'fable_extra_woowishlist_remove' === data.action ) {

							$( buttonSelector + '[data-id=' + data.pid + ']' ).removeClass( fableExtraWooAddedClass ).find( '.text' ).text( fableExtraWoowishlist.addText );

							$( buttonSelector + '[data-id=' + data.pid + ']' ).next( '.fable-extra-woowishlist-page-button' ).remove();
						}
					}
					widgetButtonsInit();
				}
			);
		}

		function fableExtraWoowishlistRemove( event ) {

			console.log(event);

			var button = $( event.currentTarget ),
				data   = {
					action: 'fable_extra_woowishlist_remove',
					pid:    button.data( 'id' ),
					nonce:  button.data( 'nonce' )
				};

			fableExtraWoowishlistAjax( event, data );
		}

		function widgetButtonsInit() {

			$( '.fable-extra-woowishlist-remove' )
				.off( 'click' )
				.on( 'click', function ( event ) {
					fableExtraWoowishlistRemove( event );
				} );
		}
		widgetButtonsInit();
		productButtonsInit();

		$( document ).on( 'fable_extra_wc_products_changed', function() {
			widgetButtonsInit();
			productButtonsInit();
		} );
	} );
}( jQuery) );