<section>
    <div class="container-fluid payments">
        <div class="row">
            <div class="col-lg-6">
                <div class="col-lg-12 gateway-body">
                    <div class="row coupon-code">
                        <?= form_open('admin/coupon-codes', ['class' => 'coupon-codes']) ?>
                            <div class="col-lg-12">
                                <input type="number" name="value" max="100" placeholder="<?= $this->lang->line('ma185'); ?>" required>
                            </div>
                            <div class="col-lg-12">
                                <select name="type">
                                    <option value="0">
                                        <?= $this->lang->line('ma184'); ?>
                                    </option>
                                    <option value="1">
                                        <?= $this->lang->line('ma186'); ?>
                                    </option>
                                </select>
                            </div>                        
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><?= $this->lang->line('ma187'); ?></button>
                            </div>
                        <?= form_close() ?>
                    </div>
                    <?php if ( $alert ) { ?>
                    <script language="javascript">
                        setTimeout( function() {
                            Main.popup_fon( '<?= $alert[0]; ?>', '<?= $alert[1]; ?>', 1500, 2000);
                            get_coupon_codes(1);
                        }, 1500);
                    </script>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-lg-12 gateway-body">
                    <div class="row coupons-list">
                        <h2><?= $this->lang->line('ma188'); ?></h2>
                        <div class="col-lg-12 clean">
                            <ul class="coupon-codes">

                            </ul>
                        </div>
                        <div class="col-lg-12 clean">
                            <ul class="pagination">

                            </ul>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>