<div class="row">
   <div class="col-lg-12">
      <div class="panel panel-default components-directory">
         <div class="panel-heading">
            <div class="row">
               <div class="col-lg-12">
                  <ul class="nav nav-tabs nav-justified">
                     <li class="active">
                        <a data-toggle="tab" href="#component-install">
                           <?php echo $this->lang->line('user_install'); ?>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="tab-content tab-all-editors">
               <div id="component-install" class="tab-pane fade in active">
                  <div class="row">
                     <div class="col-lg-12">
                        <a href="#" class="btn-option select-component">
                           <i class="fas fa-upload"></i>
                           <?php echo $this->lang->line('user_upload_component'); ?>
                        </a>
                     </div>
                  </div>
                  <div class="modal-footer hidden">
                     <?php
                     $attributes = array('class' => 'upload-component', 'id' => 'upload-component', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name());
                     echo form_open_multipart('admin/user?p=components&directory=1', $attributes);
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
<div class="modal fade" id="component-installation" tabindex="-1" role="dialog" aria-labelledby="component-installation-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="component-installation-label">
                    <?php echo $this->lang->line('user_installation_process'); ?>
                </h4>
            </div>
            <div class="modal-body">
               <p>
                  <?php echo $this->lang->line('user_installation_process'); ?>
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