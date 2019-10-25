( function( $ ) {

    'use strict';
    var context = $( '#sabox-container' );
    context.find( '.saboxfield' ).on( 'change', function() {
        var value = getElementValue( $( this ) );
        var elements = context.find( '.show_if_' + $( this ).attr( 'id' ) );

        if ( value && '0' != value ) {
            elements.show( 300 );
        } else {
            elements.hide( 250 );
        }
    });

    function getElementValue( $element ) {
        var type = $element.attr( 'type' );
        var name = $element.attr( 'name' );

        if ( 'checkbox' === type ) {
            if ( $element.is( ':checked' ) ) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return $element.val();
        }
    }

    /**
     * Handle UI tab switching via jQuery instead of relying on CSS only
     */
    function adminTabSwitching() {

        var navTabSelector = '.nav-tab-wrapper .epfw-tab:not( .epfw-tab-link )',
            initialTabHref,
            initialTabID,
            url;

        // Get the current tab
        if ( '' !== window.location.hash && $( window.location.hash + '-tab.epfw-turn-into-tab' ).length > 0 ) {
            initialTabHref = window.location.hash;
        } else {
            initialTabHref = $( navTabSelector + ':first' ).attr( 'href' );
        }

        initialTabID = initialTabHref + '-tab';

        /**
         * Default tab handling
         */

        // Make the first tab active by default
        $( navTabSelector + '[href="' + initialTabHref + '"]' ).addClass( 'nav-tab-active' );

        // Make all the tabs, except the first one hidden
        $( '.epfw-turn-into-tab' ).each( function( index, value ) {
            if ( '#' + $( this ).attr( 'id' ) !== initialTabID ) {
                $( this ).hide();
            }
        });

        /**
         * Listen for click events on nav-tab links
         */
        $( navTabSelector ).click( function( event ) {

            var clickedTab = $( this ).attr( 'href' ) + '-tab';
            $( navTabSelector ).removeClass( 'nav-tab-active' ); // Remove class from previous selector
            $( this ).addClass( 'nav-tab-active' ).blur(); // Add class to currently clicked selector

            $( '.epfw-turn-into-tab' ).each( function( index, value ) {
                if ( '#' + $( this ).attr( 'id' ) !== clickedTab ) {
                    $( this ).hide();
                }

                $( clickedTab ).fadeIn();

            });

        });
    }

    $( document ).ready( function() {
        var elements = context.find( '.saboxfield' ),
            sliders = context.find( '.sabox-slider' ),
            colorpickers = context.find( '.sabox-color' );

        elements.each( function( $index, $element ) {
            var element = $( $element ),
                value = getElementValue( element ),
                elements = context.find( '.show_if_' + element.attr( 'id' ) );
            if ( value && '0' !== value ) {
                elements.removeClass( 'hide' );
            } else {
                elements.addClass( 'hide' );
            }
        });
        if ( sliders.length > 0 ) {
            sliders.each( function( $index, $slider ) {
                var input = $( $slider ).parent().find( '.saboxfield' ),
                    max = input.data( 'max' ),
                    min = input.data( 'min' ),
                    step = input.data( 'step' ),
                    value = parseInt( input.val(), 10 );

                $( $slider ).slider({
                    value: value,
                    min: min,
                    max: max,
                    step: step,
                    slide: function( event, ui ) {
                        input.val( ui.value + 'px' ).trigger( 'change' );
                    }
                });
            });
        }
        if ( colorpickers.length > 0 ) {
            colorpickers.each( function( $index, $colorpicker ) {
                $( $colorpicker ).wpColorPicker({
                    change : function( event, ui ){
                        jQuery( event.target ).val( ui.color.toString() ).trigger( 'change' );
                    }
                });
            });
        }

        adminTabSwitching();

    });

})( jQuery );

