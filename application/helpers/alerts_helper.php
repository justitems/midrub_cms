<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
  Name: Alerts Helper
  Author: Scrisoft
  Created: 08/06/2016
  This file contains all error and success alerts
 * */
// Functions to display error and succes messages
if (!function_exists('display_mess')) {
    function display_mess($mess = NULL, $arg = NULL) {
        $CI = get_instance();
        switch ($mess) {
            case '1':
                echo json_encode($CI->lang->line('mm3'));
                break;
            case '2':
                echo json_encode('<div class="col-lg-12 msuccess"><p><i class="fa fa-check" aria-hidden="true"></i> '.$CI->lang->line('mm4').' ' . $arg . '.</p></div>');
                break;
            case '3':
                echo json_encode('<div class="col-lg-12 msuccess"><p><i class="fa fa-check" aria-hidden="true"></i> '.$CI->lang->line('mm5').'</p></div>');
                break;
            case '4':
                echo json_encode('<div class="col-lg-12 msuccess"><p><i class="fa fa-check" aria-hidden="true"></i> '.$CI->lang->line('mm6').'</p></div>');
                break;
            case '5':
                echo json_encode('<div class="col-lg-12 merror"><p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.$CI->lang->line('mm7').'</p></div>');
                break;
            case '6':
                echo json_encode('<div class="col-lg-12 merror"><p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.$CI->lang->line('mm8').'</p></div>');
                break;
            case '7':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm9').'</p>');
                break;
            case '8':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm10').'</p>');
                break;
            case '9':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm11').'</p>');
                break;
            case '10':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm12').' ' . $arg . ' '.$CI->lang->line('mm13').'</p>');
                break;
            case '11':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm14').'</p>');
                break;
            case '12':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm15').'</p>');
                break;
            case '13':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm16').'</p>');
                break;
            case '14':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm17').'</p>');
                break;
            case '15':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm18').'</p>');
                break;
            case '17':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm20').'</p>');
                break;
            case '18':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm3').'</p>');
                break;
            case '19':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm22').'</p>');
                break;
            case '20':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm23').'</p>');
                break;
            case '21':
                return '<p class="merror block">'.$CI->lang->line('mm24').'</p>';
                break;
            case '22':
                return '<p class="merror block">'.$CI->lang->line('mm25').'</p>';
                break;
            case '23':
                return '<p class="merror block">'.$CI->lang->line('mm26').'</p>';
                break;
            case '24':
                return '<p class="msuccess block">'.$CI->lang->line('mm27').'</p>';
                break;
            case '25':
                return '<p class="merror block">'.$CI->lang->line('mm3').'</p>';
                break;
            case '27':
                return '<p class="merror block">'.$CI->lang->line('mm3').'</p>';
                break;
            case '28':
                return '<p class="merror block">'.$CI->lang->line('mm28').'</p>';
                break;
            case '29':
                return '<p class="merror block">'.$CI->lang->line('mm21').'</p>';
                break;
            case '30':
                return '<p class="merror block">'.$CI->lang->line('mm30').'</p>';
                break;
            case '31':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm31').'</p>');
                break;
            case '32':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm32').'</p>');
                break;
            case '33':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm33').'</p>');
                break;
            case '34':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm34').'</p>');
                break;
            case '35':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm35').'</p>');
                break;
            case '36':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm36').'</p>');
                break;
            case '37':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm37').'</p>');
                break;
            case '38':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm38').'</p>');
                break;
            case '39':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm39').'</p>');
                break;
            case '40':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm40').'</p>');
                break;
            case '41':
                echo json_encode('<div class="alert alert-danger">'.$CI->lang->line('mm41').'</div>');
                break;
            case '42':
                echo json_encode('<div class="alert alert-info">'.$CI->lang->line('mm42').'</div>');
                break;
            case '43':
                echo json_encode('<div class="alert alert-danger">'.$CI->lang->line('mm3').'</div>');
                break;
            case '48':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm45').'</p>');
                break;
            case '50':
                return '<p class="merror">'.$CI->lang->line('mm46').'</p>';
                break;
            case '51':
                return '<p class="msuccess">'.$CI->lang->line('mm47').'</p>';
                break;
            case '52':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm48').'</p>');
                break;
            case '53':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm49').'</p>');
                break;
            case '54':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm50').'</p>');
                break;
            case '55':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm51').'</p>');
                break;
            case '56':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm52').'</p>');
                break;
            case '58':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm54').'</p>');
                break;
            case '59':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm55').'</p>');
                break;
            case '60':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm56').'</p>');
                break;
            case '61':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm57').'</p>');
                break;
            case '62':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm58').'</p>');
                break;
            case '63':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm59').'</p>');
                break;
            case '64':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm60').'</p>');
                break;
            case '66':
                echo json_encode($CI->lang->line('mm44'));
                break;
            case '76':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm69').'</p>');
                break;
            case '77':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm70').'</p>');
                break;
            case '78':
                return $CI->lang->line('mm71');
                break;
            case '79':
                return $CI->lang->line('mm72').' ' . $arg . ' '.$CI->lang->line('mm73');
                break;
            case '80':
                return $CI->lang->line('mm74');
                break;
            case '81':
                return $CI->lang->line('mm75');
                break;
            case '82':
                return $CI->lang->line('mm76');
                break;
            case '83':
                return $CI->lang->line('mm77');
                break;
            case '84':
                return $CI->lang->line('mm78');
                break;
            case '85':
                return $CI->lang->line('mm79');
                break;
            case '90':
                return $CI->lang->line('mm84');
                break;
            case '91':
                return $CI->lang->line('mm85');
                break;
            case '92':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm86').'</p>');
                break;
            case '93':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm87').'</p>');
                break;
            case '94':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm88').'</p>');
                break;
            case '95':
                return $CI->lang->line('mm89');
                break;
            case '96':
                return $CI->lang->line('mm90');
                break;
            case '97':
                return $CI->lang->line('mm91');
                break;
            case '98':
                return $CI->lang->line('mm92');
                break;
            case '99':
                return $CI->lang->line('mm93');
                break;
            case '102':
                return '<p class="merror block">'.$CI->lang->line('mm97').'</p>';
                break;
            case '103':
                return '<p class="merror block">'.$CI->lang->line('mm3').'</p>';
                break;
            case '104':
                echo $CI->lang->line('mm99');
                break;
            case '105':
                return htmlentities('<p class="msuccess">'.$CI->lang->line('mm100').'</p>');
                break;
            case '106':
                return htmlentities('<p class="merror">'.$CI->lang->line('mm101').'</p>');
                break;
            case '107':
                return $CI->lang->line('mm102');
                break;
            case '110':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm165').'</p>');
                break;
            case '111':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm166').'</p>');
                break;
            case '112':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm167').'</p>');
                break;
            case '113':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm168').'</p>');
                break;
            case '114':
                return json_encode('<p class="msuccess">'.$CI->lang->line('mm169').'</p>');
                break;
            case '115':
                return json_encode('<p class="merror">'.$CI->lang->line('mm170').'</p>');
                break;
            case '116':
                return $CI->lang->line('mm171');
                break;
            case '117':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm172').'</p>');
                break;
            case '118':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm173').'</p>');
                break;
            case '119':
                return '<p class="msuccess block">'.$CI->lang->line('mm174').'</p>';
                break;
            case '120':
                return '<p class="merror block">'.$CI->lang->line('mm175').'</p>';
                break;
            case '121':
                echo json_encode('<p class="msuccess block">'.$CI->lang->line('mm176').'</p>');
                break;
            case '122':
                echo json_encode('<p class="merror block">'.$CI->lang->line('mm177').'</p>');
                break;
            case '123':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm178').'</p>');
                break;
            case '130':
                return $CI->lang->line('mm189');
                break;
            case '131':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm192').'</p>');
                break;
            case '134':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm202').'</p>');
                break;
            case '135':
                return $CI->lang->line('mm203');
                break;
            case '136':
                return $CI->lang->line('mm204');
                break;
            case '137':
                return $CI->lang->line('mm205');
                break;
            case '138':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm206').'</p>');
                break;
            case '139':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm207').'</p>');
                break;
            case '140':
                echo json_encode('<p class="msuccess">'.$CI->lang->line('mm208').'</p>');
                break;
            case '141':
                echo json_encode('<p class="merror">'.$CI->lang->line('mm209').'</p>');
                break;
            case '142':
                return $CI->lang->line('mm210');
                break;
            case '143':
                return $CI->lang->line('mm211');
                break;
            case '144':
                return [ 'subi', $CI->lang->line('mm212') ];
                break;
            case '145':
                return [ 'sube', $CI->lang->line('mm213') ];
                break;   
            case '146':
                return [ 'subi', $CI->lang->line('mm214') ];
                break;
            case '147':
                return [ 'sube', $CI->lang->line('mm215') ];
                break;  
            case '148':
                return $CI->lang->line('mm220');
                break;
            case '149':
                return $CI->lang->line('mm221');
                break;
            case '150':
                echo json_encode('<p class="merror">' . $CI->lang->line('mm222') . '</p>');
                break;
            case '151':
                echo json_encode('<p class="msuccess">' . $CI->lang->line('mm2') . '</p>');
                break;
            case '152':
                echo json_encode('<p class="merror">' . $CI->lang->line('mm1') . '</p>');
                break;
            case '153':
                echo json_encode('<p class="msuccess">' . $CI->lang->line('ma250') . '</p>');
                break;
            case '154':
                echo json_encode('<p class="merror">' . $CI->lang->line('ma251') . '</p>');
                break;
            case '155':
                return '<p class="msuccess">' . $CI->lang->line('mm223') . '</p>';
                break;
            case '156':
                echo json_encode('<p class="merror">' . $CI->lang->line('your_account_is_disabled') . '</p>');
                break;
            case '157':
                echo json_encode('<p class="merror">' . $CI->lang->line('please_ensure_correct_credientials') . '</p>');
                break;            
            default:
                echo json_encode('<div class="col-lg-12 merror"><p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' . $CI->lang->line('mm3') . '</p></div>');
                break;
        }
    }
}