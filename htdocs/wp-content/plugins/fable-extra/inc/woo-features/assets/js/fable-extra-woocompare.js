( function( $ ) {

	'use strict';

	$( document ).ready( function() {

		var fableExtraWooLoadingClass = 'loading',
			fableExtraWooAddedClass   = 'added in_compare',
			btnSelector       = '.compare-btn';

		$( document ).on( 'fable_extra_compare_update_fragments', updateFragments )

		function productButtonsInit() {

			$( btnSelector ).each( function() {

				var button = $( this );

				button.on( 'click', function ( event ) {

					event.preventDefault();

					var url  = fableExtraWoocompare.ajaxurl,
						data = {
							action: 'fable_extra_woocompare_add_to_list',
							pid:    button.data( 'id' ),
							nonce:  button.data( 'nonce' ),
							single: button.hasClass( 'compare-btn-single' )
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

								switch ( response.data.action ) {

									case 'add':

										$( btnSelector + '[data-id=' + data.pid + ']' )
											.addClass( fableExtraWooAddedClass )
											.find( '.text' )
											.html( fableExtraWoocompare.removeText );

										if( response.data.comparePageBtn ) {

											button.after( response.data.comparePageBtn );
										}
										break;

									case 'remove':

										$( btnSelector + '[data-id=' + data.pid + ']' )
											.removeClass( fableExtraWooAddedClass )
											.find( '.text' )
											.text( fableExtraWoocompare.compareText );

										$( '.fable-extra-woocompare-page-button' ).remove();

										break;

									default:

										break;
								}
								data = {
									action: 'fable_extra_woocompare_update'
								};
								fableExtraWoocompareAjax( null, data );
							}

							if ( undefined !== response.data.counts ) {
								$( document ).trigger( 'fable_extra_compare_update_fragments', { response: response.data.counts } );
							}

						}
					);
				} );
			} );
		}

		function fableExtraWoocompareAjax( event, data ) {

			if( event ) {

				event.preventDefault();
			}

			var url           = fableExtraWoocompare.ajaxurl,
				widgetWrapper = $( 'div.fable-extra-woocompare-widget-wrapper' ),
				compareList   = $( 'div.fable-extra-woocompare-list' );

			data.isComparePage = !!compareList.length;
			data.isWidget      = !!widgetWrapper.length;

			if ( 'fable_extra_woocompare_update' === data.action && !data.isComparePage && !data.isWidget ) {

				return;
			}
			compareList.addClass( fableExtraWooLoadingClass );
			widgetWrapper.addClass( fableExtraWooLoadingClass );

			$.post(
				url,
				data,
				function( response ) {

					compareList.removeClass( fableExtraWooLoadingClass );
					widgetWrapper.removeClass( fableExtraWooLoadingClass );

					if( response.success ) {

						if( data.isComparePage ) {

							$( 'div.fable-extra-woocompare-wrapper' ).html( response.data.compareList );
							$( document ).trigger( 'enhance.tablesaw' );
						}
						if( data.isWidget ) {

							widgetWrapper.html( response.data.widget );
						}
						if ( 'fable_extra_woocompare_empty' === data.action ) {

							$( btnSelector )
								.removeClass( fableExtraWooAddedClass )
								.find( '.text' )
								.text( fableExtraWoocompare.compareText );

							$( '.fable-extra-woocompare-page-button' ).remove();
						}
						if ( 'fable_extra_woocompare_remove' === data.action ) {

							$( btnSelector + '[data-id=' + data.pid + ']' )
								.removeClass( fableExtraWooAddedClass )
								.find( '.text' )
								.text( fableExtraWoocompare.compareText );

							$( '.fable-extra-woocompare-page-button' ).remove();
						}
					}

					if ( undefined !== response.data.counts ) {
						$( document ).trigger( 'fable_extra_compare_update_fragments', { response: response.data.counts } );
					}

					widgetButtonsInit();
				}
			);
		}

		function fableExtraWoocompareRemove( event ) {

			var button = $( event.currentTarget ),
				data   = {
					action: 'fable_extra_woocompare_remove',
					pid:    button.data( 'id' ),
					nonce:  button.data( 'nonce' )
				};

			fableExtraWoocompareAjax( event, data );
		}

		function fableExtraWoocompareEmpty( event ) {

			var data = {
				action: 'fable_extra_woocompare_empty'
			};

			fableExtraWoocompareAjax( event, data );
		}

		function widgetButtonsInit() {

			$( '.fable-extra-woocompare-remove' )
				.off( 'click' )
				.on( 'click', function ( event ) {
					fableExtraWoocompareRemove( event );
				} );

			$( '.fable-extra-woocompare-empty' )
				.off( 'click' )
				.on( 'click', function( event ) {
					fableExtraWoocompareEmpty( event );
				} );
		}

		function getRefreshedFragments() {

			$.ajax({
				url: fableExtraWoocompare.ajaxurl,
				type: 'get',
				dataType: 'json',
				data: {
					action: 'fable_extra_compare_get_fragments'
				}
			}).done( function( response ) {

				$( document ).trigger( 'fable_extra_compare_update_fragments', { response: response.data } );

			});

		}

		function updateFragments( event, data ) {

			if ( ! $.isEmptyObject( data.response.defaultFragments ) ) {
				$.each( data.response.defaultFragments, function( key, val ) {
					var $item  = $( key ),
						$count = $( '.compare-count', $item );
					if ( 0 === $count.length ) {
						$item.append( fableExtraWoocompare.countFormat.replace( '%count%', val ) );
					} else {
						$item.find( '.compare-count' ).html( val );
					}
				} );
			}

			if ( ! $.isEmptyObject( data.response.customFragments ) ) {
				$.each( data.response.customFragments, function( key, val ) {
					var $item = $( key );
					if ( $item.length ) {
						$item.html( val );
					}
				} );
			}

		}

		widgetButtonsInit();
		productButtonsInit();
		getRefreshedFragments();

		$( document ).on( 'fable_extra_wc_products_changed', function() {
			widgetButtonsInit();
			productButtonsInit();
		} );
	} );
}( jQuery) );