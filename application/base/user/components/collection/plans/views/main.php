<section class="plans-page">
    <div class="container-fluid">
        <?php
        if($upgrade) {
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="reached-plan-limit">
                    <div class="row">
                        <div class="col-xl-9">
                            <i class="icon-info"></i>
                            <?php echo $upgrade; ?> 
                        </div>
                        <div class="col-xl-3 text-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }

        // Get plans
        $plans = the_visible_plans();   
        
        // Verify if is not a group
        if ( empty($plans[0]['plans']) ) {

            echo '<div class="row">';

            $col = 12 / count($plans);

            foreach ($plans as $plan) {
                ?>
                <div class="col-xl-<?php echo $col; ?> col-xs-12">
                    <div class="col-xl-12">
                        <div class="panel theme-box panel-success <?php echo str_replace(' ', '-', strtolower($plan['plan_name'])) ?>">
                            <div class="panel-heading">
                                <h3><?php echo $plan['plan_name'] ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="the-price">
                                    <h1><?php echo $plan['currency_sign'] ?> <?php echo $plan['plan_price'] ?></h1>
                                </div>
                                <table class="table">
                                    <?php
                                    if ($plan['features']) {
                                        $features = explode("\n", $plan['features']);
                                        foreach ($features as $feature) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $feature ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <div class="panel-footer">
                                <?php
                                $cplan = 1;
                                $plan_end = time() + 86400;
                                if ( $user_plan ) {

                                    foreach ( $user_plan as $up ) {

                                        if ( $up->meta_name == 'plan' ) {

                                            $cplan = $up->meta_value;

                                        }

                                        if ( $up->meta_name == 'plan_end' ) {

                                            $plan_end = strtotime($up->meta_value);

                                        }

                                    }

                                }

                                if ( ( $cplan != $plan['plan_id'] ) || ( ( $plan_end + 864000) < time() ) ) {
                                    ?>
                                    <a href="<?php echo ($plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $plan['plan_id']); ?>" class="btn btn-success <?php echo str_replace(' ', '-', strtolower($plan['plan_name'])) ?>" role="button">
                                        <?php echo $this->lang->line('plans_order_now'); ?>
                                    </a>
                                    <?php
                                } elseif ( ( ( $plan_end + 864000) > time() ) && ( ( $plan_end - 432000 ) < time() ) ) { 
                                    ?>
                                    <a href="<?php echo ($plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $plan['plan_id']); ?>" class="btn btn-default" role="button">
                                        <?php echo $this->lang->line('plans_renew_current_plan'); ?>
                                    </a>                        
                                    <?php 
                                } else {
                                    ?>
                                    <a href="#" class="btn btn-default disabled" role="button">
                                        <?php echo $this->lang->line('plans_current_plan'); ?>
                                    </a>
                                    <?php 
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

            }

            echo '</div>';

        } else if ( !empty($plans[0]['plans']) ) {        
            ?>
            <div class="row">
                <div class="col-12">
                    <?php
                    
                        // Set nav start
                        echo '<ul class="nav justify-content-center" id="plans-tab" role="tablist">';

                        // Set groups
                        $groups = $plans;

                        // List groups
                        foreach ( $groups as $group ) {

                            // Nav active
                            $nav_active = ( $groups[0]['group_id'] === $group['group_id'] )?' active':'';

                            // Set nav's item
                            echo '<li class="theme-box nav-item">'
                                    . '<a class="nav-link' . $nav_active . '" id="tab-' . $group['group_id'] . '-tab" data-toggle="tab" href="#tab-' . $group['group_id'] . '" role="tab" aria-controls="tab-' . $group['group_id'] . '" aria-selected="true">'
                                        . $group['group_name']
                                    . '</a>'
                                . '</li>';


                        }

                        echo '</ul>';
                    
                    ?>
                </div>
            </div>
            <?php

            // Set tabs
            echo '<div class="tab-content" id="plans-tabs-parent">';

            // Set groups
            $groups = $plans;

            // List groups
            foreach ( $groups as $group ) {

                // Tab active
                $tab_active = ( $groups[0]['group_id'] === $group['group_id'] )?' show active':'';

                // Set Tab Start
                echo '<div class="tab-pane fade' . $tab_active . '" id="tab-' . $group['group_id'] . '" role="tabpanel" aria-labelledby="tab-' . $group['group_id'] . '-tab">';

                // Set row
                echo '<div class="row">';

                // Get group's plans
                $plans = $group['plans'];

                // Default column
                $column = 4;

                // Verify if column is not default
                if ( count($plans) === 1 ) {
                    $column = 12;
                } else if ( count($plans) === 2 ) {
                    $column = 6;
                } else if ( count($plans) === 4 ) {
                    $column = 3;
                } else if ( count($plans) === 5 ) {
                    $column = 2;
                }

                // List all plans
                foreach ( $plans as $plan ) {
                    ?>
                    <div class="col-xl-<?php echo $column; ?> col-xs-12">
                        <div class="col-xl-12">
                            <div class="panel theme-box panel-success <?php echo str_replace(' ', '-', strtolower($plan['plan_name'])) ?>">
                                <div class="panel-heading">
                                    <h3><?php echo $plan['plan_name']; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="the-price">
                                        <h1><?php echo $plan['currency_sign']; ?> <?php echo $plan['plan_price']; ?></h1>
                                    </div>
                                    <table class="table">
                                        <?php
                                        if ($plan['features']) {
                                            $features = explode("\n", $plan['features']);
                                            foreach ($features as $feature) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $feature ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <?php
                                    $cplan = 1;
                                    $plan_end = time() + 86400;
                                    if ( $user_plan ) {

                                        foreach ( $user_plan as $up ) {

                                            if ( $up->meta_name == 'plan' ) {

                                                $cplan = $up->meta_value;

                                            }

                                            if ( $up->meta_name == 'plan_end' ) {

                                                $plan_end = strtotime($up->meta_value);

                                            }

                                        }

                                    }

                                    if ( ( $cplan != $plan['plan_id'] ) || ( ( $plan_end + 864000) < time() ) ) {
                                        ?>
                                        <a href="<?php echo ($plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $plan['plan_id']); ?>" class="btn btn-success <?php echo str_replace(' ', '-', strtolower($plan['plan_name'])) ?>" role="button">
                                            <?php echo $this->lang->line('plans_order_now'); ?>
                                        </a>
                                        <?php
                                    } elseif ( ( ( $plan_end + 864000) > time() ) && ( ( $plan_end - 432000 ) < time() ) ) { 
                                        ?>
                                        <a href="<?php echo ($plan['plan_price'] < 1)?site_url('user/plans?p=upgrade&plan=' . $plan['plan_id']):site_url('user/plans?p=coupon-code&plan=' . $plan['plan_id']); ?>" class="btn btn-default" role="button">
                                            <?php echo $this->lang->line('plans_renew_current_plan'); ?>
                                        </a>                        
                                        <?php 
                                    } else {
                                        ?>
                                        <a href="#" class="btn btn-default disabled" role="button">
                                            <?php echo $this->lang->line('plans_current_plan'); ?>
                                        </a>
                                        <?php 
                                    } 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                
                }

                // End row
                echo '</div>';

                // Set Tab End
                echo '</div>';

            }

            // Set Tabs End
            echo '</div></div>';

        }
        ?>
    </div>
</section>