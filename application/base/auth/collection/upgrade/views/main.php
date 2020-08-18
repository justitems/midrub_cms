<main role="main" class="main">
    <section class="gateways bg-white" data-price="<?php echo $plan[0]['plan_price'] ?>">
        <div class="container">
            <div class="row">
                <div class="gateway-body col-lg-6 offset-lg-3">
                    <div class="row">
                        <div class="col-lg-12 the-price">
                            <h3>
                                <?php echo $this->lang->line('auth_upgrade_total'); ?>
                                <span class="plan-price"><?php echo $plan[0]['plan_price'] ?></span>
                                <span><?php echo $plan[0]['currency_sign'] ?> </span>
                                <span class="discount-price"></span>
                            </h3>
                        </div>
                    </div>
                    <?php echo form_open('user/upgrade/' . $plan[0]['plan_id'], array('class' => 'verify-coupon-code', 'data-id' => $plan[0]['plan_id'])) ?>
                    <div class="row coupon-code">
                        <div class="col-lg-8 col-8">
                            <input type="text" class="code" placeholder="<?php echo $this->lang->line('auth_upgrade_enter_coupon_code'); ?>" required>
                        </div>
                        <div class="col-lg-4 col-4">
                            <button type="submit" class="btn btn-primary verify-coupon-code"><?php echo $this->lang->line('auth_upgrade_apply'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <div class="row">
                        <div class="col-lg-12 clean">
                            <?php
                            // Verify if payments class are available
                            if ($payments) {

                                echo '<ul>';

                                // List all enabled payments
                                foreach ($payments as $payment) {

                                    echo '<li>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-2 clean text-center">
                                                            <img src="' . $payment['icon'] . '" alt="PayPal">
                                                        </div>
                                                        <div class="col-lg-7 col-7 clean">
                                                            <h3>' . $payment['name'] . '</h3>
                                                        </div>
                                                        <div class="col-lg-3 col-3 clean text-center">
                                                            <a href="' . site_url('auth/upgrade?p=upgrade&plan=' . $plan[0]['plan_id'] . '&gateway=' . $payment['slug']) . '" class="pay-now">' . $this->lang->line('auth_upgrade_pay_now') . '</a>
                                                        </div>                                
                                                    </div>
                                                </li>';
                                }

                                echo '</ul>';

                            } else {

                                echo '<br><p>' . $this->lang->line('auth_upgrade_no_payments') . '</p>';
                                
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<!-- Translations !-->
<script language="javascript">
    var words = {
        mm216: "<?php echo $this->lang->line('mm216'); ?>",
        mm217: "<?php echo $this->lang->line('mm217'); ?>"
    };
</script> 