<main role="main" class="main">
    <section class="single-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">
                        <?php
                            echo md_the_single_content_meta('content_title');
                        ?>
                    </h1>
                    <?php
                        echo md_the_single_content_meta('content_body');
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>