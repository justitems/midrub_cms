<div class="row">
    <div class="col-lg-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-8">
                            <div class="checkbox-option-select">
                                <input id="support-articles-select-all" name="support-articles-select-all" type="checkbox">
                                <label for="support-articles-select-all"></label>
                            </div>
                            <a href="#" class="btn-option delete-faq-articles">
                                <i class="icon-trash"></i>
                                <?php echo $this->lang->line('support_delete'); ?>
                            </a>
                            <a href="<?php echo site_url('admin/support?p=faq&article=new') ?>" class="btn-option">
                                <i class="icon-doc"></i>
                                <?php echo $this->lang->line('support_new_article'); ?>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-4">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <i class="icon-magnifier"></i>
                                </span>
                                <input type="text" class="form-control search-articles" placeholder="<?php echo $this->lang->line('support_search_articles'); ?>">
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
        <ul class="list-contents">
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
                        <?php
                        echo $this->lang->line('support_of');
                        ?>
                        <span class="pagination-total"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>