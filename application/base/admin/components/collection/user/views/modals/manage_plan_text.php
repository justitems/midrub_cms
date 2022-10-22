<!-- Modal -->
<div class="modal fade theme-modal" id="user-plan-manage-text" tabindex="-1" role="dialog" aria-labelledby="user-plan-manage-text-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/user', array('class' => 'user-plan-manage-text', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('user_plan_text'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                
            </div>
            <div class="modal-body theme-tabs">
                <ul class="nav nav-tabs nav-justified mb-3">
                    <?php

                    // Get all languages
                    $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                    // List all languages
                    foreach ($languages as $language) {

                        // Get language dir name
                        $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                        // Active variable
                        $active = '';

                        // Verify if is the configured language
                        if ($this->config->item('language') === $only_dir) {
                            $active = ' active';
                        }

                        echo '<li class="nav-item">'
                            . '<a href="#nav-plan-text-language-' . $only_dir . '" class="nav-link' . $active . '" id="nav-plan-text-language-' . $only_dir . '-tab" data-bs-toggle="tab" data-bs-target="#nav-plan-text-language-' . $only_dir . '">'
                                . ucfirst($only_dir)
                            . '</a>'
                        . '</li>';

                    }

                    ?>
                </ul>
                <div class="tab-content" id="nav-plan-text-tabs">
                    <?php

                    // Texts container
                    $texts = array();

                    // Get the texts
                    $the_texts = $this->base_model->the_data_where(
                        'plans_texts',
                        '*',
                        array(
                            'plan_id' => $this->input->get('plan_id')
                        )
                    );

                    // Verify if texts exists
                    if ( $the_texts ) {

                        // List the texts
                        foreach ( $the_texts as $the_text ) {

                            // Verify if language exists
                            if ( !isset($texts[$the_text['language']]) ) {

                                // Set the language
                                $texts[$the_text['language']] = array();

                            }

                            // Verify if name is title
                            if ( $the_text['text_name'] === 'title' ) {

                                // Set title
                                $texts[$the_text['language']]['title'] = $the_text['text_value'];

                            } else if ( $the_text['text_name'] === 'short_description' ) {

                                // Set short description
                                $texts[$the_text['language']]['short_description'] = $the_text['text_value'];

                            } else if ( $the_text['text_name'] === 'displayed_price' ) {

                                // Set displayed price
                                $texts[$the_text['language']]['displayed_price'] = $the_text['text_value'];

                            } else {

                                // Verify if features exists
                                if ( !isset($texts[$the_text['language']]['features']) ) {

                                    // Set the features
                                    $texts[$the_text['language']]['features'] = array();

                                }

                                // Set the feature
                                $texts[$the_text['language']]['features'][] = $the_text['text_value'];

                            }

                        }

                    }

                    // List all languages
                    foreach ($languages as $language) {

                        // Get language dir name
                        $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                        // Active variable
                        $active = '';

                        // Verify if is the configured language
                        if ($this->config->item('language') === $only_dir) {
                            $active = ' show active';
                        }

                        // Default title
                        $title = '';

                        // Default short description
                        $short_description = '';

                        // Default displayed price
                        $displayed_price = '';                        

                        // Verify if language exists
                        if ( isset($texts[$only_dir]) ) {

                            // Verify if title exists
                            if ( isset($texts[$only_dir]['title']) ) {

                                // Set title
                                $title = ' value="' . htmlentities($texts[$only_dir]['title']) . '"';

                            } 
                            
                            if ( isset($texts[$only_dir]['short_description']) ) {

                                // Set short description
                                $short_description = ' value="' . htmlentities($texts[$only_dir]['short_description']) . '"';

                            }

                            if ( isset($texts[$only_dir]['displayed_price']) ) {

                                // Set displayed price
                                $displayed_price = ' value="' . htmlentities($texts[$only_dir]['displayed_price']) . '"';

                            }

                        }

                        ?>
                        <div id="nav-plan-text-language-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>" data-language="<?php echo $only_dir; ?>">
                            <div class="form-group mb-3">
                                <label class="theme-label" for="user-plan-manage-text-title-<?php echo $only_dir; ?>">
                                    <?php echo $this->lang->line('user_plan_title'); ?>
                                </label>
                                <input type="text"<?php echo $title; ?> placeholder="<?php echo $this->lang->line('user_plan_enter_title'); ?>" class="form-control mb-3 theme-text-input-1 user-plan-manage-text-title" id="user-plan-manage-text-title-<?php echo $only_dir; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label class="theme-label" for="user-plan-manage-text-short-description-<?php echo $only_dir; ?>">
                                    <?php echo $this->lang->line('user_plan_short_description'); ?>
                                </label>
                                <input type="text"<?php echo $short_description; ?> placeholder="<?php echo $this->lang->line('user_plan_enter_short_description'); ?>" class="form-control mb-3 theme-text-input-1 user-plan-manage-text-short-description" id="user-plan-manage-text-short-description-<?php echo $only_dir; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label class="theme-label" for="user-plan-manage-text-displayed-price-<?php echo $only_dir; ?>">
                                    <?php echo $this->lang->line('user_plan_displayed_price'); ?>
                                </label>
                                <input type="text"<?php echo $displayed_price; ?> placeholder="<?php echo $this->lang->line('user_plan_enter_displayed_price'); ?>" class="form-control mb-3 theme-text-input-1 user-plan-manage-text-displayed-price" id="user-plan-manage-text-displayed-price-<?php echo $only_dir; ?>">
                            </div>                                                       
                            <div class="form-group">
                                <label class="theme-label" for="user-plan-features-<?php echo $only_dir; ?>">
                                    <?php echo $this->lang->line('user_plan_features'); ?>
                                </label>                                
                                <div class="input-group">
                                    <input type="text" placeholder="<?php echo $this->lang->line('user_plan_enter_feature'); ?>" class="form-control theme-text-input-1 user-plan-feature" id="user-plan-features-<?php echo $only_dir; ?>" aria-describedby="user-plan-features-<?php echo $only_dir; ?>">
                                    <button type="button" class="btn btn-primary theme-button-1 input-group-text user-save-plan-feature">
                                        <?php echo $this->lang->line('user_plan_feature_add'); ?>
                                    </button>
                                </div>
                                <div class="card theme-card-box">
                                    <div class="card-body ps-0 pe-0">
                                        <ul class="list-group theme-card-box-list user-plan-features">
                                            <?php

                                            // Verify if language exists
                                            if ( isset($texts[$only_dir]) ) {

                                                // Verify if features exists
                                                if ( isset($texts[$only_dir]['features']) ) {

                                                    // List the features
                                                    foreach ( $texts[$only_dir]['features'] as $feature ) {

                                                        // Display feature
                                                        echo '<li class="list-group-item d-flex justify-content-between">'
                                                            . '<span>'
                                                                . htmlentities($feature)
                                                            . '</span>'
                                                            . '<button type="button" class="btn btn-link btn-delete-plan-feature">'
                                                                . md_the_admin_icon(array('icon' => 'delete'))
                                                            . '</button>'   
                                                        . '</li>';

                                                    }

                                                }

                                            }                                            
                                            
                                            ?>
                                        </ul>
                                    </div>                       
                                </div>
                            </div>
                        </div>
                        <?php

                    }

                    ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>