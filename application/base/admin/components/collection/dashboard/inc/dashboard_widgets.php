<?php
/**
 * Default Widgets for Administrator
 *
 * PHP Version 7.4
 *
 * This files contains the Dashboard Widgets Inc file
 * with methods to register the administrator's widgets
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Dashboard\Classes as CmsBaseAdminComponentsCollectionDashboardClasses;

// Get codeigniter object instance
$CI = &get_instance();
        
// Load the component's language files
$CI->lang->load( 'dashboard', $CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_DASHBOARD );

/**
 * The public md_set_admin_dashboard_widget registers the widgets
 * 
 * @since 0.0.8.5
 */
md_set_admin_dashboard_widget(
    'joined_members',
    array(
        'widget_name' => $CI->lang->line('dashboard_joined_members'),
        'widget_description' => $CI->lang->line('dashboard_joined_members_description'),
        'widget_icon' => md_the_admin_icon(array('icon' => 'members_small')),
        'widget_data' => 'the_admin_members_widgets_dashboard',
        'widget_default_enabled' => 1,
        'css_urls' => array(),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/dashboard/js/members.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION))
        ),            
        'widget_position' => md_the_admin_dashboard_widget_position('joined_members')?md_the_admin_dashboard_widget_position('joined_members'):1
    )
);

if ( !function_exists('the_admin_members_widgets_dashboard') ) {
    
    /**
     * The function the_admin_members_widgets_dashboard gets members widget content
     * 
     * @return string with response
     */
    function the_admin_members_widgets_dashboard() {

        // Display members
        echo '<div id="dashboard-widget-chart"></div>';

    }

}

/**
 * The public md_set_admin_dashboard_widget registers the widgets
 * 
 * @since 0.0.8.5
 */
md_set_admin_dashboard_widget(
    'last_transactions',
    array(
        'widget_name' => $CI->lang->line('dashboard_transactions'),
        'widget_description' => $CI->lang->line('dashboard_transactions_description'),
        'widget_icon' => md_the_admin_icon(array('icon' => 'transactions')),
        'widget_data' => 'the_admin_last_transactions_widgets_dashboard',
        'widget_default_enabled' => 1,
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/dashboard/styles/css/transactions.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(),            
        'widget_position' => md_the_admin_dashboard_widget_position('last_transactions')?md_the_admin_dashboard_widget_position('last_transactions'):2
    )
);

if ( !function_exists('the_admin_last_transactions_widgets_dashboard') ) {
    
    /**
     * The function the_admin_last_transactions_widgets_dashboard gets last transactions widget content
     * 
     * @return string with response
     */
    function the_admin_last_transactions_widgets_dashboard() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Use the base model to get the transactions
        $transactions = $CI->base_model->the_data_where(
            'transactions',
            'transactions.transaction_id, transactions.amount, transactions.currency, users.user_id, users.first_name, users.last_name, users.username, users.email',
            array(),
            array(),
            array(),
            array(array(
                'table' => 'users',
                'condition' => 'transactions.user_id=users.user_id',
                'join_from' => 'LEFT'
            )),
            array(
                'order_by' => array(
                    'transactions.transaction_id',
                    'DESC'
                ),
                'limit' => 5
            )
        );

        // Display start of the list
        echo '<ul class="dashboard-widget-transactions-list theme-card-box-list">';

        // Verify if transactions exists
        if ( $transactions ) {

            // User date
            $user_date = md_the_date_format($CI->user_id);

            // Set wanted date format
            $date_format = str_replace(array('dd', 'mm', 'yyyy'), array('d', 'm', 'Y'), $user_date);

            // List the transactions
            foreach ( $transactions as $transaction ) {

                // Format the time
                $time_format = (($transaction['created'] + 86400) < time())?date($date_format, $transaction['created']):md_the_calculate_time($CI->user_id, $transaction['created']);

                ?>
                <li class="dashboard-widget-transactions-transaction-single dashboard-widget-transactions-transaction-complete d-flex justify-content-between align-items-center" data-id="15">
                    <a href="<?php echo site_url('admin/admin?p=transactions&transaction=' . $transaction['transaction_id']) ?>">
                        #<?php echo $transaction['transaction_id']; ?>
                    </a>
                    <span class="dashboard-widget-transactions-transaction-time">
                        <?php echo md_the_admin_icon(array('icon' => 'clock')); ?>
                        <?php echo $time_format; ?>
                    </span>
                    <span class="badge rounded-pill bg-primary">complete</span>
                </li>
                <?php

            }

        } else {

            ?>
            <li class="default-card-box-no-items-found">
                <?php echo $CI->lang->line('dashboard_no_transactions_found'); ?>
        </li>
            <?php

        }

        // Display end of the list
        echo '</ul>'; 

    }

}

/**
 * The public md_set_admin_dashboard_widget registers the widgets
 * 
 * @since 0.0.8.5
 */
md_set_admin_dashboard_widget(
    'last_tickets',
    array(
        'widget_name' => $CI->lang->line('dashboard_last_tickets'),
        'widget_description' => $CI->lang->line('dashboard_last_tickets_description'),
        'widget_icon' => md_the_admin_icon(array('icon' => 'tickets')),
        'widget_data' => 'the_admin_last_tickets_widgets_dashboard',
        'widget_default_enabled' => 1,
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/dashboard/styles/css/tickets.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(),            
        'widget_position' => md_the_admin_dashboard_widget_position('last_tickets')?md_the_admin_dashboard_widget_position('last_tickets'):3
    )
);

if ( !function_exists('the_admin_last_tickets_widgets_dashboard') ) {
    
    /**
     * The function the_admin_last_tickets_widgets_dashboard gets last tickets widget content
     * 
     * @return string with response
     */
    function the_admin_last_tickets_widgets_dashboard() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Use the base model to get the tickets
        $tickets = $CI->base_model->the_data_where(
            'tickets',
            'tickets.*, users.email',
            array(),
            array(),
            array(),
            array(array(
                'table' => 'users',
                'condition' => 'tickets.user_id=users.user_id',
                'join_from' => 'LEFT'
            )),
            array(
                'order_by' => array(
                    'tickets.ticket_id',
                    'DESC'
                ),
                'limit' => 5
            )
        );

        // Display start of the list
        echo '<ul class="dashboard-widget-tickets-list theme-card-box-list">';

        // Verify if tickets exists
        if ( $tickets ) {

            // List the tickets
            foreach ( $tickets as $ticket ) {

                // User date
                $user_date = the_crm_date_format($CI->user_id);

                // Set wanted date format
                $date_format = str_replace(array('dd', 'mm', 'yyyy'), array('d', 'm', 'Y'), $user_date);

                // Format the time
                $time_format = (($ticket['created'] + 86400) < time())?date($date_format, $ticket['created']):the_crm_calculate_time($CI->user_id, $ticket['created']);

                ?>
                <li class="dashboard-widget-tickets-ticket-single">
                    <div class="d-flex">
                        <img src="//www.gravatar.com/avatar/<?php echo md5($ticket['email']); ?>" alt="<?php echo $ticket['subject'] ?>" class="theme-profile-photo">
                        <div>
                            <h5 class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo site_url('admin/support?p=tickets&ticket=' . $ticket['ticket_id']); ?>">
                                    <?php echo $ticket['subject'] ?>
                                </a>
                                <span class="dashboard-widget-ticket-time">
                                    <?php echo md_the_admin_icon(array('icon' => 'clock')); ?>
                                    <?php echo $time_format; ?>
                                </span>                                                                                                      
                            </h5>
                            <?php

                            // Verify which status has the ticket
                            if ( (int)$ticket['status'] === 1 ) {
                                
                                // Display the status
                                echo '<p class="theme-text-color-red">'
                                    . $CI->lang->line('dashboard_unanswered')
                                . '</p>';

                            } else if ( (int)$ticket['status'] < 1 ) {
                                
                                // Display the status
                                echo '<p class="theme-text-color-grey">'
                                    . $CI->lang->line('dashboard_closed')
                                . '</p>';
                                
                            } else {
                                
                                // Display the status
                                echo '<p class="theme-text-color-blue">'
                                    . $CI->lang->line('dashboard_answered')
                                . '</p>';                    
                                
                            }

                            ?>
                        </div>
                    </div>
                </li>
                <?php

            }

        } else {

            ?>
            <li class="default-card-box-no-items-found">
                <?php echo $CI->lang->line('dashboard_no_tickets_found'); ?>
            </li>
            <?php

        }

        // Display end of the list
        echo '</ul>'; 

    }

}

if ( !function_exists('md_the_admin_dashboard_widgets') ) {
    
    /**
     * The public method md_the_admin_dashboard_widgets provides the widgets
     * 
     * @since 0.0.8.4
     * 
     * @return array with widgets or boolean false
     */
    function md_the_admin_dashboard_widgets() {
        
        // Call the widgets class
        $widgets = (new CmsBaseAdminComponentsCollectionDashboardClasses\Widgets);

        // Return widgets
        return $widgets->the_widgets();
        
    }
    
}

/* End of file dashboard_widgets.php */