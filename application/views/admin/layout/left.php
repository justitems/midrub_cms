<nav>
    <ul>
        <li<?php if ($this->router->fetch_method() == 'dashboard') echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/home') ?>">
                <i class="icon-speedometer"></i><br>
                <?php echo $this->lang->line('ma1'); ?>
            </a>
        </li>          
        <li<?php if (($this->router->fetch_method() == 'notifications')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/notifications') ?>">
                <i class="icon-bell"></i><br>
                <?php echo $this->lang->line('ma2'); ?>
            </a>
        </li>
        <li<?php if (($this->router->fetch_method() == 'users') || ($this->router->fetch_method() == 'new_user')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/users') ?>">
                <i class="icon-people"></i><br>
                <?php echo $this->lang->line('ma3'); ?>
            </a>
        </li>
        <li<?php if ( function_exists('md_the_component_variable') ): if ( md_the_component_variable('component_slug') === 'frontend' ): echo ' class="active"'; endif; endif; ?>>
            <a href="<?php echo site_url('admin/frontend') ?>">
                <i class="icon-note"></i><br>
                <?php echo $this->lang->line('frontend'); ?>
            </a>
        </li>
        <li<?php if ( function_exists('md_the_component_variable') ): if ( md_the_component_variable('component_slug') === 'user' ): echo ' class="active"'; endif; endif; ?>>
            <a href="<?php echo site_url('admin/user') ?>">
                <i class="icon-user"></i><br>
                <?php echo $this->lang->line('ma104'); ?>
            </a>
        </li>
        <li<?php if ( function_exists('md_the_component_variable') ): if ( md_the_component_variable('component_slug') === 'admin' ): echo ' class="active"'; endif; endif; ?>>
            <a href="<?php echo site_url('admin/admin') ?>">
                <i class="icon-user-follow"></i><br>
                <?php echo $this->lang->line('ma105'); ?>
            </a>
        </li>             
        <li<?php if ( function_exists('md_the_component_variable') ): if ( md_the_component_variable('component_slug') === 'settings' ): echo ' class="active"'; endif; endif; ?>>
            <a href="<?php echo site_url('admin/settings') ?>">
                <i class="icon-settings"></i><br>
                <?php echo $this->lang->line('ma7'); ?>
            </a>
        </li>
    </ul>
</nav>