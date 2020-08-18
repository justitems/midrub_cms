<section>
    <div class="container-fluid users">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4 fl">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading">
                                <h2><i class="fa fa-users"></i> <?= $this->lang->line('ma97'); ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group search">
                                    <input type="text" placeholder="<?= $this->lang->line('ma99'); ?>" class="form-control search_user">
                                    <span class="input-group-btn search-m">
                                        <button class="btn" type="button"><i class="fa fa-binoculars"></i><i class="fa fa-times display-none"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>  
                        <div class="row user-item">      
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination"></ul>
                                <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="pull-right pageload">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 user-activity display-none">
                    <div class="col-lg-12 msg-body">
                        <div class="widget-box">
                            <div class="widget-header">
                                <div class="widget-toolbar">
                                    <ul class="nav nav-tabs">
                                        <li class="active"> <a data-toggle="tab" href="#posts" aria-expanded="true"><?= $this->lang->line('ma175'); ?></a> </li>
                                        <li> <a data-toggle="tab" href="#rss-feeds" aria-expanded="false"><?= $this->lang->line('ma46'); ?></a> </li>
                                        <li> <a data-toggle="tab" href="#emails" aria-expanded="false"><?= $this->lang->line('ma176'); ?></a> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="tab-content">
                                    <div id="posts" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list-group">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="pagination"></ul>
                                                <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="pull-right pageload">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rss-feeds" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list-group">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="pagination"></ul>
                                                <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="pull-right pageload">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="emails" class="tab-pane">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list-group">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="pagination"></ul>
                                                <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="pull-right pageload">
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
</section>