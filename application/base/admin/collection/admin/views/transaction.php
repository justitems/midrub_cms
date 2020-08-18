<?php

// Get transaction's data
$transaction = md_the_transaction_by_id($this->input->get('transaction', true));

// Verify if transaction exists
if ($transaction) {
    ?>
    <div class="row transaction-header">
        <div class="col-lg-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-8">
                                <h3>
                                    #<?php echo $transaction['transaction_id']; ?>
                                </h3>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-4 text-right">
                                <?php md_get_invoice_by_id($transaction['transaction_id']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row transaction-details">
        <div class="col-lg-12">
            <div class="transaction-details-area">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="icon-basket-loaded"></i>
                        <?php echo $this->lang->line('admin_transaction_details'); ?>
                    </div>
                    <div class="panel-body">
                        <ul class="details-list">
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_status'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <?php
                                        switch ( $transaction['status'] ) {

                                            case '0':

                                                echo '<span class="label label-default">'
                                                        . $this->lang->line('admin_incomplete')
                                                    . '</span>';

                                                break;

                                            case '1':

                                                echo '<span class="label label-primary">'
                                                        . $this->lang->line('admin_success')
                                                    . '</span>';

                                                break;
                                                
                                            case '2':

                                                echo '<span class="label label-danger">'
                                                        . $this->lang->line('admin_error')
                                                    . '</span>';

                                                break;                                                

                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_user'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <span>
                                            <?php echo $transaction['username']; ?>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_amount'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <span>
                                            <?php echo $transaction['amount']; ?>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_currency'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <span>
                                            <?php echo $transaction['currency']; ?>
                                        </span>
                                    </div>
                                </div>
                            </li>  
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_gateway'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <span>
                                            <?php echo ($transaction['gateway'])?ucfirst(str_replace('_', ' ', $transaction['gateway'])):''; ?>
                                        </span>
                                    </div>
                                </div>
                            </li> 
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_gateway_transaction_id'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <span>
                                            <?php echo $transaction['net_id']; ?>
                                        </span>
                                    </div>
                                </div>
                            </li>                            
                            <li>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-xs-12">
                                        <h4>
                                            <?php echo $this->lang->line('admin_created'); ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                        <span>
                                            <?php echo strip_tags(calculate_time(time(), $transaction['created'])); ?>
                                        </span>
                                    </div>
                                </div>
                            </li>                                                                                 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row transaction-body">
        <div class="col-lg-6">
            <div class="transaction-fields">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fas fa-filter"></i>
                        <?php echo $this->lang->line('admin_transaction_fields'); ?>
                    </div>
                    <div class="panel-body">
                        <ul class="fields-list">
                            <?php
                                if (isset($transaction['fields'])) {

                                    // List all fields
                                    foreach ( $transaction['fields'] as $field ) {                                       

                                        // Display field
                                        echo '<li>'
                                            . '<div class="row">'
                                                . '<div class="col-lg-4 col-md-4 col-xs-12">'
                                                    . '<h4>'
                                                        . $field['field_name']
                                                    . '</h4>'
                                                . '</div>'
                                                . '<div class="col-lg-8 col-md-8 col-xs-12 text-right">'
                                                    . '<span>'
                                                        . $field['field_value']
                                                    . '</span>'
                                                . '</div>'
                                            . '</div>'
                                        . '</li>';

                                    }

                                } else {

                                    echo '<li>'
                                            . $this->lang->line('admin_no_transactions_fields_found')
                                        . '</li>';
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="transaction-options">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fas fa-funnel-dollar"></i>
                        <?php echo $this->lang->line('admin_transaction_options'); ?>
                    </div>
                    <div class="panel-body">
                        <ul class="options-list">
                            <?php
                                if ( isset($transaction['options']) ) {

                                    // List all options
                                    foreach ( $transaction['options'] as $option ) {                                       

                                        // Display option
                                        echo '<li>'
                                            . '<div class="row">'
                                                . '<div class="col-lg-4 col-md-4 col-xs-12">'
                                                    . '<h4>'
                                                        . $option['option_name']
                                                    . '</h4>'
                                                . '</div>'
                                                . '<div class="col-lg-8 col-md-8 col-xs-12 text-right">'
                                                    . '<span>'
                                                        . $option['option_value']
                                                    . '</span>'
                                                . '</div>'
                                            . '</div>'
                                        . '</li>';

                                    }

                                } else {

                                    echo '<li>'
                                            . $this->lang->line('admin_no_transactions_options_found')
                                        . '</li>';
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <p>
                                    <?php
                                        echo $this->lang->line('admin_no_data_found_to_show');
                                        ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
<?php
}
?>