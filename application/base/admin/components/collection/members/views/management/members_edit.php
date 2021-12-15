<div class="row pt-3">
    <div class="col-md-6">
    <?php

    // Get the members fields
    $members_fields = the_admin_members_fields();

    md_get_admin_fields(array(

        'header' => array(
            'title' => md_the_admin_icon(array('icon' => 'member_add'))
            . $this->lang->line('members_new_member')
        ),

        'fields' => $members_fields

    )); 

    ?>
    </div>
    <div class="col-md-6">
        <?php

        // Get member's tabs
        $member_tabs = the_admin_members_member_tabs();

        // Verify if at least a tab exists
        if ( $member_tabs ) {
        ?>
        <div class="panel panel-member-information panel-default" data-member="<?php echo $this->input->get('member', true); ?>">
            <div class="panel-heading theme-tabs">
                <ul class="nav nav-tabs">
                    <?php 
                    
                    // List tabs
                    foreach ( $member_tabs AS $tab_slug => $args ) {

                        // Default active
                        $active = '';

                        // Default expanded
                        $expanded = 'false';

                        // Verify if is the first tab
                        if ( $tab_slug === array_key_first($member_tabs) ) {

                            // Set active
                            $active = ' active';

                            // Set expanded
                            $expanded = 'true';

                        }

                        ?>
                        <li class="nav-item">
                            <a href="#members-member-tab-<?php echo $tab_slug; ?>" class="nav-link<?php echo $active; ?>" aria-expanded="<?php echo $expanded; ?>" data-bs-toggle="tab">
                                <?php echo $args['tab_icon']; ?>
                                <?php echo $args['tab_name']; ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="panel-body affiliates-reports">
                <div class="tab-content">
                    <?php 
                    
                    // List tabs
                    foreach ( $member_tabs AS $tab_slug => $args ) {

                        // Default active
                        $active = '';

                        // Verify if is the first tab
                        if ( $tab_slug === array_key_first($member_tabs) ) {

                            // Set active
                            $active = ' show active';

                        }

                        ?>
                            <div id="members-member-tab-<?php echo $tab_slug; ?>" class="tab-pane fade<?php echo $active; ?>">
                                <?php echo $args['tab_content']; ?>
                            </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>    
</div>