<div class="row">
   <div class="col-lg-12">
      <div class="panel panel-default themes-directory">
         <div class="panel-heading">
            <div class="row">
               <div class="col-lg-12">
                  <ul class="nav nav-tabs nav-justified">
                     <li class="active">
                        <a data-toggle="tab" href="#theme-install">
                           <?php echo $this->lang->line('frontend_install'); ?>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="tab-content tab-all-editors">
               <div id="theme-install" class="tab-pane fade in active">
                  <div class="row">
                     <div class="col-lg-12">
                        <a href="#" class="btn-option select-theme">
                           <i class="fas fa-upload"></i>
                           <?php echo $this->lang->line('frontend_upload_theme'); ?>
                        </a>
                     </div>
                  </div>
                  <div class="modal-footer hidden">
                     <?php
                     $attributes = array('class' => 'upload-theme', 'id' => 'upload-theme', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name());
                        echo form_open_multipart('admin/frontend?p=themes&directory=1&group=frontend_page', $attributes);
                        ?>
                        <input type="file" name="file[]" id="file" accept=".zip">
                     <?php echo form_close(); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="theme-installation" tabindex="-1" role="dialog" aria-labelledby="theme-installation-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="theme-installation-label">
                    <?php echo $this->lang->line('frontend_installation_process'); ?>
                </h4>
            </div>
            <div class="modal-body">
               <p>
                  <?php echo $this->lang->line('frontend_installation_process'); ?>
               </p>
               <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        0%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>