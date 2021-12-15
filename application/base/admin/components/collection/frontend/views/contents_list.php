<?php
if (md_the_contents_categories()) {

    ?>
    <div class="row">
        <div class="col-12">
            <div class="card theme-list">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="theme-box-1">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo md_the_admin_icon(array('icon' => 'search')); ?>
                                        <input type="text" class="form-control theme-search-for-contents" id="theme-search-for-contents" placeholder="<?php md_get_contents_category_word('search_content'); ?>" />
                                        <?php echo md_the_admin_icon(array('icon' => 'sync', 'class' => 'theme-list-loader-icon')); ?>
                                        <a href="#" class="theme-cancel-search">
                                            <?php echo md_the_admin_icon(array('icon' => 'cancel')); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="btn-group theme-box-1 theme-button-new" role="group" aria-label="New Email Template">
                                <a href="#" class="btn btn-secondary theme-background-new theme-font-2" data-bs-toggle="modal" data-bs-target="#<?php echo (md_the_data('component_order_data') === 'auth') ? 'theme-components-selector' : 'theme-templates-selector'; ?>">
                                    <?php echo md_the_admin_icon(array('icon' => 'new_page')); ?>
                                    <?php md_get_contents_category_word('new_content'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-actions theme-box-1">
                    <div class="row">
                        <div class="col theme-list-selected-items" data-total="1">
                            <p></p>
                        </div>
                        <div class="col text-end">
                            <div class="btn-group card-actions-advaced" role="group" aria-label="Actions buttons">
                                <button type="button" class="btn btn-secondary theme-button-1 frontend-delete-contents">
                                    <?php echo md_the_admin_icon(array('icon' => 'delete')); ?>
                                    <?php echo $this->lang->line('frontend_delete'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body"></div>
                <div class="card-footer theme-box-1">
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <h6 class="theme-color-black"></h6>
                        </div>
                        <div class="col-md-7 col-12 text-end">
                            <nav aria-label="contents">
                                <ul class="theme-pagination" data-type="contents">
                                </ul>
                            </nav>
                        </div>
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
                                    <?php echo $this->lang->line('frontend_no_data_found_to_show'); ?>
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