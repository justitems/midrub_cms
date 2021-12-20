<div class="theme-page-faq-featured-articles">
    <div class="row">
        <div class="col-12">
            <h3>
                <?php md_get_the_string('theme_featured_articles'); ?>
            </h3>                            
        </div>
    </div>   
    <div class="row">
        <div class="col-12">
            <span class="theme-separator"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <ul class="list-group theme-articles-list">
                <?php

                // Get last articles
                $last = the_last_articles();

                if ($last) {

                    foreach ($last as $article) {

                        echo '<li class="list-group-item">'
                            . '<a href="' . site_url($article['contents_slug']) . '" class="list-group-item-action">'
                                . $article['meta_value']
                            . '</a>'
                        . '</li>';

                    }

                }

                ?>                                        
            </ul>                                        
        </div>
    </div>                                                                
</div>