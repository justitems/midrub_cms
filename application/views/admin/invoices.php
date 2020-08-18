<section>
    <div class="container-fluid invoices">
        <div class="row">
            <div class="col-lg-6">
                <div id="filter-panel" class="filter-panel search-options">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= form_open('admin/invoices/1', ['class' => 'search-invoices']) ?>
                                <div class="col-lg-3 clean">
                                    <input type="text" class="form-control input-sm search-by-user" id="pref-search" placeholder="<?= $this->lang->line('ma99'); ?>">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control input-sm from-date" id="pref-search" placeholder="From date">                               
                                </div>
                                <div class="col-lg-3 clean">
                                    <input type="text" class="form-control input-sm to-date" id="pref-search" placeholder="To date">                              
                                </div>
                                <div class="col-lg-3">
                                    <a href="<?= base_url( 'admin/invoice-settings' ); ?>" class="btn btn-primary"><i class="fa fa-cog"></i> <?= $this->lang->line('ma190'); ?></a>                              
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <p class="no-invoices-found"><br>No invoices found.</p>
                        <table id="mytable" class="table table-bordred table-striped">
                            <thead>
                            <th><?= $this->lang->line('ma206'); ?></th>
                            <th><?= $this->lang->line('ma104'); ?></th>
                            <th><?= $this->lang->line('ma207'); ?></th>
                            <th><?= $this->lang->line('ma208'); ?></th>
                            <th><?= $this->lang->line('ma209'); ?></th>
                            <th><?= $this->lang->line('ma13'); ?></th>
                            <th><?= $this->lang->line('ma12'); ?></th>
                            </thead>
                            <tbody class="all-invoices">
                                
                            </tbody>

                        </table>

                        <div class="clearfix"></div>
                        <ul class="pagination">
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 invoice-details">
                <div class="col-lg-12">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody><tr><td align="center" width="600" valign="top">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="top" bgcolor="#ffffff">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;" width="100%">
                                                        <tbody><tr valign="bottom">    
                                                                <td width="20" align="center" valign="top">&nbsp;</td>
                                                                <td align="left" height="64">
                                                                    <img alt="logo" class="invoice-logo">
                                                                </td>   
                                                                <td width="40" align="center" valign="top">&nbsp;</td>
                                                                <td align="right">
                                                                    <span style="padding-top:15px;padding-bottom:10px;font:italic 12px;color:#757575;line-height:15px;">
                                                                        <span style="display:inline;">
                                                                            <span class="invoice-billing-period"></span> <strong><span class="invoice-date-format billing-period-from"></span> <?= $this->lang->line('ma205'); ?> <span class="invoice-date-format billing-period-to"></span></strong>
                                                                        </span>
                                                                        <span style="display:inline;">
                                                                            <br>
                                                                            <span class="invoice-transaction-id"></span>: <strong class="transaction-id">################</strong>
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                                <td width="20" align="center" valign="top">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px;padding-top:10px;margin-bottom:20px;" width="100%">
                                                        <tbody><tr valign="bottom">    
                                                                <td width="20" align="center" valign="top">&nbsp;</td>
                                                                <td valign="top" style="font-family:Calibri, Trebuchet, Arial, sans serif;font-size:15px;line-height:22px;color:#333333;" class="yiv1811948700ppsans">
                                                                    <p>
                                                                    </p><div style="margin-top:30px;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;"><span style="color:#333333;font-weight:bold;font-family:arial, helvetica, sans-serif;" class="invoice-hello-text"></span><table><tbody><tr><td valign="top" class="invoice-message"></td><td></td></tr></tbody></table><br><div style="margin-top:5px;">
                                                                            <br><div class="yiv1811948700mpi_image" style="margin:auto;clear:both;">
                                                                            </div>
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="clear:both;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;margin-top:20px;" width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="text-align:left;border:1px solid #ccc;border-right:none;border-left:none;padding:5px 10px 5px 10px !important;color:#333333;" class="invoice-date" width="10%">
                                                                                        </td>
                                                                                        <td style="border:1px solid #ccc;border-right:none;border-left:none;padding:5px 10px 5px 10px !important;color:#333333;" width="80%" class="invoice-description">
                                                                                        </td>
                                                                                        <td style="text-align:right;border:1px solid #ccc;border-right:none;border-left:none;padding:5px 10px 5px 10px !important;color:#333333;" width="10%" class="amount">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="text-align:left;padding:10px;" width="10%" class="invoice-date-format invoice-created-date">
                                                                                        </td>                                                                                                            
                                                                                        <td style="padding:10px;" width="80%">
                                                                                            <span class="invoice-description-text"></span>
                                                                                            <br>

                                                                                            <span style="display:inline;font-style: italic;color: #888888;" class="invoice-plan-name">
                                                                                            </span>
                                                                                        </td>
                                                                                        <td style="text-align:right;padding:10px;" width="10%" class="invoice-amount">
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #ccc;border-bottom:1px solid #ccc;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;margin-bottom:10px;" width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;color:#333;font-family:arial, helvetica, sans-serif;font-size:12px;margin-top:10px;">
                                                                                                <tbody>
                                                                                                    <tr class="taxes-area">
                                                                                                        <td style="width:80%;text-align:right;padding:0 10px 10px 0;" class="invoice-taxes">
                                                                                                        </td>
                                                                                                        <td style="width:20%;text-align:right;padding:0 10px 10px 0;">
                                                                                                            <span style="display:inline;" class="invoice-taxes-value">
                                                                                                            </span>

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="width:80%;text-align:right;padding:0 10px 10px 0;">
                                                                                                            <span style="color:#333333;font-weight:bold;" class="invoice-total">
                                                                                                            </span>
                                                                                                        </td>
                                                                                                        <td style="width:20%;text-align:right;padding:0 10px 10px 0;" class="invoice-total-value">
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody></table>
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody></table>
                                                                            <span style="font-size:11px;color:#333;" class="invoice-no-reply"></span></div>
                                                                        <span style="font-weight:bold;color:#444;">
                                                                        </span>
                                                                        <span>
                                                                        </span>
                                                                    </div></td>
                                                                    <td width="20" align="center" valign="top">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>            
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
