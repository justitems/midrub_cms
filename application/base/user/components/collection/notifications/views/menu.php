<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="<?php echo site_url('user/notifications?p=notifications') ?>" class="nav-link<?php echo ($page === 'notifications')?' active show':''; ?>">
            <i class="icon-general"></i>
            <?php
            echo $this->lang->line('notifications_general');
            ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo site_url('user/notifications?p=errors') ?>" class="nav-link<?php echo ($page === 'errors')?' active show':''; ?>">
            <i class="icon-error"></i>
            <?php
            echo $this->lang->line('notifications_errors');
            ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo site_url('user/notifications?p=offers') ?>" class="nav-link<?php echo ($page === 'offers')?' active show':''; ?>">
            <i class="icon-offers"></i>
            <?php
            echo $this->lang->line('notifications_offers');
            ?>
        </a>
    </li>
</ul>