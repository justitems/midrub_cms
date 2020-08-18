<div class="container">
    <div class="payment-container">
        <?php echo form_open('payments/paypal/pay', array('class' => 'process-payment', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
        <div class="row">
            <div class="col-12">
                <h3>
                    <?php echo $this->lang->line('pay_with_credit_card'); ?>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="container text-center">
                    <div id="paypal-button-container"></div>
                </div>
                <input class="input-amount" type="hidden" value="<?php echo $amount; ?>">
                <input class="input-currency" type="hidden" value="<?php echo $currency; ?>">
                <input class="input-client-id" type="hidden" value="<?php echo get_option('paypal_client_id'); ?>">
                <?php if (isset($recurring_payments)) { ?>
                <input class="input-plan" type="hidden" value="<?php echo $plan_id; ?>">
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <br>
                <div class="notification">

                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo get_option('paypal_client_id'); ?>&vault=true" data-namespace="paypal_sdk"></script>