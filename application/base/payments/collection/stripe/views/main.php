<div class="container">
    <div class="payment-container">
        <?php echo form_open('payments/braintree/pay', array('class' => 'process-payment', 'data-transaction' => $transaction_id, 'data-csrf' => $this->security->get_csrf_token_name())); ?>
        <div class="row">
            <div class="col-12">
                <h3>
                    <?php echo $this->lang->line('pay_with_credit_card'); ?>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <div class="input-group">
                        <label for="name">
                            <?php echo $this->lang->line('name'); ?>
                        </label>
                        <input id="name" class="card-input-first-name" maxlength="20" type="text" placeholder="<?php echo $this->lang->line('first_last_name'); ?>">
                    </div>
                    <div class="input-group">
                        <label for="name">
                            <?php echo $this->lang->line('card_number'); ?>
                        </label>
                        <input id="cardnumber" class="card-input-number" type="text" placeholder="1111 1111 1111 1111" maxlength="19">
                    </div>
                    <div class="input-group w-25 d-inline-block">
                        <label for="expirationdate">
                            <?php echo $this->lang->line('expiration'); ?>
                        </label>
                        <input id="expirationdate" class="card-input-expiration" type="text" placeholder="<?php echo $this->lang->line('mm_yy'); ?>" maxlength="5">
                    </div>
                    <div class="input-group w-25 d-inline-block">
                        <label for="securitycode">
                            <?php echo $this->lang->line('cvv'); ?>
                        </label>
                        <input id="securitycode" class="card-input-security" type="text" placeholder="<?php echo $this->lang->line('3_digits'); ?>" maxlength="3">
                    </div>
                    <div class="input-group w-25 float-right d-inline-block">
                        <input class="card-input-amount" type="hidden" value="<?php echo $amount; ?>">
                        <input class="card-input-currency" type="hidden" value="<?php echo $currency; ?>">
                    </div>
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $this->lang->line('pay_now'); ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-5 offset-md-1">
                <div class="card">
                    <div class="card-line"></div>
                    <div class="row">
                        <div class="col-7 card-signature">

                        </div>
                        <div class="col-1 card-secure">
                            333
                        </div>
                    </div>
                    <div class="card-number">1111 1111 1111 1111</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-owner">
                                <?php echo $this->lang->line('john_doe'); ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-expiry-date"><?php echo date('m/y'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="total-price">
                    <h3>
                        <?php echo $this->lang->line('total'); ?>:
                        <span>
                            <?php echo isset($sign)?$sign . ' ':''; ?>
                            <?php echo $amount; ?>
                        </span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="notification">
                    
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- Word list for JS !-->
<script language="javascript">
    var words = {
        secure_authentication_failed: '<?php echo $this->lang->line('stripe_3d_secure_authentication_failed'); ?>',
        unexpected_ecure_status: '<?php echo $this->lang->line('stripe_unexpected_ecure_status'); ?>',
        public_key: '<?php echo get_option('stripe_public_key'); ?>'
    };
</script>