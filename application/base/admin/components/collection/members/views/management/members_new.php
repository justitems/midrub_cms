<div class="row pt-3">
    <div class="col-md-6 offset-md-3">
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
</div>