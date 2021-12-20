<?php
/**
 * Crm Theme Model
 *
 * PHP Version 7.4
 *
 * crm_theme_model file contains the Crm Theme Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://elements.envato.com/license-terms
 * @link     https://www.midrub.com/
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Crm_theme_model class - operates the plans_groups table.
 *
 * @since 0.0.8.5
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://elements.envato.com/license-terms
 * @link     https://www.midrub.com/
 */
class Crm_theme_model extends CI_MODEL {

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
    }

    /**
     * The public method the_features_list gets the features list by categories
     * 
     * @param array $categories_ids contains the categories ids
     * 
     * @return array with data or boolean false
     */
    public function the_features_list($categories_ids) {

        // Set language
        $language = $this->config->item('language');

        // Prepare where
        $where = array(
            'contents_meta.language' => $language,
            'contents_meta.meta_name' => 'content_title'
        );

        // Select tables
        $this->db->select('contents_meta.meta_value AS content_title, short_description.meta_value AS content_description, icon_class.meta_value AS content_icon, contents_meta.language, contents.content_id, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status');
        
        // Set database
        $this->db->from('contents');

        // Set join
        $this->db->join('contents_classifications', 'contents.content_id=contents_classifications.content_id', 'left');
        $this->db->join('classifications_meta', 'contents_classifications.classification_value=classifications_meta.classification_id', 'left');
        $this->db->join('contents_meta', 'contents.content_id=contents_meta.content_id', 'left');
        $this->db->join('contents_meta short_description', "contents.content_id=short_description.content_id AND short_description.meta_name='short_description'", 'left');
        $this->db->join('contents_meta icon_class', "contents.content_id=icon_class.content_id AND icon_class.meta_name='icon_class'", 'left');

        // Set where
        $this->db->where($where);

        // Set where in
        $this->db->where_in('classifications_meta.meta_slug', $categories_ids);

        // Group content
        $this->db->group_by('contents.content_id');

        // Get data
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method the_careers_list gets the careers list by categories
     * 
     * @param array $categories_ids contains the categories ids
     * 
     * @return array with data or boolean false
     */
    public function the_careers_list($categories_ids) {

        // Set language
        $language = $this->config->item('language');

        // Prepare where
        $where = array(
            'contents_meta.language' => $language,
            'contents_meta.meta_name' => 'content_title'
        );

        // Select tables
        $this->db->select('contents_meta.meta_value AS content_title, career_location.meta_value AS location, contents_meta.language, contents.content_id, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status');
        
        // Set database
        $this->db->from('contents');

        // Set join
        $this->db->join('contents_classifications', 'contents.content_id=contents_classifications.content_id', 'left');
        $this->db->join('classifications_meta', 'contents_classifications.classification_value=classifications_meta.classification_id', 'left');
        $this->db->join('contents_meta', 'contents.content_id=contents_meta.content_id', 'left');
        $this->db->join('contents_meta career_location', "contents.content_id=career_location.content_id AND career_location.meta_name='career_location'", 'left');

        // Set where
        $this->db->where($where);

        // Set where in
        $this->db->where_in('classifications_meta.meta_slug', $categories_ids);

        // Group content
        $this->db->group_by('contents.content_id');

        // Get data
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method the_featured_plans gets plans which are featured
     * 
     * @return array with data or boolean false
     */
    public function the_featured_plans() {

        // Get selected groups plans
        $get_groups = $this->base_model->the_data_where(
            'plans_meta',
            'plan_id',
            array(
                'meta_name' => 'plans_group'
            )
        );

        // Ids array
        $ids = array();
        
        // Verify if selected groups plans exists
        if ( $get_groups ) {

            // List all groups
            foreach ( $get_groups as $get_group ) {

                // Set id
                $ids[] = $get_group['plan_id'];

            }

        }

        // If ids is not empty
        if ( $ids ) {

            // Select columns
            $this->db->select('plans.*, plans_meta.meta_value AS plans_group, plans_groups.group_name');

            // From plans table
            $this->db->from('plans');

            // Set where
            $this->db->where(array(
                'plans.hidden' => 0,
                'plans.featured >' => 0,
                'plans_meta.meta_name' => 'plans_group'
            ));            

            // Set where in
            $this->db->where_in('plans.plan_id', $ids);

            // Set join
            $this->db->join('plans_meta', 'plans.plan_id=plans_meta.plan_id', 'LEFT');
            $this->db->join('plans_groups', 'plans_meta.meta_value=plans_groups.group_id', 'LEFT');

            // Set order
            $this->db->order_by('plans_groups.group_id', 'ASC');

        } else {

            // Select columns
            $this->db->select('plans.*');

            // From plans table
            $this->db->from('plans');

            // Set where
            $this->db->where(array(
                'plans.hidden' => 0,
                'plans.featured >' => 0
            ));

            // Set order
            $this->db->order_by('plans.plan_id', 'ASC');

        }
        
        // Get data
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {

            // If ids is not empty
            if ( $ids ) {

                // Get response
                $response = $query->result_array();

                // Get the texts
                $the_texts = $this->base_model->the_data_where(
                    'plans_texts',
                    '*',
                    array(),
                    array(
                        'plan_id', array_column($query->result_array(), 'plan_id')
                    )
                );
                
                // Verify if texts exists
                if ( $the_texts ) {

                    // Group the texts
                    $texts = array_reduce($the_texts, function($accumulator, $plan) {

                        // Verify if plan's key exists
                        if ( !isset($accumulator[$plan['plan_id']]) ) {
                            $accumulator[$plan['plan_id']] = array();
                        }
                        
                        // Set plan
                        $accumulator[$plan['plan_id']][] = $plan;

                        return $accumulator;

                    }, []);

                    // Verify if texts exists
                    if ( $texts ) {

                        // Set texts to response
                        $response['texts'] = $texts;

                    }

                }

                // Groups array
                $groups = array();

                // List all plans
                foreach ( $response as $plan ) {

                    // Verify if plan's group id exists
                    if ( !isset($plan['plans_group']) ) {
                        continue;
                    }

                    // Verify if group already exists
                    if ( !isset($groups[$plan['plans_group']]) ) {
                        $groups[$plan['plans_group']] = array(
                            'group_id' => $plan['plans_group'],
                            'group_name' => $plan['group_name'],
                            'plans' => array()
                        );
                    }

                    // Verify if plan's text exists
                    if ( !empty($texts[$plan['plan_id']]) ) {

                        // Set plan's texts
                        $plan['texts'] = $texts[$plan['plan_id']];

                    }                    

                    // Set plan
                    $groups[$plan['plans_group']]['plans'][] = $plan;

                }

                // Return groups
                return array_values($groups);

            } else {

                // Set response
                $response = array(
                    'data' => $query->result_array()
                );

                // Get the texts
                $the_texts = $this->base_model->the_data_where(
                    'plans_texts',
                    '*',
                    array(),
                    array(
                        'plan_id', array_column($query->result_array(), 'plan_id')
                    )
                );
                
                // Verify if texts exists
                if ( $the_texts ) {

                    // Group the texts
                    $texts = array_reduce($the_texts, function($accumulator, $plan) {

                        // Verify if plan's key exists
                        if ( !isset($accumulator[$plan['plan_id']]) ) {
                            $accumulator[$plan['plan_id']] = array();
                        }
                        
                        // Set plan
                        $accumulator[$plan['plan_id']][] = $plan;

                        return $accumulator;

                    }, []);

                    // Verify if texts exists
                    if ( $texts ) {

                        // Set texts to response
                        $response['texts'] = $texts;

                    }

                }

                // Return data
                return $response;

            }

            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method the_public_plans gets plans which are public
     * 
     * @return array with data or boolean false
     */
    public function the_public_plans() {

        // Get selected groups plans
        $get_groups = $this->base_model->the_data_where(
            'plans_meta',
            'plan_id',
            array(
                'meta_name' => 'plans_group'
            )
        );

        // Ids array
        $ids = array();
        
        // Verify if selected groups plans exists
        if ( $get_groups ) {

            // List all groups
            foreach ( $get_groups as $get_group ) {

                // Set id
                $ids[] = $get_group['plan_id'];

            }

        }

        // If ids is not empty
        if ( $ids ) {

            // Select columns
            $this->db->select('plans.*, plans_meta.meta_value AS plans_group, plans_groups.group_name');

            // From plans table
            $this->db->from('plans');

            // Set where
            $this->db->where(array(
                'plans.hidden' => 0,
                'plans_meta.meta_name' => 'plans_group'
            ));            

            // Set where in
            $this->db->where_in('plans.plan_id', $ids);

            // Set join
            $this->db->join('plans_meta', 'plans.plan_id=plans_meta.plan_id', 'LEFT');
            $this->db->join('plans_groups', 'plans_meta.meta_value=plans_groups.group_id', 'LEFT');

            // Set order
            $this->db->order_by('plans_groups.group_id', 'ASC');

        } else {

            // Select columns
            $this->db->select('plans.*');

            // From plans table
            $this->db->from('plans');

            // Set where
            $this->db->where('plans.hidden', 0);

            // Set order
            $this->db->order_by('plans.plan_id', 'ASC');

        }
        
        // Get data
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {

            // If ids is not empty
            if ( $ids ) {

                // Get response
                $response = $query->result_array();

                // Get the texts
                $the_texts = $this->base_model->the_data_where(
                    'plans_texts',
                    '*',
                    array(),
                    array(
                        'plan_id', array_column($query->result_array(), 'plan_id')
                    )
                );
                
                // Verify if texts exists
                if ( $the_texts ) {

                    // Group the texts
                    $texts = array_reduce($the_texts, function($accumulator, $plan) {

                        // Verify if plan's key exists
                        if ( !isset($accumulator[$plan['plan_id']]) ) {
                            $accumulator[$plan['plan_id']] = array();
                        }
                        
                        // Set plan
                        $accumulator[$plan['plan_id']][] = $plan;

                        return $accumulator;

                    }, []);

                    // Verify if texts exists
                    if ( $texts ) {

                        // Set texts to response
                        $response['texts'] = $texts;

                    }

                }

                // Groups array
                $groups = array();

                // List all plans
                foreach ( $response as $plan ) {

                    // Verify if plan's group id exists
                    if ( !isset($plan['plans_group']) ) {
                        continue;
                    }

                    // Verify if group already exists
                    if ( !isset($groups[$plan['plans_group']]) ) {
                        $groups[$plan['plans_group']] = array(
                            'group_id' => $plan['plans_group'],
                            'group_name' => $plan['group_name'],
                            'plans' => array()
                        );
                    }

                    // Verify if plan's text exists
                    if ( !empty($texts[$plan['plan_id']]) ) {

                        // Set plan's texts
                        $plan['texts'] = $texts[$plan['plan_id']];

                    }                    

                    // Set plan
                    $groups[$plan['plans_group']]['plans'][] = $plan;

                }

                // Return groups
                return array_values($groups);

            } else {

                // Set response
                $response = array(
                    'data' => $query->result_array()
                );

                // Get the texts
                $the_texts = $this->base_model->the_data_where(
                    'plans_texts',
                    '*',
                    array(),
                    array(
                        'plan_id', array_column($query->result_array(), 'plan_id')
                    )
                );
                
                // Verify if texts exists
                if ( $the_texts ) {

                    // Group the texts
                    $texts = array_reduce($the_texts, function($accumulator, $plan) {

                        // Verify if plan's key exists
                        if ( !isset($accumulator[$plan['plan_id']]) ) {
                            $accumulator[$plan['plan_id']] = array();
                        }
                        
                        // Set plan
                        $accumulator[$plan['plan_id']][] = $plan;

                        return $accumulator;

                    }, []);

                    // Verify if texts exists
                    if ( $texts ) {

                        // Set texts to response
                        $response['texts'] = $texts;

                    }

                }

                // Return data
                return $response;

            }

            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file crm_theme_model.php */