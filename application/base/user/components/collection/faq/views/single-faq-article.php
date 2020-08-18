<section class="single-faq-article">
    <div class="container-fluid">    
        <div class="row">
            <div class="col-xl-2 offset-xl-2">
                <ul class="nav nav-tabs">
                    <?php
                    $subcategories = array();

                    foreach ($categories as $category) {

                        if ( $category->parent > 0 ) {

                            $subcategories[$category->parent][] = $category;

                        }

                    }

                    $category = '';
                    $parent_name = '';

                    foreach ($categories as $cat) {

                        if ( $cat->category_id !== $category_id && $cat->parent !== $category_id && $cat->category_id !== $parent ) {
                            continue;
                        }
                        
                        if ( $cat->parent > 0 ) {
                            continue;
                        }                        

                        $subcats = '';

                        if ( isset($subcategories[$cat->category_id]) ) {

                            $subcats = '<ul class="list-group">';

                            foreach ( $subcategories[$cat->category_id] as $subcat ) {
                                
                                if ( $subcat->category_id === $category_id ) {
                                    
                                    $parent_name = $subcat->name;
                                    
                                }

                                $subcats .= '<li class="nav-item">'
                                                . '<a href="' . site_url('user/faq?p=categories&category=' . $subcat->category_id) . '">'
                                                    . $subcat->name
                                                . '</a>'
                                            . '</li>';

                            }

                            $subcats .= '</ul>';

                        }

                        $category = $cat->name;

                        echo '<li>'
                                . '<h3>'
                                    . $cat->name
                                . '</h3>'
                                . $subcats
                            . '</li>';

                    }
                    ?>
                </ul>
            </div>
            <div class="col-xl-6">
                <div class="settings-list">
                    <div class="tab-content">
                        <div class="tab-pane container fade active show" id="main-settings">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo site_url('user/faq') ?>"><?php echo $this->lang->line('support_center'); ?></a></li>
                                            <?php
                                            if ( $parent < 1 ) {
                                                ?>
                                                <li class="breadcrumb-item">
                                                    <a href="<?php echo site_url('user/faq?p=categories&category=' . $category_id) ?>">
                                                        <?php
                                                        echo $category;
                                                        ?>
                                                    </a>
                                                </li>
                                                <?php
                                            } else {
                                            ?>
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo site_url('user/faq?p=categories&category=' . $parent) ?>">
                                                    <?php
                                                    echo $category;
                                                    ?>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo site_url('user/faq?p=categories&category=' . $category_id) ?>">
                                                    <?php
                                                    echo $parent_name;
                                                    ?>
                                                </a>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                            <li class="breadcrumb-item">
                                                <?php
                                                    echo @$article['data'][$this->config->item('language')]['title'];
                                                ?>
                                            </li>                                            
                                        </ol>
                                    </nav>
                                </div>
                                <div class="panel-body">
                                    <div class="article">
                                        <h1 class="title">
                                            <?php
                                            echo @$article['data'][$this->config->item('language')]['title'];
                                            ?>
                                        </h1>
                                        <?php
                                        echo @htmlspecialchars_decode($article['data'][$this->config->item('language')]['body']);
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
</section>

<?php
get_the_file(MIDRUB_BASE_USER_COMPONENTS_FAQ . 'views/footer.php');
?>