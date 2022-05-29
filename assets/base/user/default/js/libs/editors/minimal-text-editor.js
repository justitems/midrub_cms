/*
 * Minimal Text Editor JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Format the text
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.main .theme-minimal-text-editor-toolbar .btn-option', function (e) {
        e.preventDefault();

        // Get format's type
        let type = $(this).attr('data-type');

        // Format the text
        document.execCommand(type, false, null);
        
        // Add changes
        $(this).closest('.card').find('.theme-minimal-text-editor').focus();

    });

    /*
     * Enter a link
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.main .theme-minimal-text-editor-toolbar .btn-link-add', function (e) {
        e.preventDefault();

        // Show prompt
        var link = prompt(words.write_url_here, 'https:\/\/');

        // Verify if url exists
        if( link !='' && link != 'https://' ) {

            // Format the text
            document.execCommand('createlink', false, link);
            
            // Add changes
            $(this).closest('.card').find('.theme-minimal-text-editor').focus();

        }

    });

});