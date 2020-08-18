<?php
/**
 * Default Widgets for Administrator
 *
 * PHP Version 7.3
 *
 * This files contains the Default_widgets Inc file
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

// Get codeigniter object instance
$CI = &get_instance();

// Register the default members widget
administrator_dashboard_set_widgets(array(

    array(
        'widget_name' => $CI->lang->line('dashboard_members'),
        'widget_slug' => 'members',
        'widget_icon' => '<i class="icon-people"></i>',
        'content' => 'administrator_dashboard_members_widget',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/collection/dashboard/styles/css/members.css?ver=' . MIDRUB_BASE_ADMIN_DASHBOARD_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/collection/dashboard/js/members.js?ver=' . MIDRUB_BASE_ADMIN_DASHBOARD_VERSION))
        ),
        'width' => 2
    )

));

if ( !function_exists('administrator_dashboard_members_widget') ) {

    /**
     * The function administrator_dashboard_members_widget displays the members widget
     * 
     * @return void
     */
    function administrator_dashboard_members_widget() {
        
        echo '<canvas id="dashboard-members-graph" height="400"></canvas>';

    }

}

// Register the default sales widget
administrator_dashboard_set_widgets(array(

    array(
        'widget_name' => $CI->lang->line('dashboard_sales'),
        'widget_slug' => 'sales',
        'widget_icon' => '<i class="icon-handbag"></i>',
        'content' => 'administrator_dashboard_sales_widget',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/collection/dashboard/styles/css/sales.css?ver=' . MIDRUB_BASE_ADMIN_DASHBOARD_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/collection/dashboard/js/sales.js?ver=' . MIDRUB_BASE_ADMIN_DASHBOARD_VERSION))
        ),
        'width' => 2
    )

));

if ( !function_exists('administrator_dashboard_sales_widget') ) {

    /**
     * The function administrator_dashboard_sales_widget displays the sales widget
     * 
     * @return void
     */
    function administrator_dashboard_sales_widget() {

        echo '<canvas id="dashboard-sales-graph" height="400"></canvas>';

    }

}

// Register the default last members widget
administrator_dashboard_set_widgets(array(

    array(
        'widget_name' => $CI->lang->line('dashboard_last_members'),
        'widget_slug' => 'last_members',
        'widget_icon' => '<i class="icon-people"></i>',
        'content' => 'administrator_dashboard_last_members_widget',
        'css_urls' => array(),
        'js_urls' => array(),
        'width' => 3
    )

));

if ( !function_exists('administrator_dashboard_last_members_widget') ) {

    /**
     * The function administrator_dashboard_last_members_widget displays the last members widget
     * 
     * @return void
     */
    function administrator_dashboard_last_members_widget() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Use the base model to get the users
        $users = $CI->base_model->get_data_where(
            'users',
            '*',
            array(),
            array(),
            array(),
            array(),
            array(
                'order' => array(
                    'user_id',
                    'DESC'
                ),
                'limit' => 5
            )
        );

        foreach ( $users as $user ) {

            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="media">
                        <div class="media-left">
                            <img src="//www.gravatar.com/avatar/<?php echo md5($user['email']); ?>" alt="<?php echo $user['username'] ?>" class="media-object">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?php echo site_url('admin/users') ?>#<?php echo $user['user_id']; ?>">
                                    <?php echo $user['first_name'] ?> <?php echo $user['last_name'] ?>
                                    <span>(<?php echo $user['username'] ?>)</span>
                                </a>
                            </h4>
                            <p>
                                <?php echo ($user['role'] < 1) ? $CI->lang->line('dashboard_user') : $CI->lang->line('dashboard_administrator'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php

        }

    }

}

// Register the default last tickets widget
administrator_dashboard_set_widgets(array(

    array(
        'widget_name' => $CI->lang->line('dashboard_last_tickets'),
        'widget_slug' => 'last_tickets',
        'widget_icon' => '<i class="fas fa-tasks"></i>',
        'content' => 'administrator_dashboard_last_tickets_widget',
        'css_urls' => array(),
        'js_urls' => array(),
        'width' => 3
    )

));

if ( !function_exists('administrator_dashboard_last_tickets_widget') ) {

    /**
     * The function administrator_dashboard_last_tickets_widget displays the last tickets widget
     * 
     * @return void
     */
    function administrator_dashboard_last_tickets_widget() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Use the base model to get the tickets
        $tickets = $CI->base_model->get_data_where(
            'tickets',
            'tickets.ticket_id, tickets.subject, tickets.body, users.email',
            array(),
            array(),
            array(),
            array(array(
                'table' => 'users',
                'condition' => 'tickets.user_id=users.user_id',
                'join_from' => 'LEFT'
            )),
            array(
                'order' => array(
                    'tickets.ticket_id',
                    'DESC'
                ),
                'limit' => 5
            )
        );

        // Verify if tickets exists
        if ( $tickets ) {

            foreach ( $tickets as $ticket ) {

                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="media">
                            <div class="media-left">
                                <img src="//www.gravatar.com/avatar/<?php echo md5($ticket['email']); ?>" alt="<?php echo $ticket['subject'] ?>" class="media-object">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?php echo site_url('admin/support?p=tickets&ticket=' . $ticket['ticket_id']); ?>">
                                        <?php echo $ticket['subject'] ?>
                                    </a>
                                </h4>
                                <p>
                                    <?php echo $ticket['body']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

            }

        } else {

            ?>
            <div class="row">
                <div class="col-sm-12">
                    <p>
                        <?php echo $CI->lang->line('dashboard_no_tickets_found'); ?>
                    </p>
                </div>
            </div>
            <?php

        }

    }

}

// Register the default transactions widget
administrator_dashboard_set_widgets(array(

    array(
        'widget_name' => $CI->lang->line('dashboard_last_transactions'),
        'widget_slug' => 'transactions',
        'widget_icon' => '<i class="fas fa-file-invoice-dollar"></i>',
        'content' => 'administrator_dashboard_transactions_widget',
        'css_urls' => array(),
        'js_urls' => array(),
        'width' => 3
    )

));

if ( !function_exists('administrator_dashboard_transactions_widget') ) {

    /**
     * The function administrator_dashboard_transactions_widget displays the transactions widget
     * 
     * @return void
     */
    function administrator_dashboard_transactions_widget() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get the transactions table
        $transactions = $CI->db->table_exists('transactions');

        // Verify if the transactions table exists
        if ( $transactions ) {

            // Use the base model to get the transactions
            $transactions = $CI->base_model->get_data_where(
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
                    'order' => array(
                        'transactions.transaction_id',
                        'DESC'
                    ),
                    'limit' => 5
                )
            );

            // Verify if transactions exists
            if ( $transactions ) {

                foreach ( $transactions as $transaction ) {

                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="media">
                                <div class="media-left">
                                    <img src="//www.gravatar.com/avatar/<?php echo md5($transaction['email']); ?>" alt="<?php echo $transaction['username'] ?>" class="media-object">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="<?php echo site_url('admin/users') ?>#<?php echo $transaction['user_id']; ?>">
                                            <?php echo $transaction['first_name'] ?> <?php echo $transaction['last_name'] ?>
                                            <span>(<?php echo $transaction['username'] ?>)</span>
                                        </a>
                                    </h4>
                                    <p>
                                        <a href="<?php echo site_url('admin/admin?p=transactions&transaction=' . $transaction['transaction_id']) ?>">
                                            <?php echo $CI->lang->line('dashboard_transaction'); ?> #<?php echo $transaction['transaction_id']; ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                }

            } else {

                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <p>
                            <?php echo $CI->lang->line('dashboard_no_transactions_found'); ?>
                        </p>
                    </div>
                </div>
                <?php

            }

        }

    }

}