(function( $ ) {
	$( document ).ready( function() {
		/*Explorer*/
		if ( $( '.ie7' ).find( '#reposter_header-image' ).children( 'img' ).attr( 'src' ) == '' ) {
			$( '#header-image' ).remove();
		}
		if ( $( '.ie8' ).find( '#reposter_header-image' ).children( 'img' ).attr( 'src' ) == '' ) {
			$( '#header-image' ).remove();
		}
		/*Menu*/
		$( '.menu-custom-container' ).on( 'mouseover', '.menu-item-has-children', function() {
			$( this ).find( '.sub-menu' ).each( function( e ) {
				if ( ( $( this ).offset().left + $( this ).width() ) > $( window ).width() ) {
					$( this ).css( 'left', '-100%' );
				}
			} );
		} );

		$( '#comments' ).find( '.wrap_sub' ).remove();
		/*Search*/
		$( ".search-box" ).click( function() {
			$( ".search-box" ).val( '' );
		} );
		$( ".search-box" ).keyup( function() {
			value = $( this ).val();
		} );
		/*Customize widgets*/
		$( '#calendar_wrap table' ).unwrap();
		$( 'table#wp-calendar' ).wrap( '<ul></ul>' );
		$( 'div.tagcloud' ).wrap( '<ul></ul>' );
		$( 'div.textwidget' ).wrap( '<ul></ul>' );
		/*Customize lists*/
		$( 'dl, ol, ul' ).prev().toggleClass( 'list' );
		$( '#reposter_header ul.menu' ).parent().css( { 'float': 'right' } );
		/*Scroll top*/
		$( ".reposter_back-top a" ).click( function() {
			$( 'html,body' ).animate( {
				scrollTop: 0
			}, 700 );
			return false;
		} );
		/*Customize forms*/
		$( 'textarea' ).parent().css( { 'padding-bottom': '7px', 'margin-top': '-2px' } );
		$( 'textarea' ).parent().next().css( { 'padding-bottom': '0px' } );
		/*Customize file-input*/
		$( 'input[type="file"]' ).css( { 'opacity': 0 } ).wrap( '<div class="wrap_file"></div>' );
		$( '.wrap_file' ).wrap( '<div class="style_file"></div>' );
		$( '.style_file' ).append( '<span class="text_file">' + reposterStringJs.buttonFile + '</span>' );
		$( '.style_file' ).append( '<span class="file_text"></span>' );
		$( '.style_file' ).append( $( '.style_file' ).next( 'label' ) );
		if ( $( 'input[type="file"]' ).val() == '' ) {
			$( '.file_text' ).text( reposterStringJs.noFile );
		}
		$( 'input[type="file"]' ).on( 'change', function() {
			$( '.file_text' ).text( $( this )[ 0 ].files[ 0 ][ 'name' ] );
		} );
		$( '.text_file' ).click( function() {
			$( '.wrap_file input' ).trigger( 'click' );
		} );
		/*Customize select*/
		$( 'select' ).addClass( 'selectBlock' ).wrap( "<div class='select'></div>" );
		/*Add class to html tag*/
		$( 'html' ).addClass( 'stylish-select' );
		/*Create cross-browser indexOf*/
		Array.prototype.indexOf = function( obj, start ) {
			for ( var i = ( start || 0 ); i < this.length; i++ ) {
				if ( this[ i ] == obj ) {
					return i;
				}
			}
		};

		/*Utility methods*/
		$.fn.extend( {
			getSetSSValue: function( value ) {
				if ( value ) {
					/*set value and trigger change event*/
					$( this ).val( value ).change();
					return this;
				} else {
					return $( this ).find( ':selected' ).val();
				}
			},

			resetSS: function() {
				var oldOpts = $( this ).data( 'ssOpts' );
				$this       = $( this );
				$this.next().remove();
				/*unbind all events and redraw*/
				$this.unbind( '.sSelect' ).sSelect( oldOpts );
			}
		} );

		$.fn.sSelect = function( options ) {

			return this.each( function() {
				var defaults = {
					defaultText:    $( this ).find( 'option:first' ).text(),
					/*set speed of dropdown*/
					animationSpeed: 0,
					/*set css max-height value of dropdown*/
					ddMaxHeight:    '',
					/*additional classes for container div*/
					containerClass: ''
				};

				/*initial variables*/
				var opts              = $.extend( defaults, options ),
						$input            = $( this ),
						$containerDivText = $( '<div class="selectedTxt"></div>' ),
						$containerDiv     = $( '<div class="newListSelected ' + opts.containerClass + '"></div>' ),
						$newUl            = $( '<ul class="newList" style = "visibility:hidden;"></ul>' ),
						itemIndex         = -1,
						currentIndex      = -1,
						keys              = [],
						prevKey           = false,
						prevented         = false,
						$newLi;

				$( this ).data( 'ssOpts', options );

				/*build new list*/
				$containerDiv.insertAfter( $input );
				$containerDiv.attr( "tabindex", $input.attr( "tabindex" ) || "0" );
				$containerDivText.prependTo( $containerDiv );
				$newUl.appendTo( $containerDiv );
				$input.hide();

				/*added by Justin Beasley ( used for lists initialized while hidden )*/
				$containerDivText.data( 'ssReRender', !$containerDivText.is( ':visible' ) );

				/*test for optgroup*/
				if ( $input.children( 'optgroup' ).length == 0 ) {
					$input.children().each( function( i ) {
						var option = $( this ).html();
						var key    = $( this ).val();

						/*add first letter of each word to array*/
						keys.push( option.charAt( 0 ).toLowerCase() );
						if ( $( this ).attr( 'selected' ) == true ) {
							opts.defaultText = option;
							currentIndex     = i;
						}
						$newUl.append( $( '<li><a href = "JavaScript:void(0);">' + option + '</a></li>' ).data( 'key', key ) );
					} );
					/*cache list items object*/
					$newLi = $newUl.children().children();

				}
				/*optgroup*/
				else {
					$input.children( 'optgroup' ).each( function() {

						var optionTitle = $( this ).attr( 'label' ),
								$optGroup   = $( '<li class="newListOptionTitle">' + optionTitle + '</li>' );

						$optGroup.appendTo( $newUl );

						var $optGroupList = $( '<ul></ul>' );

						$optGroupList.appendTo( $optGroup );

						$( this ).children().each( function() {
							++itemIndex;
							var option = $( this ).html();
							var key    = $( this ).val();
							/*add first letter of each word to array*/
							keys.push( option.charAt( 0 ).toLowerCase() );
							if ( $( this ).attr( 'selected' ) == true ) {
								opts.defaultText = option;
								currentIndex     = itemIndex;
							}
							$optGroupList.append( $( '<li><a href = "JavaScript:void(0);">' + option + '</a></li>' ).data( 'key', key ) );
						} )
					} );
					/*cache list items object*/
					$newLi = $newUl.find( 'ul li a' );
				}

				/*get heights of new elements for use later*/
				var newUlHeight     = $newUl.height(),
						containerHeight = $containerDiv.height(),
						newLiLength     = $newLi.length;

				/*check if a value is selected*/
				if ( currentIndex != -1 ) {
					navigateList( currentIndex, true );
				} else {
					/*set placeholder text*/
					$containerDivText.text( opts.defaultText );
				}

				/*decide if to place the new list above or below the drop-down*/
				function newUlPos() {
					var containerPosY = $containerDiv.offset().top,
							docHeight     = $( window ).height(),
							scrollTop     = $( window ).scrollTop();

					/*if height of list is greater then max height, set list height to max height value*/
					if ( newUlHeight > parseInt( opts.ddMaxHeight ) ) {
						newUlHeight = parseInt( opts.ddMaxHeight );
					}

					containerPosY = containerPosY - scrollTop;
					if ( containerPosY + newUlHeight >= docHeight ) {
						$newUl.css( {
							top:    '-' + newUlHeight + 'px',
							height: newUlHeight
						} );
						$input.onTop = true;
					} else {
						$newUl.css( {
							top:    containerHeight + 'px',
							height: newUlHeight
						} );
						$input.onTop = false;
					}
				}

				/*run function on page load*/
				newUlPos();

				/*run function on browser window resize*/
				$( window ).bind( 'resize.sSelect scroll.sSelect', newUlPos );

				/*positioning*/
				function positionFix() {
					$containerDiv.css( 'position', 'relative' );
				}

				function positionHideFix() {
					$containerDiv.css( 'position', 'static' );
				}

				$containerDivText.bind( 'click.sSelect', function( event ) {
					event.stopPropagation();

					if ( $( this ).data( 'ssReRender' ) ) {
						newUlHeight     = $newUl.height( '' ).height();
						containerHeight = $containerDiv.height();
						$( this ).data( 'ssReRender', false );
						newUlPos();
					}

					/*hide all menus apart from this one*/
					$( '.newList' ).not( $( this ).next() ).hide().parent().css( 'position', 'static' ).removeClass( 'newListSelFocus' );

					/*show/hide this menu*/
					$newUl.toggle();
					positionFix();
					/*scroll list to selected item*/
					$newLi.eq( currentIndex ).focus();

				} );

				$newLi.bind( 'click.sSelect', function( e ) {
					var $clickedLi = $( e.target );

					/*update counter*/
					currentIndex = $newLi.index( $clickedLi );

					/*remove all hilites, then add hilite to selected item*/
					prevented = true;
					navigateList( currentIndex );
					$newUl.hide();
					/*ie*/
					$containerDiv.css( 'position', 'static' );

				} );

				$newLi.bind( 'mouseenter.sSelect', function( e ) {
					var $hoveredLi = $( e.target );
					$hoveredLi.addClass( 'newListHover' );
				} ).bind( 'mouseleave.sSelect', function( e ) {
					var $hoveredLi = $( e.target );
					$hoveredLi.removeClass( 'newListHover' );
				} );

				function navigateList( currentIndex, init ) {
					$newLi.removeClass( 'hiLite' ).eq( currentIndex ).addClass( 'hiLite' );

					if ( $newUl.is( ':visible' ) ) {
						$newLi.eq( currentIndex ).focus();
					}

					var text = $newLi.eq( currentIndex ).html();
					var val  = $newLi.eq( currentIndex ).parent().data( 'key' );

					/*page load*/
					if ( init == true ) {
						$input.val( val );
						$containerDivText.text( text );
						return false;
					}

					try {
						$input.val( val )
					} catch ( ex ) {
						/* handle ie6 exception*/
						$input[ 0 ].selectedIndex = currentIndex;
					}

					$input.change();
					$containerDivText.text( text );
				}

				$input.bind( 'change.sSelect', function( event ) {
					$targetInput = $( event.target );
					/*stop change function from firing*/
					if ( prevented == true ) {
						prevented = false;
						return false;
					}
					$currentOpt  = $targetInput.find( ':selected' );
					currentIndex = $targetInput.find( 'option' ).index( $currentOpt );
					navigateList( currentIndex, true );
				} );

				/*handle up and down keys*/
				function keyPress( element ) {
					/*when keys are pressed*/
					$( element ).unbind( 'keydown.sSelect' ).bind( 'keydown.sSelect', function( e ) {
						var keycode = e.which;

						/*prevent change function from firing*/
						prevented = true;

						switch ( keycode ) {
							/*down*/
							case 40:
							/*right*/
							case 39:
								incrementList();
								return false;
								break;
							/*up*/
							case 38:
							/*left*/
							case 37:
								decrementList();
								return false;
								break;
							/*page up*/
							case 33:
							/*home*/
							case 36:
								gotoFirst();
								return false;
								break;
							/*page down*/
							case 34:
							/*end*/
							case 35:
								gotoLast();
								return false;
								break;
							case 13:
							case 27:
								$newUl.hide();
								positionHideFix();
								return false;
								break;
						}

						/*check for keyboard shortcuts*/
						keyPressed = String.fromCharCode( keycode ).toLowerCase();

						var currentKeyIndex = keys.indexOf( keyPressed );

						if ( typeof currentKeyIndex != 'undefined' ) {
							++currentIndex;
							/*search array from current index*/
							currentIndex = keys.indexOf( keyPressed, currentIndex );
							/*if no entry was found or new key pressed search from start of array*/
							if ( currentIndex == -1 || currentIndex == null || prevKey != keyPressed ) {
								currentIndex = keys.indexOf( keyPressed );
							}
							navigateList( currentIndex );
							/*store last key pressed*/
							prevKey = keyPressed;
							return false;
						}
					} );
				}

				function incrementList() {
					if ( currentIndex < ( newLiLength - 1) ) {
						++currentIndex;
						navigateList( currentIndex );
					}
				}

				function decrementList() {
					if ( currentIndex > 0 ) {
						--currentIndex;
						navigateList( currentIndex );
					}
				}

				function gotoFirst() {
					currentIndex = 0;
					navigateList( currentIndex );
				}

				function gotoLast() {
					currentIndex = newLiLength - 1;
					navigateList( currentIndex );
				}

				$containerDiv.bind( 'click.sSelect', function( e ) {
					e.stopPropagation();
					keyPress( this );
				} );

				$containerDiv.bind( 'focus.sSelect', function() {
					$( this ).addClass( 'newListSelFocus' );
					keyPress( this );
				} );

				$containerDiv.bind( 'blur.sSelect', function() {
					$( this ).removeClass( 'newListSelFocus' );
				} );

				/*hide list on blur*/
				$( document ).bind( 'click.sSelect', function() {
					$containerDiv.removeClass( 'newListSelFocus' );
					$newUl.hide();
					positionHideFix();
				} );

				/*add classes on hover*/
				$containerDivText.bind( 'mouseenter.sSelect', function( e ) {
					var $hoveredTxt = $( e.target );
					$hoveredTxt.parent().addClass( 'newListSelHover' );
				} ).bind( 'mouseleave.sSelect', function( e ) {
					var $hoveredTxt = $( e.target );
					$hoveredTxt.parent().removeClass( 'newListSelHover' );
				} );

				/*reset left property and hide*/
				$newUl.css( {
					left:       '0',
					display:    'none',
					visibility: 'visible'
				} );
			} );
		};

		$( '.selectBlock' ).sSelect();

		/*Customize checkbox/radio*/
		$( "input[type='checkbox']" ).wrap( "<div class='forms-elements-checkboxes'></div>" );
		$( "input[type='radio']" ).wrap( "<div class='forms-elements-radiobuttons'></div>" );
		$( 'input[type="checkbox"]' ).css( { 'opacity': 0 } ).wrap( '<div class="wrap-checkbox"></div>' );

		$( '.wrap-checkbox' ).click( function() {
			$( this ).toggleClass( 'active' );
		} );

		$( '.wrap-checkbox' ).hover( function() {
			$( this ).toggleClass( 'hover' );
		} );

		$( 'input[type="radio"]' ).css( { 'opacity': 0 } ).wrap( '<div class="wrap-radio"></div>' );

		$( '.wrap-radio' ).click( function() {
			$( '.wrap-radio' ).removeClass( 'active' );
			$( this ).toggleClass( 'active' );
		} );

		$( '.wrap-radio' ).hover( function() {
			$( this ).toggleClass( 'hover' );
		} );

		/*Reset button*/
		$( "input[type='reset']" ).addClass( 'reset_button' );
		$( '.reset_button' ).click( function() {
			$( this ).parent().parent().find( 'input[type="text"]' ).each( function() {
				$( this ).val( '' );
			} );
			$( 'textarea' ).each( function() {
				$( this ).val( '' );
			} );
			$( "input[type='radio']" ).each( function() {
				$( this ).checked = false;
				if ( $( this ).parent().hasClass( 'active' ) ) {
					$( this ).parent().removeClass( 'active' );
					$( this ).removeAttr( "active" );
				}
			} );
			$( 'input[type="checkbox"]' ).each( function() {
				if ( $( this ).parent().hasClass( 'active' ) ) {
					$( this ).parent().removeClass( 'active' );
					$( this ).removeAttr( "active" );
				}
			} );
			$( 'input[type="file"]' ).each( function() {
				$( this ).val( '' );
				$( '.text_file' ).text( 'Choose file..' );
				if ( $( this ).val() != '' ) {
					( $( '.file_text' ).text( '' ) )
				}
			} );
		} );
		$( '.widgets li' ).find( 'h2.list' ).removeClass();
		$( '.widgets h3' ).removeClass( 'list' );
		$( '#slider_box' ).children( 'h1' ).removeClass( 'heading' );

		/*Slider*/
		if ( $( '.slides li' ).children( 'img' ).length <= 0 ) {
			$( '.slides li' ).append( "<h2 class='no-image'>" + reposterStringJs.noImage + "</h2>" )
		}
		$( window ).load( function() {
			$( '.flexslider' ).flexslider( {
				slideshowSpeed: 5000,
				pauseOnAction:  true,
				pauseOnHover:   true,
				animation:      "slide",
				slideshow:      true,
				animationLoop:  true,
				directionNav:   false,
			} );
		} );

		$( '.selectedTxt' ).click( function() {
			if ( $( this ).next().children( '.newListOptionTitle' ).length <= 0 ) {
				$( this ).next().find( 'li' ).addClass( 'opt_class' );
			}
		} );
		/*Fix for portfolio/gallery plugin*/
		if ( $( '#reposter_wrapper-content' ).find( '#container' ).length > 0 ) {
			$( '#container' ).addClass( 'reposter_cont fix_cont' );
			$( '.fix_cont' ).wrap( "<section id='reposter_left-side' class='fix_side'><article class='post fix_post'></article></section>" );
			$( '.fix_side, #reposter_right-side' ).wrapAll( "<div id='reposter_width' class='fix_width'><div id='reposter_main' class='fix_content'><div id='reposter_main_content' class='fix_main'></div><div class='reposter_clear'></div></div></div>" );
			$( '.fix_width' ).after( "<div class='reposter_clear'></div>" );
		}
	} );
})( jQuery );

(function( $ ) {
	$( document ).ready( function() {
		/* Check of previous selected items */
		$( 'select' ).each( function() {
			var index = $( this ).find( "option[selected]" ).index();
			if ( index >= 0 ) {
				/*add attr selected to select*/
				var selected_select = $( this ).find( "option[selected]" );
				/*write text to active opt*/
				$( this ).next().find( 'div:first' ).text( selected_select.text() );
			}
		} );
		/* Clear select elements */
		$( 'input:reset' ).click( function() {
			/* Clear original selects. */
			$( 'select' ).each( function() {
				/* set path */
				var clear_select          = $( this ).find( "option:first" );
				var clear_selected_select = $( this ).find( "option[selected]" );
				/* clear active opt */
				$( clear_selected_select ).removeAttr( 'selected' );
				$( clear_select ).attr( 'selected', 'selected' );
			} );
			/* Clear custom selects. */
			$( '.newListSelected' ).each( function() {
				/* set path */
				var clear_select = $( this ).find( "div:first" );
				/* clear active opt */
				$( clear_select ).text( $( this ).prev().find( "option:first" ).text() );
			} );
			e.preventDefault();
		} );
	} );
})( jQuery );