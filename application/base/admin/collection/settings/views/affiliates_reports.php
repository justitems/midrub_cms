<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-1">
                <div class="row">
                    <div class="col-lg-12">  
                        <?php md_include_component_file( MIDRUB_BASE_ADMIN_SETTINGS . 'views/menu.php' ); ?>
                    </div>
                </div>                        
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 settings-area">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#reports">
                                            <i class="fas fa-file-invoice"></i>
                                            <?php echo $this->lang->line('reports'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#payments">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                            <?php echo $this->lang->line('payments'); ?>
                                        </a>
                                    </li>                                   
                                </ul>
                            </div>
                            <div class="panel-body affiliates-reports">
                                <div class="tab-content">
                                    <div id="reports" class="tab-pane fade in active">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">
                                                        <input type="text" class="from-date" placeholder="<?php echo $this->lang->line('from_date'); ?>">
                                                        <input type="text" class="to-date" placeholder="<?php echo $this->lang->line('to_date'); ?>">
                                                        <button type="button" class="btn-option btn-show-referrals">
                                                            <i class="fas fa-binoculars"></i> <?php echo $this->lang->line('show'); ?>
                                                        </button>  
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3">
                                                        <ul class="pagination" data-type="referral-reports">
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div id="payments" class="tab-pane fade">
                                        <table class="table">
                                            <thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3">
                                                        <ul class="pagination" data-type="referral-referrers">
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php md_include_component_file( MIDRUB_BASE_ADMIN_SETTINGS . 'views/footer.php' ); ?>