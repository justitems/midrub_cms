<?php
/**
 * Menu Helper
 *
 * This file contains the class Menu
 * with methods to manage the theme's menu
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Helpers;

// Constants
defined('BASEPATH') or exit('No direct script access allowed');

// Require the Read Menu Inc file
require_once APPPATH . 'base/inc/menu/read_menu.php';

/*
 * Menu class provides the methods to manage the theme's menu
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Menu
{

    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct()
    {

        // Get codeigniter object instance
        $this->CI = &get_instance();

        // Load Base Model
        $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_model', 'base_model');

        // Load Base Classification Model
        $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_classifications', 'base_classifications');
    }

    /**
     * The public method new_menu_item provides parameters for menu's item
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function new_menu_item()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('menu', 'Menu', 'trim');

            // Get received data
            $menu = $this->CI->input->post('menu');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                $all_languages = array();

                // Get all languages
                $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                // List all languages
                foreach ($languages as $language) {

                    // Get language dir name
                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                    // Add language to the dir
                    $all_languages[] = $only_dir;

                }

                // All Items
                $all_items = array();

                // Prepare menu's args
                $menu_args = array(
                    'slug' => $menu,
                    'fields' => array(
                        'selected_page',
                        'permalink',
                        'class'
                    ),
                    'language' => TRUE
                );

                // Get classifications
                $classifications = $this->CI->base_classifications->get_menu_items($menu_args);

                // Verify if classifications exists
                if ( $classifications ) {

                    // Set Items
                    $all_items = $classifications;

                }

                // Verify if languages exists
                if ($all_languages) {

                    $data = array(
                        'success' => TRUE,
                        'languages' => $all_languages,
                        'all_items' => $all_items,
                        'words' => array(
                            'item_name' => $this->CI->lang->line('frontend_item_name'),
                            'enter_item_name' => $this->CI->lang->line('frontend_enter_item_name'),
                            'enter_item_name_description' => $this->CI->lang->line('frontend_item_name_selected_language'),
                            'item_permalink' => $this->CI->lang->line('frontend_item_permalink'),
                            'select_page' => $this->CI->lang->line('frontend_settings_select_page'),
                            'search_page' => $this->CI->lang->line('frontend_settings_search_page'),
                            'item_enter_url' => $this->CI->lang->line('frontend_item_enter_url'),
                            'show_advanced_options' => $this->CI->lang->line('frontend_item_show_advanced_options'),
                            'item_description' => $this->CI->lang->line('frontend_item_description'),
                            'enter_item_description' => $this->CI->lang->line('frontend_enter_item_description'),
                            'item_description_info' => $this->CI->lang->line('frontend_item_description_info'),
                            'item_class' => $this->CI->lang->line('frontend_item_class'),
                            'enter_item_class' => $this->CI->lang->line('frontend_enter_item_class'),
                            'item_class_description' => $this->CI->lang->line('frontend_item_class_description'),
                            'select_menu_item' => $this->CI->lang->line('frontend_select_menu_item'),
                            'delete' => $this->CI->lang->line('frontend_delete')
                        )
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_no_languages_found')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method frontend_save_menu_items saves menu's items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_save_menu_items() {

        // Count success saving data
        $count = 0;

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('menu', 'Menu', 'trim|required');
            $this->CI->form_validation->set_rules('all_items', 'All Items', 'trim');

            // Get received data
            $menu = $this->CI->input->post('menu');
            $all_items = $this->CI->input->post('all_items');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Get classifications by menu slug
                $classifications = $this->CI->base_model->the_data_where('classifications', 'classification_id', array(
                    'classification_slug' => $menu,
                    'classification_type' => 'menu'
                ));

                // Verify if all item's has a name
                if ($all_items) {

                    // Get items
                    $items = array_values($all_items);

                    if (isset($items[0])) {

                        // List all menu items
                        foreach ($items as $item) {

                            // Get item languages
                            $item_languages = array_values($item);

                            // List items by language
                            foreach ($item_languages[1] as $item_language) {

                                // Get language
                                $language = array_keys($item_language);

                                // List all item's fields
                                foreach ($item_language[$language[0]] as $key => $value) {

                                    // Verify if key is name
                                    if ($key === 'name') {

                                        // Verify if value is not valid
                                        if (!$value) {

                                            $data = array(
                                                'success' => FALSE,
                                                'message' => $this->CI->lang->line('frontend_please_add_a_name_for_all_items')
                                            );

                                            echo json_encode($data);
                                            exit();
                                        }

                                    }

                                }

                            }

                        }

                    }

                }

                if ($classifications) {

                    foreach ($classifications as $classification) {

                        // Delete old menu's items
                        $this->CI->base_model->delete('classifications', array(
                            'classification_id' => $classification['classification_id']
                        ));

                        $this->CI->base_model->delete('classifications_meta', array(
                            'classification_id' => $classification['classification_id']
                        ));

                    }

                }

                if ($all_items) {

                    // Get items
                    $items = array_values($all_items);

                    // Last classification id
                    $last_classification_id = 0;

                    // Last parent order
                    $last_parent_order = 0;                    

                    // Last parent value
                    $last_parent_value = 0;

                    // Genealogy
                    $genealogy = array();

                    if (isset($items[0])) {

                        // List all menu items
                        foreach ($items as $item) {

                            // Get item languages
                            $item_languages = array_values($item);

                            if (isset($item_languages[1])) {

                                // Prepare data to save
                                $params = array(
                                    'classification_slug' => $menu,
                                    'classification_type' => 'menu'
                                );

                                // Save menu's item
                                $classification_id = $this->CI->base_model->insert('classifications', $params);

                                // Verify if genealogy is empty
                                if ( !$genealogy ) {

                                    $genealogy[] = $classification_id;

                                }

                                // Verify if the item was saved
                                if ($classification_id) {

                                    $count++;

                                    // List items by language
                                    foreach ($item_languages[1] as $item_language) {

                                        // Get language
                                        $language = array_keys($item_language);

                                        // Genealogy checker
                                        $genealogy_count = 0;

                                        // List all item's fields
                                        foreach ($item_language[$language[0]] as $key => $value) {

                                            // Prepare data to save
                                            $params = array(
                                                'classification_id' => $classification_id,
                                                'meta_slug' => $key,
                                                'meta_name' => $key,
                                                'meta_value' => $value,
                                                'language' => $language[0]
                                            );

                                            // Verify if key is selected_page
                                            if ($key === 'selected_page') {

                                                // Verify if value isn't empty
                                                if (is_numeric($value)) {

                                                    // Get slug
                                                    $url_slug = $this->CI->base_model->the_data_where('contents', 'contents_slug', array(
                                                        'content_id' => $value
                                                    ));

                                                    if ($url_slug) {
                                                        $params['meta_value'] = $url_slug[0]['contents_slug'];
                                                        $params['meta_extra'] = $value;
                                                    }

                                                } else {

                                                    $params['meta_value'] = '';
                                                    $params['meta_extra'] = '';

                                                }

                                            } else if ($key === 'parent') {

                                                if (is_numeric($value)) {

                                                    $genealogy_count++;

                                                    if ( $last_parent_value !== $value ) {

                                                        $last_parent_value = $value;

                                                        $last_parent_order =  $last_classification_id;

                                                    } else {

                                                        $last_classification_id = $last_parent_order;

                                                    }

                                                    $genealogy[$value] = $classification_id;

                                                    $last_classification_id = $genealogy[($value - 1)];

                                                    $this->CI->base_model->update_ceil('classifications', array('classification_id' => $classification_id), array('classification_parent' => $last_classification_id));
                                                    continue;

                                                }

                                            }

                                            // Save field
                                            $this->CI->base_model->insert('classifications_meta', $params);

                                        }

                                        if ( $genealogy_count < 1 ) {

                                            // Genealogy
                                            $genealogy = array();

                                            $genealogy[] = $classification_id;

                                        }

                                        $genealogy_count = 0;

                                    }

                                    // Set last classification id
                                    $last_classification_id = $classification_id;

                                }

                            }

                        }

                    }
                    
                } else {

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('frontend_settings_changes_were_saved')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Verify if content was saved
        if ($count) {

            $data = array(
                'success' => TRUE,
                'message' => $this->CI->lang->line('frontend_menu_items_were_saved')
            );

            echo json_encode($data);

        } else {

            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('frontend_menu_items_were_not_saved')
            );

            echo json_encode($data);

        }
        
    }

    /**
     * The public method frontend_get_menu_items gets menu's items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_get_menu_items() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('menu', 'Menu', 'trim|required');

            // Get received data
            $menu = $this->CI->input->post('menu');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Menu's items
                $items = array();

                // Get classifications by menu slug
                $classifications_list = $this->CI->base_model->the_data_where('classifications', 'classification_id, classification_parent', array(
                    'classification_slug' => $menu,
                    'classification_type' => 'menu'
                ));

                // Verify if menu has items
                if ($classifications_list) {

                    // List all items
                    foreach ( $classifications_list as $classification ) {

                        // Get item's details
                        $classifications_meta = $this->CI->base_model->the_data_where('classifications_meta', '*', array(
                            'classification_id' => $classification['classification_id']
                        ));   
                        
                        // Verify if item details exists
                        if ( $classifications_meta ) {

                            foreach ( $classifications_meta as $classification_meta ) {

                                $items[] = $classification_meta;

                            }

                        }

                    }

                }

                // Verify if classifications exists
                if ( $items ) {

                    $all_languages = array();

                    // Get all languages
                    $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                    // List all languages
                    foreach ($languages as $language) {

                        // Get language dir name
                        $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                        // Add language to the dir
                        $all_languages[] = $only_dir;
                    }

                    // Verify if languages exists
                    if ($all_languages) {

                        $data = array(
                            'success' => TRUE,
                            'classifications' => $classifications_list,
                            'items' => $items,
                            'languages' => $all_languages,
                            'words' => array(
                                'item_name' => $this->CI->lang->line('frontend_item_name'),
                                'enter_item_name' => $this->CI->lang->line('frontend_enter_item_name'),
                                'enter_item_name_description' => $this->CI->lang->line('frontend_item_name_selected_language'),
                                'item_permalink' => $this->CI->lang->line('frontend_item_permalink'),
                                'select_page' => $this->CI->lang->line('frontend_settings_select_page'),
                                'search_page' => $this->CI->lang->line('frontend_settings_search_page'),
                                'item_enter_url' => $this->CI->lang->line('frontend_item_enter_url'),
                                'show_advanced_options' => $this->CI->lang->line('frontend_item_show_advanced_options'),
                                'item_description' => $this->CI->lang->line('frontend_item_description'),
                                'enter_item_description' => $this->CI->lang->line('frontend_enter_item_description'),
                                'item_description_info' => $this->CI->lang->line('frontend_item_description_info'),
                                'item_class' => $this->CI->lang->line('frontend_item_class'),
                                'enter_item_class' => $this->CI->lang->line('frontend_enter_item_class'),
                                'item_class_description' => $this->CI->lang->line('frontend_item_class_description'),
                                'delete' => $this->CI->lang->line('frontend_delete')
                            )
                        );

                        echo json_encode($data);
                        exit();

                    }

                }

            }

        }

        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_no_menu_items_found')
        );

        echo json_encode($data);
    }
    
    /**
     * The public method load_selected_pages loads the list with selected pages
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function load_selected_pages() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('page_ids', 'Page Ids', 'trim');

            // Get received data
            $page_ids = $this->CI->input->post('page_ids');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Verify if page ids exists
                if ($page_ids) {

                    // All contents
                    $contents = array();

                    // List all ids
                    foreach ($page_ids as $page_id) {

                        if (is_numeric($page_id)) {

                            // Get content
                            $content = $this->CI->base_contents->the_content($page_id);

                            if ($content) {

                                // Default title
                                $title = '';

                                foreach ( $content as $meta ) {

                                    if ( $meta['meta_name'] === 'content_title' ) {

                                        $title = $meta['meta_value'];

                                    }

                                }

                                $contents[] = array(
                                    'content_id' => $page_id,
                                    'title' => $title
                                );

                            }

                        }

                    }

                    if ($contents) {

                        $data = array(
                            'success' => TRUE,
                            'contents' => $contents
                        );

                        echo json_encode($data);
                    }
                    
                }

            }

        }

    }

}

/* End of file menu.php */
