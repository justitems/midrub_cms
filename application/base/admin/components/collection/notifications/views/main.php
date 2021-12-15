<section class="section notifications-page" data-csrf="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-10 col-md-9 notifications-view">
                <?php get_the_admin_notifications_page_content(md_the_data('component_display')); ?>
            </div>            
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade in theme-modal" id="notifications-users-alert-filters-plans-filter" tabindex="-1" role="dialog" aria-labelledby="notifications-users-alert-filters-plans-filter-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" placeholder="<?php echo $this->lang->line('notifications_search_for_plans'); ?>" class="w-75 border-0 p-0 theme-text-input-1 notifications-search-for-plans">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="notifications-users-alert-filters-plans-filter-list"></ul>
            </div>
            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-md-5 col-12">
                        <h6 class="theme-color-black"></h6>
                    </div>
                    <div class="col-md-7 col-12 text-end">
                        <nav aria-label="plans">
                            <ul class="theme-pagination" data-type="plans">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade in theme-modal" id="notifications-users-alert-filters-languages-filter" tabindex="-1" role="dialog" aria-labelledby="notifications-users-alert-filters-languages-filter-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('notifications_all_languages'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="notifications-users-alert-filters-languages-filter-list">
                    <?php

                    // Get all languages
                    $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                    // List all languages
                    foreach ( $languages as $language ) {

                        // Get language dir name
                        $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                        // Display language
                        echo '<li>'
                            . '<div class="row">'
                                . '<div class="col-xs-12 d-flex justify-content-start position-relative">'
                                    . '<div class="checkbox-option-select theme-checkbox-input-1">'
                                        . '<label for="notifications-users-alert-filters-languages-filter-language-' . $only_dir . '">'
                                            . '<input type="checkbox" name="notifications-users-alert-filters-languages-filter-language-' . $only_dir . '" id="notifications-users-alert-filters-languages-filter-language-' . $only_dir . '" data-language="' . $only_dir . '" />'
                                            . '<span class="theme-checkbox-checkmark"></span>'
                                        . '</label>'
                                    . '</div>'
                                    . '<span>'
                                        . ucfirst($only_dir)
                                    . '</span>'
                                . '</div>'
                            . '</div>'
                        . '</li>';
                    }

                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Word list for JS !-->
<script language="javascript">
    var words = {
        no_languages_were_selected: '<?php echo $this->lang->line('notifications_no_languages_were_selected'); ?>',
        no_plans_were_selected: '<?php echo $this->lang->line('notifications_no_plans_were_selected'); ?>',
        all_users: '<?php echo $this->lang->line('notifications_all_users'); ?>',
        icon_mail_template: '<?php echo md_the_admin_icon(array('icon' => 'mail_template')); ?>',
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        selected_items: '<?php echo $this->lang->line('frontend_selected_items'); ?>'
    };
</script>