<?php
/**
 * General Theme Inc
 *
 * This file contains the general theme's functions
 * used in the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('set_the_seo_title') ) {
    
    /**
     * The function set_the_seo_title sets the page's seo title
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function set_the_seo_title() {

        // Verify if custom website name exists
        if ( md_the_option('crm_frontend_website_name') ) {

            // Get codeigniter object instance
            $CI = &get_instance();

            // Change the website's name
            $CI->config->set_item('site_name', md_the_option('crm_frontend_website_name'));            

        }

        if ( md_the_data('classification_item_name') ) {

            md_set_the_title(md_the_data('classification_item_name'));
            
        } else {

            // Get the seo title
            $meta_value = md_the_single_content_meta('quick_seo_page_title');

            if ($meta_value) {
                md_set_the_title($meta_value);
            } else {
                md_set_the_title(md_the_single_content_meta('content_title'));
            }

        }
        
    }
    
}

// Set the seo title
set_the_seo_title();

if ( !function_exists('set_the_seo_meta_description') ) {
    
    /**
     * The function set_the_seo_meta_description sets the page's seo meta description
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function set_the_seo_meta_description() {

        // Get the seo meta's description
        $meta_value = md_the_single_content_meta('quick_seo_meta_description');

        if ($meta_value) {
            md_set_the_meta_description($meta_value);
        }
        
    }
    
}

// Set the seo meta description
set_the_seo_meta_description();

if ( !function_exists('set_the_seo_meta_keywords') ) {
    
    /**
     * The function set_the_seo_meta_keywords sets the page's seo meta keywords
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function set_the_seo_meta_keywords() {

        // Get the seo meta's keywords
        $meta_value = md_the_single_content_meta('quick_seo_meta_keywords');

        if ($meta_value) {
            md_set_the_meta_keywords($meta_value);
        }
        
    }
    
}

// Set the seo meta keywords
set_the_seo_meta_keywords();

/**
 * The public method md_set_hook registers a hook
 * 
 * @since 0.0.8.5
 */
md_set_hook(
    'the_frontend_header',
    function () {

        // Get header code
        $header = md_the_option('frontend_header_code');

        // Verify if header code exists
        if ( $header ) {

            // Show code
            echo $header;

        }

        echo "<!-- Bootstrap CSS -->\n";
        echo "    <link rel=\"stylesheet\" href=\"//cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css\">\n";

    }
);

/**
 * The public method md_set_hook registers a hook
 * 
 * @since 0.0.8.5
 */
md_set_hook(
    'the_frontend_footer',
    function () {

        // Get footer code
        $footer = md_the_option('frontend_footer_code');

        // Verify if footer code exists
        if ( $footer ) {

            // Show code
            echo $footer;

        }

        echo "<script src=\"//code.jquery.com/jquery-3.5.1.min.js\"></script>\n";
        echo "<script src=\"//cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js\"></script>\n";
        echo "<script src=\"" . base_url("assets/js/main.js?ver=" . MD_VER) . "\"></script>\n";

    }

);

if ( !function_exists('the_featured_interactions') ) {
    
    /**
     * The function the_featured_interactions gets the featured's interactions
     * 
     * @since 0.0.8.5
     * 
     * @return array with contents or boolean false
     */
    function the_featured_interactions() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Where conditions
        $where = array(
            'contents_meta.language' => $CI->config->item('language'),
            'contents_meta.meta_name' => 'featured_image',
            'contents.status' => 1,
            'contents.contents_category' => 'integrations',
            'f.meta_name' => 'featured'
        );

        // Join conditions
        $join = array(
            array(
                'table' => 'contents_meta',
                'condition' => 'contents.content_id=contents_meta.content_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta f',
                'condition' => 'contents.content_id=f.content_id',
                'join_from' => 'LEFT'
            )
        );

        // Get contents
        return md_the_db_request(
            'contents',
            'contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
            $where,
            array(),
            array(),
            $join,
            array(
                'group_by' => array('contents.content_id'),
                'order_by' => array('contents.content_id', 'desc'),
                'start' => 0,
                'limit' => 10
            )

        );
        
    }
    
}

if ( !function_exists('the_featured_features') ) {
    
    /**
     * The function the_featured_features gets the featured's features
     * 
     * @since 0.0.8.5
     * 
     * @return array with contents or boolean false
     */
    function the_featured_features() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Where conditions
        $where = array(
            'contents_meta.language' => $CI->config->item('language'),
            'contents_meta.meta_name' => 'content_title',
            'contents.status' => 1,
            'contents.contents_category' => 'features',
            'f.meta_name' => 'featured'
        );

        // Join conditions
        $join = array(
            array(
                'table' => 'contents_meta',
                'condition' => 'contents.content_id=contents_meta.content_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta f',
                'condition' => 'contents.content_id=f.content_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta short_description',
                'condition' => "contents.content_id=short_description.content_id AND short_description.meta_name='short_description'",
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta icon_class',
                'condition' => "contents.content_id=icon_class.content_id AND icon_class.meta_name='icon_class'",
                'join_from' => 'LEFT'
            )
        );

        // Get contents
        return md_the_db_request(
            'contents',
            'contents_meta.*, short_description.meta_value AS content_description, icon_class.meta_value AS content_icon, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
            $where,
            array(),
            array(),
            $join,
            array(
                'group_by' => array('contents.content_id'),
                'order_by' => array('contents.content_id', 'desc'),
                'start' => 0,
                'limit' => 10
            )

        );
        
    }
    
}

if ( !function_exists('the_similar_posts') ) {
    
    /**
     * The function the_similar_posts gets the similar posts
     * 
     * @param integer $content_id contains the content's ID
     * 
     * @since 0.0.8.5
     * 
     * @return array with posts or boolean false
     */
    function the_similar_posts($content_id) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get the post's categories
        $categories = md_the_db_request(
            'contents_classifications',
            'classification_value',
            array(
                'content_id' => $content_id
            )
        );

        // Verify if the post has categories
        if ( !$categories ) {
            return;
        }

        // Get contents
        return md_the_db_request(
            'contents_classifications',
            'contents.content_id, contents.contents_slug, contents.created, contents_meta.meta_value AS content_title, body.meta_value AS content_body, short_description.meta_value AS content_description, cover.meta_value AS content_cover',
            array(
                'contents_classifications.classification_slug' => 'posts_categories'
            ),
            array(
                'contents_classifications.classification_value', array_column($categories, 'classification_value')
            ),
            array(),
            array(
                array(
                    'table' => 'contents',
                    'condition' => 'contents_classifications.content_id=contents.content_id',
                    'join_from' => 'LEFT'
                ),                
                array(
                    'table' => 'contents_meta',
                    'condition' => "contents_classifications.content_id=contents_meta.content_id AND contents_meta.meta_name='content_title'",
                    'join_from' => 'LEFT'
                ),
                array(
                    'table' => 'contents_meta short_description',
                    'condition' => "contents.content_id=short_description.content_id AND short_description.meta_name='short_description'",
                    'join_from' => 'LEFT'
                ),
                array(
                    'table' => 'contents_meta body',
                    'condition' => "contents_classifications.content_id=body.content_id AND body.meta_name='content_body'",
                    'join_from' => 'LEFT'
                ),
                array(
                    'table' => 'contents_meta cover',
                    'condition' => "contents_classifications.content_id=cover.content_id AND cover.meta_name='cover'",
                    'join_from' => 'LEFT'
                )                
            ),
            array(
                'group_by' => array('contents_meta.content_id'),
                'order_by' => array('contents_meta.content_id', 'desc'),
                'start' => 0,
                'limit' => 3
            )

        );
        
    }
    
}

if ( !function_exists('the_featured_posts') ) {
    
    /**
     * The function the_featured_posts gets the featured's posts
     * 
     * @since 0.0.8.5
     * 
     * @return array with contents or boolean false
     */
    function the_featured_posts() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Where conditions
        $where = array(
            'contents_meta.language' => $CI->config->item('language'),
            'contents_meta.meta_name' => 'content_title',
            'contents.status' => 1,
            'contents.contents_category' => 'posts',
            'f.meta_name' => 'featured'
        );

        // Join conditions
        $join = array(
            array(
                'table' => 'contents_meta',
                'condition' => 'contents.content_id=contents_meta.content_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta f',
                'condition' => 'contents.content_id=f.content_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta short_description',
                'condition' => "contents.content_id=short_description.content_id AND short_description.meta_name='short_description'",
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta body',
                'condition' => "contents.content_id=body.content_id AND body.meta_name='content_body'",
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'contents_meta cover',
                'condition' => "contents.content_id=cover.content_id AND cover.meta_name='cover'",
                'join_from' => 'LEFT'
            )
        );

        // Get contents
        return md_the_db_request(
            'contents',
            'contents_meta.*, short_description.meta_value AS content_description, body.meta_value AS content_body, cover.meta_value AS content_cover, contents.created, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
            $where,
            array(),
            array(),
            $join,
            array(
                'group_by' => array('contents.content_id'),
                'order_by' => array('contents.content_id', 'desc'),
                'start' => 0,
                'limit' => 3
            )

        );
        
    }
    
}

if ( !function_exists('the_all_featured_plans') ) {
    
    /**
     * The function the_all_featured_plans returns all featured plans if exists
     * 
     * @since 0.0.8.5
     * 
     * @return array with plans or boolean false
     */
    function the_all_featured_plans() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Load the Crm Theme Model
        $CI->load->ext_model( md_the_theme_path() . 'models/', 'Crm_theme_model', 'crm_theme_model' );

        // Get the featured plans
        return $CI->crm_theme_model->the_featured_plans();
        
    }
    
}

if ( !function_exists('the_all_visible_plans') ) {
    
    /**
     * The function the_all_visible_plans returns all visible plans if exists
     * 
     * @since 0.0.8.5
     * 
     * @return array with plans or boolean false
     */
    function the_all_visible_plans() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Load the Crm Theme Model
        $CI->load->ext_model( md_the_theme_path() . 'models/', 'Crm_theme_model', 'crm_theme_model' );

        // Get the public plans
        return $CI->crm_theme_model->the_public_plans();
        
    }
    
}

if ( !function_exists('the_all_visible_plans_texts') ) {
    
    /**
     * The function the_all_visible_plans_texts gets the texts for all plans
     * 
     * @since 0.0.8.5
     * 
     * @return array with texts or boolean false
     */
    function the_all_visible_plans_texts() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get the public plans
        return $CI->config->item('language');
        
    }
    
}

if ( !function_exists('the_crm_website_logo') ) {
    
    /**
     * The function the_crm_website_logo gets the website logo
     * 
     * @since 0.0.8.5
     * 
     * @return string with logo
     */
    function the_crm_website_logo() {

        // Default website's logo
        $website_logo = '';

        // Verify if the website's logo exists
        if ( md_the_option('frontend_theme_logo') ) {

            // Get the media
            $the_media = get_instance()->base_model->the_data_where('medias', '*', array('media_id' => md_the_option('frontend_theme_logo')));

            // Verify if media's exists
            if ( $the_media ) {

                // Set media
                $website_logo = '<img src="' . $the_media[0]['body'] . '" class="logo">';

            }

        }

        return $website_logo;
        
    }
    
}

if ( !function_exists('the_last_articles') ) {
    
    /**
     * The function the_last_articles gets the last articles
     * 
     * @since 0.0.8.5
     * 
     * @return array with contents or boolean false
     */
    function the_last_articles() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get contents
        return md_the_db_request(
            'contents',
            'contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
            array(
                'contents_meta.language' => $CI->config->item('language'),
                'contents_meta.meta_name' => 'content_title',
                'contents.status' => 1,
                'contents.contents_category' => 'support_articles'
            ),
            array(),
            array(),
            array(
                array(
                    'table' => 'contents_meta',
                    'condition' => 'contents.content_id=contents_meta.content_id',
                    'join_from' => 'LEFT'
                )              
            ),
            array(
                'order_by' => array('contents.content_id', 'desc'),
                'start' => 0,
                'limit' => 10
            )
            
        );
        
    }
    
}

/* End of file general.php */