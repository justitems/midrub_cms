<?php
/**
 * Bots
 *
 * PHP Version 5.6
 *
 * Bots Interface for Bots Classes
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface Boots {
    public function check_availability();
    public function content();
    public function assets();
    public function load($act);
    public function get_info();
    public function load_cron($user_id);
}
