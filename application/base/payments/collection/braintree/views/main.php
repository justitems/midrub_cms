<div class="container">
    <div class="payment-container">
        <?php echo form_open('payments/braintree/pay', array('class' => 'process-payment', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
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
                        <label for="number">
                            <?php echo $this->lang->line('card_number'); ?>
                        </label>
                        <div id="number" class="form-control"></div>
                    </div>
                    <div class="input-group w-25">
                        <label>
                            <?php echo $this->lang->line('expiration'); ?>
                        </label>
                        <div id="date" class="form-control"></div>
                    </div>
                    <div class="input-group w-25">
                        <label>
                            <?php echo $this->lang->line('cvv'); ?>
                        </label>
                        <div id="cvv" class="form-control"></div>
                    </div>
                    <div class="input-group w-25 float-right d-inline-block">
                        <?php if ( isset($recurring_payments) ) { ?>
                        <label class="subscribe">
                            <?php echo $this->lang->line('subscribe'); ?>
                        </label>
                        <div class="checkbox-option pull-right">
                            <input id="recurring-payments" name="recurring-payments" class="app-option-checkbox" type="checkbox" checked>
                            <label for="recurring-payments"></label>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="input-group">
                        <input class="card-input-amount" type="hidden" value="<?php echo $amount; ?>">
                        <input name="nonce" id="nonce" type="hidden" class="form-control">
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

<!-- Authorization -->
<div class="modal fade" id="load-authorization" tabindex="-1" role="dialog" aria-boostledby="load-authorization" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <?php echo $this->lang->line('authorization'); ?>
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-boost="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<!-- Token -->
<?php if ( isset($token) ) { ?>
    <script lang="javascript">
        var token = '<?php echo $token; ?>';
    </script>
<?php } ?>