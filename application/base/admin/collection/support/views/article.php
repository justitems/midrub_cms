<div class="new-faq-article">
    <?php echo form_open('admin/support', array('class' => 'create-new-faq-article', 'data-csrf' => $this->security->get_csrf_token_name(), 'data-id' => the_faq_article_id())) ?>
    <div class="row">
        <div class="col-lg-7 col-lg-offset-1">
            <?php

            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

            $first_dir = str_replace(APPPATH . 'language' . '/', '', $languages[0]);

            if (count($languages) > 1) {

                echo '<ul class="nav nav-tabs nav-justified">';
                
                $active = ' class="active"';

                foreach ($languages as $lang) {

                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);

                    echo '<li' . $active . '><a data-toggle="tab" href="#' . $only_dir . '">' . ucfirst($only_dir) . '</a></li>';

                    $active = '';

                }

                echo '</ul>';
            }

            ?>
            <div class="tab-content tab-all-editors">
                <?php
                $active = ' in active';
                foreach ($languages as $lang) {

                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);

                    echo '<div id="' . $only_dir . '" class="tab-pane fade' . $active . '">'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<input type="text" class="form-control input-form article-title" placeholder="' . $this->lang->line('enter_article_title') . '" value="' . the_faq_article_title($only_dir) . '">'
                            . '</div>'
                        . '</div>'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<div id="summernote" class="summernote-body body-' . $only_dir . '" data-dir="body-' . $only_dir . '"></div>'
                                    . '<textarea class="article-body content-body-' . $only_dir . ' hidden">' . the_faq_article_body($only_dir) . '</textarea>'
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
                    <div class="row">
                        <div class="col-lg-6">
                            <select class="article-status">
                                <option value="1">
                                    <?php echo $this->lang->line('publish'); ?>
                                </option>
                                <option value="0">
                                    <?php echo $this->lang->line('draft'); ?>
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success save-article">
                                <?php echo $this->lang->line('save'); ?>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 categories-list">
                            <div class="form-group">
                                <div class="panel panel-default panel-classification">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <?php echo $this->lang->line('categories'); ?>
                                            </div>
                                            <div class="col-xs-2 text-right">
                                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#categories-popup-manager">
                                                    <i class="icon-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                            $categories = the_faq_categories();
                                            
                                            if ($categories) {

                                                echo '<ul class="list-group">';

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

                                                        $subcats = '<ul class="list-group">';

                                                        foreach ($subcategories[$cat->category_id] as $subcat) {

                                                            $checked = '';

                                                            if ( the_faq_article_category($subcat->category_id) ) {
                                                                $checked = ' checked';
                                                            }

                                                            $subcats .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                                                                . '<div class="row">'
                                                                    . '<div class="col-lg-12">'
                                                                        . '<div class="checkbox-option-select">'
                                                                            . '<input id="faq-category-' . $subcat->category_id . '" name="faq-category-' . $subcat->category_id . '" type="checkbox" data-id="' . $subcat->category_id . '"' . $checked . '>'
                                                                            . '<label for="faq-category-' . $subcat->category_id . '"></label>'
                                                                        . '</div>'
                                                                        . $subcat->name
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

                                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
                                                        . '<div class="row">'
                                                            . '<div class="col-lg-12">'
                                                                . '<div class="checkbox-option-select">'
                                                                    . '<input id="faq-category-' . $cat->category_id . '" name="faq-category-' . $cat->category_id . '" type="checkbox" data-id="' . $cat->category_id . '"' . $checked . '>'
                                                                    . '<label for="faq-category-' . $cat->category_id . '"></label>'
                                                                . '</div>'
                                                                . $cat->name
                                                            . '</div>'
                                                        . '</div>'
                                                        . $subcats
                                                    . '</li>';

                                                }

                                                echo '</ul>';
                                
                                            } else {

                                                echo '<p>' . $this->lang->line('no_categories_found') . '</p>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>