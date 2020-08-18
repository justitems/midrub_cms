<?php
if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}

/**
 * Name: Main Helper
 * Author: Scrisoft
 * Created: 22/04/2016
 * Here you will find the following functions:
 * calculate_time - calculates time by using current time and publish time
 * update_option - saves option
 * get_option - gets option meta value
 * delete_option - deletes an option
 * smtp - configures smtp access
 * plan_feature - gets plan's feature
 * plan_explore - gets plan's start time
 * get_user_option - gets the current user option by option name
 * the_user_option - gets the current user option by option name
 * update_user_option - updates the current user option by option name
 * sends_invoice - sends the user invoice
 * calculate_size - calculates the size from bytes
 * */

if ( !function_exists( 'calculate_time' ) ) {

    /**
     * The function will calculate time between two dates
     * 
     * @param integer $from contains the time from
     * @param integer $to contains the time to
     * 
     * @return boolean true or false
     */
    function calculate_time($from, $to) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Calculate time difference
        $calculate = $to - $from;
        
        // Get after icon
        $after = ' ' . $CI->lang->line('mm104');
        
        // Define $before variable
        $before = '';
        
        // Verify if the difference time is less than 0
        if ( $calculate < 0 ) {
            
            // Get absolute value
            $calculate = abs($calculate);
            
            // Get icon
            $after = '<i class="far fa-calendar-check pull-left"></i> ';
            
            $before = '';
            
        }
        
        // Verify if the difference time is less than 1 minute
        if ( $calculate < 60 ) {
            
            return $CI->lang->line('mm105');
            
        } else if ( $calculate < 3600 ) {
            
            // Display one minute text
            $calc = $calculate / 60;
            return $before . round($calc) . ' ' . $CI->lang->line('mm106') . $after;
            
        } else if ($calculate > 3600 AND $calculate < 86400) {
            
            // Display one hour text
            $calc = $calculate / 3600;
            return $before . round($calc) . ' ' . $CI->lang->line('mm107') . $after;
            
        } else if ($calculate >= 86400) {
            
            // Display one day text
            $calc = $calculate / 86400;
            return $before . round($calc) . ' ' . $CI->lang->line('mm103') . $after;
            
        }
        
    }

}

if ( !function_exists('get') ) {

    /**
     * The function gets content via http request
     * 
     * @param string $val contains the url
     * 
     * @return string with parsed content
     */
    function get( $val ) {
        
        // Initialize a cURL session
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_URL => $val,
            CURLOPT_HEADER => 'User-Agent: Chrome\r\n',
            CURLOPT_TIMEOUT => '3L'));
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
        
    }

}

if ( !function_exists('post') ) {

    /**
     * The function post sends content via http request
     * 
     * @param string $val contains the url
     * @param array $param contains the params to send
     * @param string $token contains the token
     * 
     * @return data with returned content
     */
    function post($val, $param, $token = NULL) {
        
        // Initialize a cURL session
        $curl = curl_init($val);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        
        if ($token) {
            $authorization = "Authorization: Bearer " . $token; // **Prepare Autorisation Token**
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        }
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
        
    }

}

if ( !function_exists('delete') ) {

    /**
     * The function delete deletes content via http request
     * 
     * @param string $val contains the url
     * @param string $token contains the token
     * 
     * @return data with returned content
     */
    function delete($val, $token = NULL) {
        
        // Initialize a cURL session
        $curl = curl_init($val);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        
        if ($token) {
            $authorization = "Authorization: Bearer " . $token; // **Prepare Autorisation Token**
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        }
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
        
    }

}

if ( !function_exists('update_option') ) {

    /**
     * The function update_option updates/creates an option
     * 
     * @param string $key contains the option's key
     * @param string $value contains the new option's value
     * 
     * @return boolean true or false
     */
    function update_option( $key, $value ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Options Model
        $CI->load->model('options');
        
        return $CI->options->add_option_value( $key, $value );
        
    }

}

if ( !function_exists('get_option') ) {

    /**
     * The function gets option by option's name
     * 
     * @param string $name contains the option's name
     * 
     * @return string with option's value
     */
    function get_option( $name ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if $all_options property is not empty
        if ( !empty($CI->all_options) ) {
            
            if ( isset($CI->all_options[$name]) ) {
                return $CI->all_options[$name];
            } else {
                return false;
            }
            
        } else {
        
            // Load Options Model
            $CI->load->model('options');
            
            $CI->all_options = $CI->options->get_all_options();

            if ( isset($CI->all_options[$name]) ) {
                return $CI->all_options[$name];
            } else {
                return false;
            }
        
        }
        
    }

}

if ( !function_exists('delete_option') ) {

    /**
     * The function delete_option deletes an option
     * 
     * @param string $name contains the option's name
     * 
     * @return string with option's value
     */
    function delete_option( $name ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Options Model
        $CI->load->model('options');
        
        // Return option's value
        return $CI->options->delete_option( $name );
        
    }

}

if ( !function_exists('smtp') ) {

    /**
     * The function provides the smtp configuration
     * 
     * @return array with smtp's configuration
     */
    function smtp() {
        
        // Verify if the smtp option is enabled
        if ( get_option('smtp-enable') ) {
            
            // Set the default protocol
            $protocol = 'sendmail';
            
            // Verify if user have added a protocol
            if ( get_option('smtp-protocol') ) {
                
                $protocol = get_option('smtp-protocol');
                
            }
            
            // Create the configuration array
            $d = array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'smtpauth' => true,
                'priority' => '1',
                'newline' => "\r\n",
                'protocol' => $protocol,
                'smtp_host' => get_option('smtp-host'),
                'smtp_port' => get_option('smtp-port'),
                'smtp_user' => get_option('smtp-username'),
                'smtp_pass' => get_option('smtp-password')
            );
            
            // Verify if ssl is enabled
            if (get_option('smtp-ssl')) {
                
                $d['smtp_crypto'] = 'ssl';
                
            } elseif (get_option('smtp-tls')) {
                
                // Set TSL if is enabled
                $d['smtp_crypto'] = 'tls';
                
            }
            
            return $d;
            
        } else {
            
            return ['mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n", 'priority' => '1'];
            
        }
        
    }

}

if ( !function_exists('plan_explore') ) {

    /**
     * The function gets user plan start time
     * 
     * @return string with time
     */
    function plan_explore($user_id) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Return time when started the plan
        return $CI->plans->plan_started($user_id);
        
    }

}

if (!function_exists('get_user_option')) {
    
    /**
     * The function gets the user options(will be deprecated soon)
     * 
     * @param string $option contains the option's name
     * @param integer $user_id contains the user's id
     * 
     * @return object or string with meta's value
     */
    function get_user_option($option, $user_id = NULL) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if user_id exists
        if ( !$user_id ) {
            
            // Get user_id
            $user_id = $CI->user_id;
            
        }

        // Verify if $all_user_options property is not empty
        if ( !empty($CI->all_user_options) ) {

            if ( isset($CI->all_user_options[$option]) ) {
                
                return $CI->all_user_options[$option];
                
            } else {
                
                return false;
                
            }
            
        } else {
        
            // Load User Meta Model
            $CI->load->model('user_meta');
            
            // Get User's options
            $CI->all_user_options = $CI->user_meta->get_all_user_options($user_id);

            // Verify if user has the option
            if ( isset($CI->all_user_options[$option]) ) {

                return $CI->all_user_options[$option];

            } else {
                
                return false;
                
            }
        
        }
        
    }

}

if (!function_exists('the_user_option')) {
    
    /**
     * The function the_user_option gets the user's options
     * 
     * @param string $option contains the option's name
     * @param integer $user_id contains the user's id
     * 
     * @return object or string with meta's value
     */
    function the_user_option($option, $user_id = NULL) {

        return get_user_option($option, $user_id);

    }

}

if ( !function_exists( 'update_user_option' ) ) {
    
    /**
     * The function update_user_option updates the user's option
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * @param string $meta_value contains the user's meta value
     * 
     * @return boolean true or false
     */
    function update_user_option($user_id, $meta_name, $meta_value) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load User Meta Model
        $CI->load->model('user_meta');
        
        // Save meta value
        return $CI->user_meta->update_user_meta($user_id, $meta_name, $meta_value);
        
    }

}

if ( !function_exists( 'delete_user_option' ) ) {
    
    /**
     * The function delete_user_option deletes a user's option
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * 
     * @return boolean true or false
     */
    function delete_user_option($user_id, $meta_name) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Delete meta
        return $CI->user->delete_user_option($user_id, $meta_name);
        
    }

}

if (!function_exists('plan_feature')) {
    
    /**
     * The function gets plan's feature
     * 
     * @param string $features contains the feature's name
     * @param integer $plan_id contains optionally the plan's id
     * 
     * @return string with feature's value or boolean false
     */
    function plan_feature($feature, $plan_id = 0) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if $plan_features property is not empty
        if ( !empty($CI->plan_features) ) {
            
            if ( isset($CI->plan_features[$feature]) ) {
                
                return $CI->plan_features[$feature];
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            if ( !$plan_id ) {
                $plan_id = get_user_option('plan');
            }
            
            $plan_info = $CI->plans->get_plan($plan_id);

            if ( isset($plan_info[0]) ) {

                $CI->plan_features = $plan_info[0];

            }

            // Verify if plan's feature exists
            if ( isset($CI->plan_features[$feature]) ) {

                return $CI->plan_features[$feature];

            } else {
                
                return false;
                
            }
        
        }
        
    }

}

if ( !function_exists('sends_invoice') ) {
    
    /**
     * The function sends invoice to user
     * 
     * @param integer $invoice_id contains the invoice_id
     * 
     * @return boolean true or false
     */
    function sends_invoice( $invoice_id ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_admin_lang.php' ) ) {
            $CI->lang->load( 'default_admin', $CI->config->item('language') );
        }
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_alerts_lang.php' ) ) {
            $CI->lang->load( 'default_alerts', $CI->config->item('language') );
        }
        
        // Load Invoice Model
        $CI->load->model('invoice');
        
        // Get the invoice's details
        $invoice = $CI->invoice->get_invoice( $invoice_id );
        
        // Verify if invoice exists
        if ( $invoice ) {
            
            // Get the invoice logo
            $invoice_logo = get_option( 'main-logo' );

            if ( get_option( 'invoice-logo' ) ) {

                $invoice_logo = get_option( 'invoice-logo' );

            }

            // Get the invoice billing period text
            $billing_period = 'Billing Period';

            if ( get_option( 'invoice-billing-period' ) ) {

                $billing_period = get_option( 'invoice-billing-period' );

            }   

            // Get the invoice transaction id
            $transaction_id = 'Transaction ID';

            if ( get_option( 'invoice-transaction-id' ) ) {

                $transaction_id = get_option( 'invoice-transaction-id' );

            }         

            // Get the invoice date format
            $date_format = 'dd-mm-yyyy';

            if ( get_option( 'invoice-date-format' ) ) {

                $date_format = get_option( 'invoice-date-format' );

            }
            
            // Get invoice's from period
            $from_period = str_replace(['dd', 'mm', 'yyyy'], [date('d', strtotime($invoice[0]->from_period)), date('m', strtotime($invoice[0]->from_period)), date('Y', strtotime($invoice[0]->from_period))], $date_format);
            
            // Get invoice's to period
            $to_period = str_replace(['dd', 'mm', 'yyyy'], [date('d', strtotime($invoice[0]->to_period)), date('m', strtotime($invoice[0]->to_period)), date('Y', strtotime($invoice[0]->to_period))], $date_format);
            
            // Get invoice's date
            $invoice_date = str_replace(['dd', 'mm', 'yyyy'], [date('d', strtotime($invoice[0]->invoice_date)), date('m', strtotime($invoice[0]->invoice_date)), date('Y', strtotime($invoice[0]->invoice_date))], $date_format);            

            // Get the invoice hello text
            $hello_text = str_replace('[username]', $invoice[0]->username, 'Hello [username]');

            if ( get_option( 'invoice-hello-text' ) ) {

                $hello_text = str_replace('[username]', $invoice[0]->username, get_option( 'invoice-hello-text' ) );

            }

            // Get the invoice message
            $message = 'Thanks for using using our services.';

            if ( get_option( 'invoice-message' ) ) {

                $message = get_option( 'invoice-message' );

            }

            // Get the invoice date word
            $date = 'Date';

            if ( get_option( 'invoice-date' ) ) {

                $date = get_option( 'invoice-date' );

            }

            // Get the invoice description word
            $description = 'Description';

            if ( get_option( 'invoice-description' ) ) {

                $description = get_option( 'invoice-description' );

            }  

            // Get the invoice description text
            $description_text = 'Upgrade Payment';

            if ( get_option( 'invoice-description-text' ) ) {

                $description_text = get_option( 'invoice-description-text' );

            }  

            // Get the invoice amount word
            $amount = 'Amount';

            if ( get_option( 'invoice-amount' ) ) {

                $amount = get_option( 'invoice-amount' );

            }  

            // Get the invoice amount word
            $taxes = 'Taxes';

            if ( get_option( 'invoice-taxes' ) ) {

                $taxes = get_option( 'invoice-taxes' );

            }       

            // Get the invoice total word
            $total = 'Total';

            if ( get_option( 'invoice-total' ) ) {

                $total = get_option( 'invoice-total' );

            }

            // Get the no reply message
            $no_reply = 'Please do not reply to this email. This mailbox is not monitored and you will not receive a response. For assistance, please contact us to info@ouremail.com.';

            if ( get_option( 'invoice-no-reply' ) ) {

                $no_reply = get_option( 'invoice-no-reply' );

            }  
            
            $amount_value = $invoice[0]->amount . ' ' . $invoice[0]->currency;
            
            $invoice_taxes = '';
            
            if ( $invoice[0]->taxes ) {
                
                $invoice_taxes = '<tr class="taxes-area">
                                    <td style="width:80%;text-align:right;padding:0 10px 10px 0;" class="invoice-taxes">
                                    ' . $taxes . '</td>
                                    <td style="width:20%;text-align:right;padding:0 10px 10px 0;">
                                        <span style="display:inline;" class="invoice-taxes-value">
                                        ' . $invoice[0]->taxes . ' %
                                        </span>

                                    </td>
                                </tr>';

            }
            
            $body = '<table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody><tr><td align="center" width="600" valign="top">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="top" bgcolor="#ffffff">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;" width="100%">
                                                        <tbody><tr valign="bottom">    
                                                                <td width="20" align="center" valign="top">&nbsp;</td>
                                                                <td align="left" height="64">
                                                                    <img alt="logo" class="invoice-logo" src="' . $invoice_logo . '">
                                                                </td>   
                                                                <td width="40" align="center" valign="top">&nbsp;</td>
                                                                <td align="right">
                                                                    <span style="padding-top:15px;padding-bottom:10px;font:italic 12px;color:#757575;line-height:15px;">
                                                                        <span style="display:inline;">
                                                                            <span class="invoice-billing-period">' . $billing_period . '</span> <strong><span class="invoice-date-format billing-period-from">' . $from_period . '</span> ' . $CI->lang->line('ma205') . ' <span class="invoice-date-format billing-period-to">' . $to_period . '</span></strong>
                                                                        </span>
                                                                        <span style="display:inline;">
                                                                            <br>
                                                                            <span class="invoice-transaction-id">' . $transaction_id . '</span>: <strong class="transaction-id">' . $invoice[0]->transaction_id . '</strong>
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                                <td width="20" align="center" valign="top">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px;padding-top:10px;margin-bottom:20px;" width="100%">
                                                        <tbody><tr valign="bottom">    
                                                                <td width="20" align="center" valign="top">&nbsp;</td>
                                                                <td valign="top" style="font-family:Calibri, Trebuchet, Arial, sans serif;font-size:15px;line-height:22px;color:#333333;" class="yiv1811948700ppsans">
                                                                    <p>
                                                                    </p><div style="margin-top:30px;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;"><span style="color:#333333;font-weight:bold;font-family:arial, helvetica, sans-serif;" class="invoice-hello-text">' . $hello_text . '</span><p class="invoice-message">' . $message . '</p><br><div style="margin-top:5px;">
                                                                            <br><div class="yiv1811948700mpi_image" style="margin:auto;clear:both;">
                                                                            </div>
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="clear:both;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;margin-top:20px;" width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="text-align:left;border:1px solid #ccc;border-right:none;border-left:none;padding:5px 10px 5px 10px !important;color:#333333;" class="invoice-date" width="10%">
                                                                                        ' . $date . '</td>
                                                                                        <td style="border:1px solid #ccc;border-right:none;border-left:none;padding:5px 10px 5px 10px !important;color:#333333;" width="80%" class="invoice-description">
                                                                                        ' . $description . '</td>
                                                                                        <td style="text-align:right;border:1px solid #ccc;border-right:none;border-left:none;padding:5px 10px 5px 10px !important;color:#333333;" width="10%" class="amount">
                                                                                        ' . $amount . '</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="text-align:left;padding:10px;" width="10%" class="invoice-date-format invoice-created-date">
                                                                                        ' . $invoice_date . '</td>                                                                                                            
                                                                                        <td style="padding:10px;" width="80%">
                                                                                            <span class="invoice-description-text">' . $description_text . '</span>
                                                                                            <br>

                                                                                            <span style="display:inline;font-style: italic;color: #888888;" class="invoice-plan-name">
                                                                                            </span>
                                                                                        </td>
                                                                                        <td style="text-align:right;padding:10px;" width="10%" class="invoice-amount">
                                                                                        ' . $amount_value . '
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #ccc;border-bottom:1px solid #ccc;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;margin-bottom:10px;" width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;margin-top:10px;">
                                                                                                <tbody>
                                                                                                    ' . $invoice_taxes . '
                                                                                                    <tr>
                                                                                                        <td style="width:80%;text-align:right;padding:0 10px 10px 0;">
                                                                                                            <span style="color:#333333;font-weight:bold;" class="invoice-total">
                                                                                                            ' . $total . '
                                                                                                            </span>
                                                                                                        </td>
                                                                                                        <td style="width:20%;text-align:right;padding:0 10px 10px 0;" class="invoice-total-value">
                                                                                                        ' . $invoice[0]->total . ' ' . $invoice[0]->currency . '
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody></table>
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody></table>
                                                                            <span style="font-size:11px;color:#333;" class="invoice-no-reply">' . $no_reply . '</span></div>
                                                                        <span style="font-weight:bold;color:#444;">
                                                                        </span>
                                                                        <span>
                                                                        </span>
                                                                    </div></td>
                                                                    <td width="20" align="center" valign="top">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>            
                                </td>
                            </tr>
                        </tbody>
                    </table>';
            
            if ( get_user_option('invoices_by_email', $invoice[0]->user_id) ) {

                // Sends to getted emails
                $CI->email->from($CI->config->item('contact_mail'), $CI->config->item('site_name'));
                $CI->email->to([$invoice[0]->email, $CI->config->item('notification_mail')]);
                $CI->email->subject($CI->lang->line('ma190'));
                $CI->email->message($body);

                if ( $CI->email->send() ) {

                    // Set invoice status
                    $CI->invoice->set_status( $invoice_id, 1 );

                    return true;

                } else {

                    return false;

                }
            
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }

}

if ( !function_exists( 'calculate_size' ) ) {
    
    /**
     * The function calculate_size calculates the size
     * 
     * @param integer $size contains size in bytes
     * 
     * @return string with size
     */
    function calculate_size($size) {
        if (!$size) {
            return '0';
        }
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');
        if ( isset($suffixes[floor($base)]) ) {
            return round(pow(1024, $base - floor($base)), 2) . ' ' . $suffixes[floor($base)];
        } else {
            return '0';
        }
        
    }

}

if ( !function_exists( 'get_post_media_array' ) ) {
    
    /**
     * The function update_user_meta updates the user's meta
     * 
     * @param integer $user_id contains the user_id
     * @param array $medias contains the medias's ids 
     * 
     * @return array with medias
     */
    function get_post_media_array($user_id, $medias) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Media Model
        $CI->load->model('media');
        
        // Verify if $medias is not empty
        if ( $medias ) {
            
            // Get urls if exists
            return $CI->media->get_medias_by_type($user_id, $medias);
            
        } else {
            
            return $medias;
            
        }
        
    }

}

if (!function_exists('parse_array')) {
    
    /**
     * The function applies a user function recursively to every member of an array
     * 
     * @return string with custom code
     */
    function parse_array($array) {
        
        $parsed = array();
        
        array_walk_recursive($array, function($a) use (&$parsed) {
            $parsed[] = $a;
        });
        
        return $parsed;
        
    }

}



