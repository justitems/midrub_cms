<?php
/**
 * General Parts Options Inc
 *
 * This file contains the functions
 * which are making lighter the parent files
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('md_the_user_option_from_parts')) {
    
    /**
     * The function md_the_user_option_from_parts gets the user's options
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * 
     * @return object or string with meta's value
     */
    function md_the_user_option_from_parts($user_id, $meta_name) {

        $CI = get_instance();

        $CI->all_user_options = !empty($CI->all_user_options)?$CI->all_user_options:array();

        if ( !empty($CI->all_user_options[$user_id]) ) {

            if ( isset($CI->all_user_options[$user_id][$meta_name]) ) {
                
                return $CI->all_user_options[$user_id][$meta_name];
                
            } else {
                
                return false;
                
            }
            
        } else {

            $the_options = $CI->base_model->the_data_where('users_meta', '*', array('user_id' => $user_id));

            $the_user_data = $CI->base_model->the_data_where('users', '*', array('user_id' => $user_id));

            $CI->all_user_options[$user_id] = $the_user_data?$the_user_data[0]:array();

            $CI->all_user_options[$user_id] = $the_options?array_merge($CI->all_user_options[$user_id], array_column($the_options, 'meta_value', 'meta_name')):array_merge($CI->all_user_options[$user_id], array());

            if ( isset($CI->all_user_options[$user_id][$meta_name]) ) {

                return $CI->all_user_options[$user_id][$meta_name];

            } else {
                
                return false;
                
            }
        
        }

    }

}

if ( !function_exists( 'md_delete_user_option_from_parts' ) ) {
    
    /**
     * The function md_delete_user_option_from_parts deletes a user's option
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * 
     * @return boolean true or false
     */
    function md_delete_user_option_from_parts($user_id, $meta_name) {
        
        if ( empty($meta_name) ) {
            return false;
        }

        $CI = get_instance();

        if ( $CI->base_model->delete('users_meta', array('meta_name' => trim($meta_name))) ) {
            return true;
        } else {
            return false;
        }
        
    }

}

if (!function_exists('md_the_plan_feature_from_parts')) {
    
    /**
     * The function md_the_plan_feature_from_parts gets plan's feature
     * 
     * @param string $features contains the feature's name
     * @param integer $plan_id contains optionally the plan's id
     * @param integer $user_id contains optionally the user's id
     * 
     * @return string with feature's value or boolean false
     */
    function md_the_plan_feature_from_parts($feature, $plan_id = 0, $user_id = 0) {
        
        $CI = get_instance();

        if ( $user_id ) {
            
            if ( (strtotime(md_the_user_option($user_id, 'plan_end')) + 86400) < time() ) {
                return false;
            }         

        }

        if ( !$plan_id ) {

            if ( !empty($CI->user_id) ) {

                $plan_id = md_the_user_option($CI->user_id, 'plan');

            }

        }    

        $plan_features = md_the_cache('md_plan_features_' . $plan_id);

        if ( !empty($plan_features) ) {

            if ( isset($plan_features[$feature]) ) {
                
                return $plan_features[$feature];
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            // Get the plan's metas
            $plan_metas = $CI->base_model->the_data_where(
                'plans_meta',
                'plans_meta.*, plans.plan_name, plans.plan_price, plans.currency_sign, plans.currency_code, plans.period, plans.hidden, plans.popular, plans.featured, plans.trial',
                array(
                    'plans_meta.plan_id' => $plan_id
                ),
                array(),
                array(),
                array(array(
                    'table' => 'plans',
                    'condition' => 'plans_meta.plan_id=plans.plan_id',
                    'join_from' => 'LEFT'
                ))

            );

            if ( !empty($plan_metas) ) {

                $CI->plan_features = array(
                    'plan_name' => $plan_metas[0]['plan_name'],
                    'plan_price' => $plan_metas[0]['plan_price'],
                    'currency_sign' => $plan_metas[0]['currency_sign'],
                    'currency_code' => $plan_metas[0]['currency_code'],
                    'period' => $plan_metas[0]['period'],
                    'hidden' => $plan_metas[0]['hidden'],
                    'popular' => $plan_metas[0]['popular'],
                    'featured' => $plan_metas[0]['featured'],
                    'trial' => $plan_metas[0]['trial']
                );

                foreach ( array_column($plan_metas, 'meta_value', 'meta_name') as $name => $value ) {

                    $CI->plan_features[$name] = $value;

                }

                md_create_cache('md_plan_features_' . $plan_id, $CI->plan_features);

            }

            if ( isset($CI->plan_features[$feature]) ) {

                return $CI->plan_features[$feature];

            } else {
                
                return false;
                
            }
        
        }
        
    }

}

/* End of file general.php */