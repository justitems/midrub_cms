<div class="theme-quick-guide">
    <div class="row">
        <div class="col-12">
            <a href="#" class="theme-toggle-quick-guide">
                <?php echo md_the_user_icon(array('icon' => 'information')); ?>
                <?php echo md_the_user_icon(array('icon' => 'close_fill')); ?>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <h3 class="theme-quick-guide-header">
                <?php echo $this->lang->line('crm_dashboard_quick_guide'); ?>
            </h3>
        </div>
        <div class="col-2 text-right">
            <a href="#" class="theme-quick-guide-go-back">
                <?php echo md_the_user_icon(array('icon' => 'arrow_left')); ?>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="list-group theme-quick-guide-categories">
            </div>                  
        </div>
    </div>   
    <div class="row">
        <div class="col-12">
            <div class="list-group theme-quick-guide-articles"></div>                                            
        </div>
    </div>                          
</div>