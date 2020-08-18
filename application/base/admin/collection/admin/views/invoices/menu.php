<ul class="nav nav-pills nav-stacked labels-info">
    <li <?php echo $this->input->get('template', true)?' class="active"':''; ?>>
        <a href="<?php echo site_url('admin/admin?p=invoices&template=1') ?>">
            <i class="fas fa-receipt"></i>
            <?php echo $this->lang->line('admin_template'); ?>
        </a>
    </li>
    <li <?php echo $this->input->get('faq', true)?' class="active"':''; ?>>
        <a href="<?php echo site_url('admin/admin?p=invoices&faq=1') ?>">
            <i class="far fa-question-circle"></i>
            <?php echo $this->lang->line('admin_faq'); ?>
        </a>
    </li>
</ul>