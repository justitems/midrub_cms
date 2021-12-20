
        </main>
        <footer class="text-muted">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <div class="theme-copyright">
                        THE CRM © 2021
                    </div>
                    <div class="theme-terms-menu">
                        <?php
                        md_get_frontend_menu(
                            'footer_menu',
                            array(
                                'before_menu' => '<ul>',
                                'before_single_item' => '<li><a href="[url]">[text]',
                                'after_single_item' => '</a></li>',
                                'after_menu' => '</ul>'
                            )
                        );
                        ?>
                    </div>
                    <div class="theme-social-menu">
                        <?php
                        md_get_frontend_menu(
                            'social_menu',
                            array(
                                'before_menu' => '<ul>',
                                'before_single_item' => '<li><a href="[url]"><i class="[class]"></i>',
                                'after_single_item' => '</a></li>',
                                'after_menu' => '</ul>'
                            )
                        );
                        ?>
                    </div>                                       
                </div>
            </div>
        </footer>

        <?php md_get_the_frontend_footer(); ?>
        <script src="<?php echo md_the_theme_uri(); ?>js/main.js?ver=0.1"></script>
    </body>
</html>