<?php
/**
 * Admin Pages Functions
 *
 * PHP Version 7.3
 *
 * This files contains the admin's pages
 * methods used in admin -> admin
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Register the hooks for administrator
md_set_hook(
    'change_transaction_status',
    function ($args) {

        // Get the transaction's ID
        $transaction_id = $args['transaction_id'];

        // Use the base model for a simply sql query
        $get_transaction = get_instance()->base_model->the_data_where('transactions', '*', array('transaction_id' => $transaction_id));

        // Verify if transaction exists
        if ( $get_transaction ) {

            // Verify if status is 1
            if ( (int)$get_transaction[0]['status'] === 1 ) {

                // Get plan_id if exists
                $get_plan = get_instance()->base_model->the_data_where('transactions_options', '*', array('transaction_id' => $transaction_id,'option_name' => 'plan_id'));

                // Verify if plan exists
                if ( $get_plan ) {

                    // Change the plan
                    $this->CI->plans->change_plan($get_plan[0]['option_value'], $get_transaction[0]['user_id']);

                }

            }

        }

    }

);   

/* End of file admin_hooks.php */