<section class="teams-page">
    <?php
    if (team_members_total() >= plan_feature('teams')) {
        ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="reached-plan-limit">
                <div class="row">
                    <div class="col-xl-9">
                        <i class="icon-info"></i>
                        <?php echo $this->lang->line('reached_maximum_number_allowed_members'); ?>
                    </div>
                    <div class="col-xl-3 text-right">
                        <a href="<?php echo site_url('user/plans') ?>" class="btn"><i class="icon-basket"></i> <?php echo $this->lang->line('our_plans'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <h1 class="page-title">
                <?php echo $this->lang->line('my_team'); ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <?php get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/menu.php'); ?>
        <div class="col-xl-6">
            <?php get_the_user_team_page_content($template); ?>
        </div>
    </div>
</section>