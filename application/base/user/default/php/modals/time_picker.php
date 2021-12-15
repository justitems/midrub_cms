<!-- Modal -->
<div class="modal fade theme-modal" id="theme-open-time-picker-modal" tabindex="-1" role="dialog" aria-labelledby="theme-open-time-picker-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content theme-font-2 theme-color-black">
            <div class="modal-body">
                <table class="theme-time-picker-table">
                    <thead>
                        <tr>
                            <th class="default-year-month">
                            </th>
                            <th class="text-center">
                                <a href="#" class="default-go-back">
                                    <?php echo md_the_user_icon(array('icon' => 'bi_arrow_left_circle')); ?>  
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="#" class="default-go-next">
                                    <?php echo md_the_user_icon(array('icon' => 'bi_arrow_right_circle')); ?> 
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">
                                <table>
                                    <tbody class="default-calendar-dates">
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div class="theme-time-picker-hours-minutes">
                                    <div class="btn-group">
                                        <div class="btn-group dropdown-options">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="theme-time-picker-hours-minutes-select">
                                            </button>
                                            <div class="dropdown-menu theme-time-picker-hours-minutes-select" aria-labelledby="theme-time-picker-hours-minutes-select">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <fieldset>
                                                            <legend>
                                                                <?php echo $this->lang->line('theme_hours'); ?>
                                                            </legend>
                                                            <div class="row">
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="00">
                                                                        00
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="01">
                                                                        01
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="02">
                                                                        02
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="03">
                                                                        03
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="04">
                                                                        04
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="05">
                                                                        05
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="06">
                                                                        06
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="07">
                                                                        07
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="08">
                                                                        08
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="09">
                                                                        09
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="10">
                                                                        10
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="11">
                                                                        11
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="12">
                                                                        12
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="13">
                                                                        13
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="14">
                                                                        14
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="15">
                                                                        15
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="16">
                                                                        16
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="17">
                                                                        17
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="18">
                                                                        18
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="19">
                                                                        19
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="20">
                                                                        20
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="21">
                                                                        21
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="22">
                                                                        22
                                                                    </a>
                                                                </div>
                                                                <div class="col-1 theme-time-picker-hour-24-format">
                                                                    <a href="#" class="theme-time-picker-hour-select" data-hour="23">
                                                                        23
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-12">
                                                        <fieldset>
                                                            <legend>
                                                                <?php echo $this->lang->line('theme_minutes'); ?>
                                                            </legend>
                                                            <div class="row">
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="00">
                                                                        00
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="05">
                                                                        05
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="10">
                                                                        10
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="15">
                                                                        15
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="20">
                                                                        20
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="25">
                                                                        25
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="30">
                                                                        30
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="35">
                                                                        35
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="40">
                                                                        40
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="45">
                                                                        45
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="50">
                                                                        50
                                                                    </a>
                                                                </div>
                                                                <div class="col-1">
                                                                    <a href="#" class="theme-time-picker-minute-select" data-minute="55">
                                                                        55
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-12 theme-time-picker-meridiem-fieldset">
                                                        <fieldset>
                                                            <legend>
                                                                <?php echo $this->lang->line('theme_meridiem'); ?>
                                                            </legend>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="btn-group theme-time-picker-meridiem" role="group" aria-label="Meridiem options">
                                                                        <button type="button" class="btn btn-secondary theme-time-picker-meridiem-select theme-time-picker-meridiem-selected" data-meridiem="AM">
                                                                            AM
                                                                        </button>
                                                                        <button type="button" class="btn btn-secondary theme-time-picker-meridiem-select" data-meridiem="PM">
                                                                            PM
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-right">
                                                        <button type="button" class="btn btn-secondary btn-dropdown-options-btn">
                                                            <?php echo $this->lang->line('theme_close'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-primary theme-time-picker-hours-minutes-ok-btn">
                                                            <?php echo $this->lang->line('theme_ok'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <?php echo $this->lang->line('theme_close'); ?>
                </button>
                <button type="button" class="btn btn-primary default-time-set-time">
                    <?php echo $this->lang->line('theme_ok'); ?>
                </button>
            </div>
        </div>
    </div>
</div>