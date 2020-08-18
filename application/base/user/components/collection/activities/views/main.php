<section class="activities-page">
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12 activities-page-header" data-name="<?php echo $this->security->get_csrf_token_name(); ?>" data-value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="theme-box p-3 my-3">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="dropdown d-inline">
                                    <a class="btn btn-secondary dropdown-toggle filter-members-btn" href="#" role="button" id="members-filter-activities" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="bi bi-people" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                        </svg>
                                        <?php echo $this->lang->line('activities_members'); ?>
                                        <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu members-filter-activities" aria-labelledby="dropdown-members-filter-activities">
                                        <input class="form-control search-members" id="search-members" type="text" placeholder="<?php echo $this->lang->line('activities_search_for_members'); ?>">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown d-inline">
                                    <a class="btn btn-secondary dropdown-toggle filter-types-btn" href="#" role="button" id="types-filter-activities" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="bi bi-file-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8h-1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5V1z"/>
                                            <path fill-rule="evenodd" d="M13.5 1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V1.5a.5.5 0 0 1 .5-.5z"/>
                                            <path fill-rule="evenodd" d="M13 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                        </svg>
                                        <?php echo $this->lang->line('activities_all_types'); ?>
                                        <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu types-filter-activities" aria-labelledby="dropdown-types-filter-activities">
                                        <input class="form-control search-types" id="search-types" type="text" placeholder="<?php echo $this->lang->line('activities_search_for_types'); ?>">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown d-inline">
                                    <a class="btn btn-secondary btn-reset-filters" href="#" role="button">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                                            <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                                        </svg>
                                        <?php echo $this->lang->line('activities_reset'); ?>
                                    </a>
                                </div>                                
                            </div>
                            <div class="col-md-6 col-12 text-right">
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle order-activities-btn" href="#" role="button" id="dropdown-order-activities" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="0">
                                        <svg class="bi bi-arrow-up-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11 3.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                                            <path fill-rule="evenodd" d="M10.646 2.646a.5.5 0 01.708 0l3 3a.5.5 0 01-.708.708L11 3.707 8.354 6.354a.5.5 0 11-.708-.708l3-3zm-9 7a.5.5 0 01.708 0L5 12.293l2.646-2.647a.5.5 0 11.708.708l-3 3a.5.5 0 01-.708 0l-3-3a.5.5 0 010-.708z" clip-rule="evenodd"/>
                                            <path fill-rule="evenodd" d="M5 2.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V3a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo $this->lang->line('activities_date'); ?>
                                        <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>                                        
                                    </a>

                                    <div class="dropdown-menu order-activities" aria-labelledby="dropdown-order-activities">
                                        <a class="dropdown-item" href="#" data-id="0">
                                            <?php echo $this->lang->line('activities_date'); ?>
                                        </a>
                                        <a class="dropdown-item" href="#" data-id="1">
                                            <?php echo $this->lang->line('activities_alphabetically'); ?>
                                        </a>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="all-activities-list">
                
            </div>
            <div class="row">
                <div class="col-xl-12 activities-page-footer">
                    <a href="#" class="activities-pagination-load theme-box"><?php echo $this->lang->line('activities_load_more'); ?></a>
                    <a href="#" class="activities-no-found theme-box"><?php echo $this->lang->line('activities_no_activities_found'); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Translations !-->
<script language="javascript">
var words = {
    members: '<?php echo $this->lang->line('activities_members'); ?>',
    all_types: '<?php echo $this->lang->line('activities_all_types'); ?>'
};
</script>
