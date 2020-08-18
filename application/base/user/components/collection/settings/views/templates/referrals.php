<div class="settings-list theme-box">
    <div class="tab-content">
        <div class="tab-pane container fade active show" id="referrals">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <svg class="bi bi-card-checklist" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                        <path fill-rule="evenodd" d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    <?php echo $this->lang->line('referrals'); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="input-group">
                                <h4><?php echo $this->lang->line('share_referrals_link'); ?></h4>
                                <p>
                                    <?php echo $this->lang->line('you_will_earn_will earn_a_commission'); ?>
                                </p>
                                <input type="text" class="form-control" value="<?php echo base_url() . '?ref=' . str_replace('=', '', base64_encode($this->user_id)); ?>">
                                <div class="input-group-append">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(base_url() . '?ref=' . str_replace('=', '', base64_encode($this->user_id))); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" class="btn btn-default" title="Share on Facebook">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/share?url=<?php echo urlencode(base_url() . '?ref=' . str_replace('=', '', base64_encode($this->user_id))); ?>&via=TWITTER_HANDLE" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" class="btn btn-default btn-twitter" target="_blank" title="Share on Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(base_url() . '?ref=' . str_replace('=', '', base64_encode($this->user_id))); ?>&source=LinkedIn
                    " onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" class="btn btn-default btn-linkedin" target="_blank" title="Share on Twitter">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-xl-4 referral-single-stats">
                            <div class="col-xl-12">
                                <h3><?php echo (the_global_variable('user_referral_stats')) ? the_global_variable('user_referral_stats')->signups : '0'; ?></h3>
                                <p><?php echo $this->lang->line('total_signups'); ?></p>
                            </div>
                        </div>
                        <div class="col-xl-4 referral-single-stats">
                            <div class="col-xl-12">
                                <h3><?php echo (the_global_variable('user_referral_stats')->total_paid) ? the_global_variable('user_referral_stats')->total_paid . ' ' . the_global_variable('user_referral_stats')->currency_code : '0'; ?></h3>
                                <p><?php echo $this->lang->line('total_paid'); ?></p>
                            </div>
                        </div>
                        <div class="col-xl-4 referral-single-stats">
                            <div class="col-xl-12">
                                <h3><?php echo (the_global_variable('user_referral_stats')->total_unpaid) ? the_global_variable('user_referral_stats')->total_unpaid . ' ' . the_global_variable('user_referral_stats')->currency_code : '0'; ?></h3>
                                <p><?php echo $this->lang->line('total_unpaid'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>