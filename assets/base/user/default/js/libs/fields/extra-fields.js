/*
 * Default Extra Fields Main JavaScript file
*/

// Default_extra_fields class with all options templates
class Default_extra_fields {

    // Templates list
    templates_list = [];

    set_option_template(template) {

        // Verify if the template has valid parameters
        if ( (typeof template.template_slug !== 'undefined') && (typeof template.option_template !== 'undefined') ) {

            // Add template to the list
            this.templates_list.push(template);

            // Verify if the template has events
            if (typeof template.option_events !== 'undefined') {

                // Verify if events exists
                if ( template.option_events.length > 0 ) {

                    // List all events
                    for ( var e = 0; e < template.option_events.length; e++ ) {

                        // Verify if the event has the expected parameters
                        if ( ( typeof template.option_events[e].type !== 'undefined' ) && ( typeof template.option_events[e].id !== 'undefined' ) && ( typeof template.option_events[e].fun !== 'undefined' ) ) {

                            // Register event
                            $(document).on(template.option_events[e].type, template.option_events[e].id, template.option_events[e].fun);

                        }

                    }

                }

            }

        }

    }

    the_option_template(params) {

        // Verify if the template has valid parameters
        if ( (typeof params.template_slug !== 'undefined') && (typeof params.template_params !== 'undefined') ) {

            // Default option
            var option = false;

            // Verify if templates exists
            if ( this.templates_list.length > 0 ) {

                // List the templates
                for ( var t = 0; t < this.templates_list.length; t++ ) {

                    // Verify if is the required template
                    if ( this.templates_list[t].template_slug === params.template_slug ) {

                        // Get the template
                        option = this.templates_list[t].option_template(params.template_params);
                        break;

                    }

                }

            }
            
            return option;

        } else {

            return false;

        }

    }

}

// Init the Default_extra_fields class
let default_extra_fields = new Default_extra_fields();

// Add category template
default_extra_fields.set_option_template({
    template_slug: 'category',
    option_template: function (params) {

        // Category name
        let category_name = (typeof params.name !== 'undefined')?params.name:'';      

        // Template
        var html = '<div class="default-extra-field-header">'
            + '<h2>'
                + category_name
            + '</h2>'
        + '</div>';

        // Return empty
        return html;

    }

});

// Add text template
default_extra_fields.set_option_template({
    template_slug: 'text',
    option_template: function (params) {

        // Unique id
        let unique_id = Math.floor(Math.random() * 1000);

        // ID
        let id = (typeof params.id !== 'undefined')?' data-id="' + params.id + '"':'';

        // Label
        let label = (typeof params.label !== 'undefined')?params.label:'';    

        // Placeholder
        let placeholder = (typeof params.placeholder !== 'undefined')?params.placeholder:'';

        // value
        let value = (typeof params.value !== 'undefined')?' value="' + params.value + '"':''; 
        
        // Required option
        var required = '';

        // Verify if required parameter exists
        if ( typeof params.required !== 'undefined' ) {

            // Verify if the option is required
            if ( params.required ) {

                // Mark the option as required
                required = '<span class="default-extra-field-required">'
                    + '*'
                + '</span>';

            }

        }

        // Template
        var html = '<div class="form-group default-extra-field-text-1"' + id + '>'
            + '<input type="text" placeholder="' + placeholder + '"' + value + ' class="form-control" id="default-extra-field-text-1-' + unique_id + '" />'
            + '<label for="default-extra-field-text-1-' + unique_id + '">'
                + label
                + required
            + '</label>'
        + '</div>';

        // Return empty
        return html;

    }

});

// Add textarea template
default_extra_fields.set_option_template({
    template_slug: 'textarea',
    option_template: function (params) {

        // Unique id
        let unique_id = Math.floor(Math.random() * 1000);

        // ID
        let id = (typeof params.id !== 'undefined')?' data-id="' + params.id + '"':'';

        // Label
        let label = (typeof params.label !== 'undefined')?params.label:'';    

        // Placeholder
        let placeholder = (typeof params.placeholder !== 'undefined')?params.placeholder:'';

        // value
        let value = (typeof params.value !== 'undefined')?params.value:'';  
        
        // Required option
        var required = '';

        // Verify if required parameter exists
        if ( typeof params.required !== 'undefined' ) {

            // Verify if the option is required
            if ( params.required ) {

                // Mark the option as required
                required = '<span class="default-extra-field-required">'
                    + '*'
                + '</span>';

            }

        }

        // Template
        var html = '<div class="form-group default-extra-field-textarea-1"' + id + '>'
            + '<textarea placeholder="' + placeholder + '" id="default-extra-field-textarea-1-' + unique_id + '">' + value + '</textarea>'
            + '<label for="default-extra-field-textarea-1-' + unique_id + '">'
                + label
                + required
            + '</label>'
        + '</div>';

        // Return empty
        return html;

    }

});

// Add number template
default_extra_fields.set_option_template({
    template_slug: 'number',
    option_template: function (params) {

        // ID
        let id = (typeof params.id !== 'undefined')?' data-id="' + params.id + '"':'';

        // Icon
        let icon = (typeof params.icon !== 'undefined')?params.icon:'';

        // Name
        let name = (typeof params.name !== 'undefined')?params.name:'';
        
        // Description
        let description = (typeof params.description !== 'undefined')?params.description:'';

        // Placeholder
        let placeholder = (typeof params.placeholder !== 'undefined')?params.placeholder:0;
        
        // Placeholder
        let value = (typeof params.value !== 'undefined')?' value="' + params.value + '"':'';        

        // Required option
        var required = '';

        // Verify if required parameter exists
        if ( typeof params.required !== 'undefined' ) {

            // Verify if the option is required
            if ( params.required ) {

                // Mark the option as required
                required = '<span class="default-extra-field-required">'
                    + '*'
                + '</span>';

            }

        }

        // Template
        var html = '<div class="form-group default-extra-field-number-1 d-flex"' + id + '>'
            + '<div class="default-extra-icon">'
                + icon
            + '</div>'
            + '<div class="default-extra-text">'
                + '<h4>'
                    + name
                    + required
                + '</h4>'
                + '<p>'
                    + description
                + '</p>'
            + '</div>'
            + '<div>'
                + '<div class="default-extra-field-number-1-option">'
                    + '<div class="input-group">'
                        + '<input type="text" placeholder="' + placeholder + '"' + value + ' class="form-control" />'
                        + '<div class="input-group-append">'
                            + '<div class="btn-group" role="group" aria-label="Number Input">'
                                + '<button type="button" class="btn btn-secondary default-extra-field-number-1-option-decrease-btn">'
                                    + words.icon_minus
                                + '</button>'
                                + '<button type="button" class="btn btn-secondary default-extra-field-number-1-option-increase-btn">'
                                    + words.icon_plus
                                + '</button>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>'
            + '</div>'                                          
        + '</div>';

        // Return empty
        return html;

    },
    option_events: [
        {
            'type': 'input',
            'id': '.main .default-extra-fields .default-extra-field-number-1-option input[type="text"]',
            'fun': function(e) {
                e.preventDefault();

                // Allow only number
                $(this).val($(this).val().replace(/[^0-9]/g, ''));

            }

        },
        {
            'type': 'click',
            'id': '.main .default-extra-fields .default-extra-field-number-1-option .default-extra-field-number-1-option-decrease-btn',
            'fun': function(e) {
                e.preventDefault();

                // Get the value
                var value = $(this).closest('.default-extra-field-number-1-option').find('input[type="text"]').val().replace(/[^0-9]/g, '');

                // Decrease
                value = (value > 0)?(value - 1):0;

                // Refresh the value
                $(this).closest('.default-extra-field-number-1-option').find('input[type="text"]').val(value);

            }

        },
        {
            'type': 'click',
            'id': '.main .default-extra-fields .default-extra-field-number-1-option .default-extra-field-number-1-option-increase-btn',
            'fun': function(e) {
                e.preventDefault();

                // Get the value
                var value = $(this).closest('.default-extra-field-number-1-option').find('input[type="text"]').val().replace(/[^0-9]/g, '');

                // Increase
                value++;

                // Refresh the value
                $(this).closest('.default-extra-field-number-1-option').find('input[type="text"]').val(value);

            }

        }               

    ]

});

// Add checkbox template
default_extra_fields.set_option_template({
    template_slug: 'checkbox',
    option_template: function (params) {

        // Unique id
        let unique_id = Math.floor(Math.random() * 1000);

        // ID
        let id = (typeof params.id !== 'undefined')?' data-id="' + params.id + '"':'';

        // Icon
        let icon = (typeof params.icon !== 'undefined')?params.icon:'';

        // Name
        let name = (typeof params.name !== 'undefined')?params.name:'';
        
        // Description
        let description = (typeof params.description !== 'undefined')?params.description:'';
        
        // Checked
        var checked = '';  

        // Verify if the value exists
        if (typeof params.value !== 'undefined') {

            // Verify if the checkbox is checked
            checked = parseInt(params.value)?' checked':'';

        }

        // Required option
        var required = '';

        // Verify if required parameter exists
        if ( typeof params.required !== 'undefined' ) {

            // Verify if the option is required
            if ( params.required ) {

                // Mark the option as required
                required = '<span class="default-extra-field-required">'
                    + '*'
                + '</span>';

            }

        }

        // Template
        var html = '<div class="form-group default-extra-field-checkbox-1 d-flex"' + id + '>'
            + '<div class="default-extra-icon">'
                + icon
            + '</div>'
            + '<div class="default-extra-text">'
                + '<h4>'
                    + name
                    + required
                + '</h4>'
                + '<p>'
                    + description
                + '</p>'
            + '</div>'
            + '<div>'
                + '<div class="default-extra-field-checkbox-1-option">'
                    + '<input name="default-extra-field-checkbox-1-' + unique_id + '" type="checkbox" id="default-extra-field-checkbox-1-' + unique_id + '"' + checked + ' />'
                    + '<label for="default-extra-field-checkbox-1-' + unique_id + '"></label>'
                + '</div>'
            + '</div>'                                          
        + '</div>';

        // Return empty
        return html;

    }

});

// Add select template
default_extra_fields.set_option_template({
    template_slug: 'select',
    option_template: function (params) {

        // Unique id
        let unique_id = Math.floor(Math.random() * 1000);

        // ID
        let id = (typeof params.id !== 'undefined')?' data-id="' + params.id + '"':'';

        // Icon
        let icon = (typeof params.icon !== 'undefined')?params.icon:'';

        // Name
        let name = (typeof params.name !== 'undefined')?params.name:'';
        
        // Description
        let description = (typeof params.description !== 'undefined')?params.description:'';
        
        // Dropdown button
        var dropdown_btn = '';

        // Dropdown placeholder
        var dropdown_placeholder = '';

        // Dropdown value
        var dropdown_value = '';   
        
        // Verify if dropdown parameter exists
        if ( typeof params.dropdown !== 'undefined' ) {

            // Verify if button and placeholder exists
            if ( (typeof params.dropdown.button !== 'undefined') && (typeof params.dropdown.placeholder !== 'undefined') && (typeof params.dropdown.value !== 'undefined') ) {

                // Set button text
                dropdown_btn = params.dropdown.button;

                // Set placeholder
                dropdown_placeholder = params.dropdown.placeholder;

                // Set value
                dropdown_value = ' data-id="' + params.dropdown.value + '"';

            }

        }

        // Required option
        var required = '';

        // Verify if required parameter exists
        if ( typeof params.required !== 'undefined' ) {

            // Verify if the option is required
            if ( params.required ) {

                // Mark the option as required
                required = '<span class="default-extra-field-required">'
                    + '*'
                + '</span>';

            }

        }

        // Template
        var html = '<div class="form-group default-extra-field-select-1 d-flex"' + id + '>'
            + '<div class="default-extra-icon">'
                + icon
            + '</div>'
            + '<div class="default-extra-text">'
                + '<div class="row">'
                    + '<div class="col-12">'
                        + '<h4>'
                            + name
                            + required
                        + '</h4>'
                        + '<p>'
                            + description
                        + '</p>'
                    + '</div>'                                          
                + '</div>'
                + '<div class="row">'
                    + '<div class="col-12">'
                        + '<div class="dropdown p-0 theme-dropdown-2 theme-dropdown-icon-1 theme-box-2">'
                            + '<a href="#" role="button" class="btn btn-secondary dropdown-toggle d-flex justify-content-between default-extra-field-select-1-btn" id="default-extra-field-select-1-' + unique_id + '-btn" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"' + dropdown_value + '>'
                                + '<span>'
                                    + dropdown_btn
                                + '</span>'
                                + words.icon_arrow_down
                            + '</a>'
                            + '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="default-extra-field-select-1-' + unique_id + '-btn">'
                                + '<input class="crm-social-search-for-items" type="text" placeholder="' + dropdown_placeholder + '" />'
                                + '<div>'
                                    + '<ul class="list-group default-extra-field-select-1-items">'
                                    + '</ul>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'                                         
                + '</div>'                   
            + '</div>'                                            
        + '</div>';

        // Return empty
        return html;

    }

});

// Add media template
default_extra_fields.set_option_template({
    template_slug: 'media',
    option_template: function (params) {

        // Unique id
        let unique_id = Math.floor(Math.random() * 1000);

        // ID
        let id = (typeof params.id !== 'undefined')?' data-id="' + params.id + '"':'';

        // Label
        let label = (typeof params.label !== 'undefined')?params.label:'';    

        // Placeholder
        let placeholder = (typeof params.placeholder !== 'undefined')?params.placeholder:'';

        // value
        let value = (typeof params.value !== 'undefined')?' value="' + params.value + '"':''; 
        
        // Required option
        var required = '';

        // Verify if required parameter exists
        if ( typeof params.required !== 'undefined' ) {

            // Verify if the option is required
            if ( params.required ) {

                // Mark the option as required
                required = '<span class="default-extra-field-required">'
                    + '*'
                + '</span>';

            }

        }

        // Template
        var html = '<div class="form-group default-extra-field-media-1"' + id + '>'
            + '<div class="d-flex justify-content-between">'
                + '<input type="text" placeholder="' + placeholder + '"' + value + ' class="form-control default-extra-field-media-1-url" id="default-extra-field-media-1-' + unique_id + '" />'
                + '<label for="default-extra-field-media-1-' + unique_id + '">'
                    + label
                    + required
                + '</label>'
                + '<button type="button" class="btn btn-light default-extra-field-media-1-upload-btn">'
                    + words.icon_upload_cloud
                + '</button>'
            + '</div>'
        + '</div>';

        // Return empty
        return html;

    }

});

// Add account template
default_extra_fields.set_option_template({
    template_slug: 'account',
    option_template: function (params) {

        // Icon
        let icon = (typeof params.icon !== 'undefined')?params.icon:'';
        
        // Name
        let name = (typeof params.name !== 'undefined')?params.name:'';
        
        // Info
        let info = (typeof params.info !== 'undefined')?params.info:'';

        // Template
        var html = '<div class="form-group default-extra-field-checkbox-1 d-flex default-extra-field-account">'
            + '<div class="default-extra-icon">'
                + icon
            + '</div>'
            + '<div class="default-extra-text">'
                + '<h4>'
                    + name
                + '</h4>'
                + '<p>'
                    + info
                + '</p>'
            + '</div>'
        + '</div>';

        // Return empty
        return html;

    }

});