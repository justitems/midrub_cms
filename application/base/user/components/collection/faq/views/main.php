<section class="faq-page">
    
    <div class="container-fluid">    
        <div class="faq-page-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <div class="row">
                <div class="col-12">
                    <h2>
                        <?php echo $this->lang->line('how_can_we_help_you'); ?>
                    </h2>
                </div>
                <div class="col-xl-4 offset-xl-4 col-lg-10 offset-lg-1 col-10 offset-1">
                    <div class="custom-search-input">
                        <?php echo form_open('user/faq-page', array('class' => 'search-articles-form', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="icon-magnifier"></i>
                            </div>
                            <input type="text" class="search-articles form-control" placeholder="<?php echo $this->lang->line('search_the_knowledge_base'); ?>" />
                            <button type="button" class="cancel-search-for-articles">
                                <i class="icon-close"></i>
                            </button>
                            <div class="search-results">
                                <ul class="list-unstyled result-bucket">
                                </ul>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card-deck mb-3 row text-center">
                <?php
                if ( $categories ) {

                    foreach ($categories as $category) {

                        if ( $category->parent > 0 ) {
                            continue;
                        }
                        
                        echo '<div class="col-md-4 col-sm-12 col-12">'
                            . '<div class="card mb-4 shadow-sm">'
                                . '<div class="card-body">'
                                    . '<a href="' . site_url('user/faq?p=categories&category=' . $category->category_id) . '">' . $category->name . '</a>'
                                . '</div>'
                            . '</div>'
                        . '</div>';
                        
                    }

                }
                ?>
            </div>

        </div>
    </div>
</section>

<?php
get_the_file(MIDRUB_BASE_USER_COMPONENTS_FAQ . 'views/footer.php');
?>