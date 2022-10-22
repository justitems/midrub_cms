<div class="new-faq-article">
    <?php echo form_open('admin/support', array('class' => 'create-new-faq-article', 'data-csrf' => $this->security->get_csrf_token_name(), 'data-id' => the_faq_article_id())) ?>
    <div class="row">
        <div class="col-lg-9 theme-tabs">
            <?php

            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

            $first_dir = str_replace(APPPATH . 'language' . '/', '', $languages[0]);

            if (count($languages) > 1) {

                echo '<ul class="nav nav-tabs nav-justified">';
                
                $active = ' active';

                foreach ($languages as $lang) {

                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);

                    echo '<li class="nav-item">'
                        . '<a href="#' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
                            . ucfirst($only_dir)
                        . '</a>'
                    . '</li>';

                    $active = '';

                }

                echo '</ul>';
            }

            ?>
            <div class="tab-content tab-all-editors">
                <?php
                $active = ' show active';
                foreach ($languages as $lang) {

                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);

                    echo '<div id="' . $only_dir . '" class="tab-pane fade' . $active . '">'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<div class="position-relative theme-box-1">'
                                    . '<input type="text" value="' . the_faq_article_title($only_dir) . '" placeholder="' . $this->lang->line('enter_article_title') . '" class="form-control input-form article-title default-editor-title-input">'                            
                                . '</div>'
                            . '</div>'
                        . '</div>'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<div class="theme-box-1">'
                                    . '<div id="summernote" class="summernote-body body-' . $only_dir . '" data-dir="body-' . $only_dir . '"></div>'
                                        . '<textarea class="article-body content-body-' . $only_dir . ' hidden">' . the_faq_article_body($only_dir) . '</textarea>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>';

                    $active = '';

                }
                ?>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme-box-1 mb-3">
                        <div class="col-12 pt-3 pb-3 ps-4 pe-4 d-flex justify-content-between">
                            <select class="article-status theme-select">
                                <option value="1">
                                    <?php echo $this->lang->line('publish'); ?>
                                </option>
                                <option value="0">
                                    <?php echo $this->lang->line('draft'); ?>
                                </option>
                            </select>
                            <button type="submit" class="btn btn-success save-article theme-button-2">
                                <?php echo $this->lang->line('support_save'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="theme-box-1">
                        <div class="row">
                            <div class="col-lg-12 categories-list">
                                <div class="form-group">
                                    <div class="card theme-card-box">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-8">
                                                    <button class="btn btn-link">
                                                        <?php echo $this->lang->line('categories'); ?>
                                                    </button>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <button type="button" class="btn mt-2 me-3 ps-2 pe-2 btn-classification-popup-manager theme-button-1" data-bs-toggle="modal" data-bs-target="#support-categories-popup-manager">
                                                        <?php echo md_the_admin_icon(array('icon' => 'plus', 'class' => 'me-0')); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                            <?php
                                                $categories = the_faq_categories();
                                                
                                                if ($categories) {

                                                    $subcategories = array();

                                                    foreach ($categories as $category) {

                                                        if ($category->parent > 0) {

                                                            $subcategories[$category->parent][] = $category;
                                                        }

                                                    }

                                                    foreach ($categories as $cat) {

                                                        if ($cat->parent > 0) {
                                                            continue;
                                                        }

                                                        $subcats = '';

                                                        if (isset($subcategories[$cat->category_id])) {

                                                            $subcats = '<ul>';

                                                            foreach ($subcategories[$cat->category_id] as $subcat) {

                                                                $checked = '';

                                                                if ( the_faq_article_category($subcat->category_id) ) {
                                                                    $checked = ' checked';
                                                                }

                                                                $subcats .= '<li>'
                                                                    . '<div class="row">'
                                                                        . '<div class="col-lg-12">'
                                                                            . '<div class="checkbox-option-select theme-checkbox-input-1">'
                                                                                . '<label for="faq-category-' . $subcat->category_id . '">'
                                                                                    . '<input type="checkbox" name="faq-category-' . $subcat->category_id . '" id="faq-category-' . $subcat->category_id . '" data-id="' . $subcat->category_id . '"' . $checked . '>'
                                                                                    . '<span class="theme-checkbox-checkmark"></span>'
                                                                                . '</label>'
                                                                            . '</div>'
                                                                            . '<span class="support-category-name">'
                                                                                . $subcat->name
                                                                            . '</span>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                . '</li>';
                                                
                                                            }

                                                            $subcats .= '</ul>';
                                                            
                                                        }

                                                        $checked = '';

                                                        if ( the_faq_article_category($cat->category_id) ) {
                                                            $checked = ' checked';
                                                        }

                                                        echo '<li>'
                                                            . '<div class="row">'
                                                                . '<div class="col-lg-12">'
                                                                    . '<div class="checkbox-option-select theme-checkbox-input-1">'
                                                                        . '<label for="faq-category-' . $cat->category_id . '">'
                                                                            . '<input type="checkbox" name="faq-category-' . $cat->category_id . '" id="faq-category-' . $cat->category_id . '" data-id="' . $cat->category_id . '"' . $checked . '>'
                                                                            . '<span class="theme-checkbox-checkmark"></span>'
                                                                        . '</label>'
                                                                    . '</div>'
                                                                    . '<span class="support-category-name">'
                                                                        . $cat->name
                                                                    . '</span>'
                                                                . '</div>'
                                                            . '</div>'
                                                            . $subcats
                                                        . '</li>';

                                                    }
                                    
                                                } else {

                                                    echo '<li class="support-no-results-found">'
                                                        . $this->lang->line('support_no_categories_found')
                                                    . '</li>';
                                                }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>