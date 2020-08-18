<div class="row">
    <div class="col-lg-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-8">
                            <div class="checkbox-option-select">
                                <input id="admin-invoices-select-all" name="admin-invoices-select-all" type="checkbox">
                                <label for="admin-invoices-select-all"></label>
                            </div>
                            <a href="#" class="btn-option delete-invoices">
                                <i class="icon-trash"></i>
                                <?php echo $this->lang->line('admin_delete'); ?>
                            </a>
                            <a href="<?php echo site_url('admin/admin?p=invoices&template=1'); ?>" class="btn-option">
                                <i class="fas fa-receipt"></i>
                                <?php echo $this->lang->line('admin_template'); ?>
                            </a>                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-4">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <i class="icon-magnifier"></i>
                                </span>
                                <input type="text" class="form-control search-invoices" placeholder="<?php echo $this->lang->line('admin_search_fot_invoices'); ?>">
                                <input type="hidden" class="csrf-sanitize" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <ul class="list-invoices">
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pagination-area">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-6">
                    <ul class="pagination">
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 text-right">
                    <p>
                        <span>
                            <span class="pagination-from"></span>
                            –
                            <span class="pagination-to"></span>
                        </span>
                        <?php echo $this->lang->line('frontend_of'); ?>
                        <span class="pagination-total"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>