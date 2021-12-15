<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <div class="row">
                    <div class="col-lg-12 settings-area">
                        <div class="card theme-card-box">
                            <div class="card-header border-0 theme-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="#settings-tab-reports" class="nav-link active" data-bs-toggle="tab">
                                            <i class="fas fa-file-invoice"></i>
                                            <?php echo $this->lang->line('reports'); ?>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings-tab-payments" class="nav-link" data-bs-toggle="tab">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                            <?php echo $this->lang->line('payments'); ?>
                                        </a>
                                    </li>                                   
                                </ul>
                            </div>
                            <div class="card-body settings-affiliates-reports">
                                <div class="tab-content">
                                    <div id="settings-tab-reports" class="tab-pane fade show active">
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
                                    <div id="settings-tab-payments" class="tab-pane fade">
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
</div>