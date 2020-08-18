<div class="settings-list theme-box">
    <div class="tab-content">
        <div class="tab-pane container fade active show" id="invoices">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <svg class="bi bi-grid-1x2" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6 1H1v14h5V1zm9 0h-5v5h5V1zm0 9h-5v5h5v-5zM0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm1 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1h-5z"/>
                    </svg>
                    <?php echo $this->lang->line('invoices'); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="settings-list-invoices">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-12">
                            <ul class="pagination" data-type="settings-invoices"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>