<section class="gateways-page">
    <div class="container-fluid" data-price="<?php echo $plan_data[0]->plan_price; ?>">
        <div class="row">
            <div class="col-xl-4 offset-xl-4">
                <div class="col-xl-12">
                    <div class="panel panel-success mb-4">
                        <div class="panel-heading">
                            <h3>
                                <?php echo $this->lang->line('plans_total'); ?>
                                <span class="pull-right plan-price">
                                    <?php echo $plan_data[0]->plan_price ?>
                                </span>
                                <span class="pull-right">
                                    <?php echo $plan_data[0]->currency_sign ?>
                                </span>
                                <span class="pull-right discount-price"></span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('user/plans?p=upgrade&plan=' . $plan_id, array('class' => 'verify-coupon-code', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                            <div class="row coupon-code">
                                <div class="col-xl-8 col-sm-8 col-xs-8 col-8">
                                    <input type="text" class="code" placeholder="<?php echo $this->lang->line('plans_enter_coupon'); ?>" required>
                                </div>
                                <div class="col-xl-4 col-sm-4 col-xs-4 col-4">
                                    <button type="submit" class="btn btn-primary verify-coupon-code"><?php echo $this->lang->line('plans_apply'); ?></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-12">
                                    <a href="<?php echo site_url('user/plans?p=upgrade&plan=' . $plan_id) ?>" class="btn btn-primary">
                                        <?php echo $this->lang->line('plans_next'); ?>
                                        <i class="icon-arrow-right-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>