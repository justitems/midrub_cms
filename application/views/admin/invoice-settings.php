<section>
    <div class="container-fluid invoice-settings">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <div class="widget-toolbar">
                                <ul class="nav nav-tabs">
                                    <li class="active"> <a data-toggle="tab" href="#invoice" class="reload-invoice" aria-expanded="true"><?= $this->lang->line('ma190'); ?></a> </li>
                                    <li> <a data-toggle="tab" href="#settings" aria-expanded="false"><?= $this->lang->line('ma7'); ?></a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="tab-content">
                                    <div id="invoice" class="tab-pane active">
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
                                                                                        <img alt="logo" class="invoice-logo" src="<?= get_option('main-logo'); ?>">
                                                                                    </td>   
                                                                                    <td width="40" align="center" valign="top">&nbsp;</td>
                                                                                    <td align="right">
                                                                                        <span style="padding-top:15px;padding-bottom:10px;font:italic 12px;color:#757575;line-height:15px;">
                                                                                            <span style="display:inline;">
                                                                                                <span class="invoice-billing-period"></span> <strong><span class="invoice-date-format"></span> <?= $this->lang->line('ma205'); ?> <span class="invoice-date-format"></span></strong>
                                                                                            </span>
                                                                                            <span style="display:inline;">
                                                                                                <br>
                                                                                                <span class="invoice-transaction-id"></span>: <strong>################</strong>
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
                                                                                                            <td style="text-align:left;padding:10px;" width="10%" class="invoice-date-format">
                                                                                                            </td>                                                                                                            
                                                                                                            <td style="padding:10px;" width="80%">
                                                                                                                <span class="invoice-description-text"></span>
                                                                                                                <br>

                                                                                                                <span style="display:inline;font-style: italic;color: #888888;">
                                                                                                                    Plan Name
                                                                                                                </span>
                                                                                                            </td>
                                                                                                            <td style="text-align:right;padding:10px;" width="10%">
                                                                                                                0.00
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
                                                                                                                            <td style="width:20%;text-align:right;padding:0 10px 10px 0;">
                                                                                                                                0.00
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
                                    <div id="settings" class="tab-pane">
                                        <div class="setrow" id="invoice-logo">
                                            <div class="image-head-title"><h3><?= $this->lang->line('ma191'); ?></h3></div>
                                            <p class="preview"><?php if ( get_option('invoice-logo') ) echo '<img src="' . get_option('invoice-logo') . '" class="thumbnail" />'; ?></p>
                                            <p><a class="btn btn-default invoice-logo" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                            <div class="error-upload"></div>
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma203'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-billing-period" value="<?php if ( get_option('invoice-billing-period') ): echo get_option('invoice-billing-period'); else: echo 'Billing Period'; endif; ?>" placeholder="Billing Period">
                                                </div>
                                            </div>                                        
                                        </div>    
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma204'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-transaction-id" value="<?php if ( get_option('invoice-transaction-id') ): echo get_option('invoice-transaction-id'); else: echo 'Transaction ID'; endif; ?>" placeholder="Transaction ID">
                                                </div>
                                            </div>                                        
                                        </div>                                        
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma192'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-date-format" value="<?php if ( get_option('invoice-date-format') ): echo get_option('invoice-date-format'); else: echo 'dd-mm-yyyy'; endif; ?>" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma193'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-hello-text" value="<?php if ( get_option('invoice-hello-text') ): echo get_option('invoice-hello-text'); else: echo 'Hello [username]'; endif; ?>" placeholder="Hello Username">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow text-area">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma194'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <textarea class="optionvalue" id="invoice-message" placeholder="Thanks for using using our services."><?php if ( get_option('invoice-message') ): echo get_option('invoice-message'); else: echo 'Thanks for using using our services.'; endif; ?></textarea>
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma195'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-date" value="<?php if ( get_option('invoice-date') ): echo get_option('invoice-date'); else: echo 'Date'; endif; ?>" placeholder="Date Word">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma196'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-description" value="<?php if ( get_option('invoice-description') ): echo get_option('invoice-description'); else: echo 'Description'; endif; ?>" placeholder="Description Word">
                                                </div>
                                            </div>                                        
                                        </div> 
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma197'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-amount" value="<?php if ( get_option('invoice-amount') ): echo get_option('invoice-amount'); else: echo 'Amount'; endif; ?>" placeholder="Amount Word">
                                                </div>
                                            </div>                                        
                                        </div>  
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma198'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-description-text" value="<?php if ( get_option('invoice-description-text') ): echo get_option('invoice-description-text'); else: echo 'Upgrade Payment'; endif; ?>" placeholder="Upgrade Payment">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma199'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-taxes" value="<?php if ( get_option('invoice-taxes') ): echo get_option('invoice-taxes'); else: echo 'Taxes'; endif; ?>" placeholder="Taxes Word">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma200'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-taxes-value" value="<?php if ( get_option('invoice-taxes-value') ): echo get_option('invoice-taxes-value'); else: echo '0'; endif; ?>" placeholder="0">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma201'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <input type="text" class="optionvalue" id="invoice-total" value="<?php if ( get_option('invoice-total') ): echo get_option('invoice-total'); else: echo 'Total'; endif; ?>" placeholder="Total Word">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="setrow text-area">
                                            <div class="col-lg-10 col-sm-9 col-xs-9"><div class="image-head-title"><?= $this->lang->line('ma202'); ?></div></div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 text-right">
                                                <div class="enablus pull-right">
                                                    <textarea class="optionvalue" id="invoice-no-reply" placeholder="No Reply Text"><?php if ( get_option('invoice-no-reply') ): echo get_option('invoice-no-reply'); else: echo 'Please do not reply to this email. This mailbox is not monitored and you will not receive a response. For assistance, please contact us to info@ouremail.com.'; endif; ?></textarea>
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
        </div>
    </div>
    <!--upload media form !-->
    <div class="hidden">
        <?php
        $attributes = array('class' => 'upmedia', 'method' => 'post');
        echo form_open_multipart('admin/invoice-settings', $attributes);
        ?>
        <input type="file" name="file" id="file">
        <input type="text" name="media-name" id="media-name">
        <?php
        echo form_close();
        ?>
    </div>
</section>
