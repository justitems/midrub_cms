/*
 * Documentation main javascript file
 * 
 * @since   0.0.1
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Track dropdown click
     * 
     * @since   0.0.1
     */        
    $( '.nav-menu .dropdown > a' ).click(function (e) {
        e.preventDefault();
        
        // Remove open class
        $( '.nav-menu .dropdown' ).closest( 'li' ).removeClass( 'open' );
        
        // Add open class
        $( this ).closest( 'li' ).addClass( 'open' );
        
    });
    
    /*
     * Track article click
     * 
     * @since   0.0.1
     */        
    $( '.nav-menu .article' ).click(function (e) {
        e.preventDefault();
        
        // Hide all articles
        $( '.content article' ).hide();
        
        // Display article
        $( $( this ).attr( 'href' ) ).show();
        
    });
    
    /*
     * Track search keyup
     * 
     * @since   0.0.1
     */        
    $('#autocomplete-input').on('keyup', function (e) {
        e.preventDefault();
        
        // Get value
        var value = $(this).val().toLowerCase();
        
        // List articles
        $('.content article').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });

    });

});