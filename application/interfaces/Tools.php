<?php
/**
 * Tools
 *
 * PHP Version 5.6
 *
 * Tools Interface for Tools Classes
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface Tools
{
    public function check_info();

    public function page($args);
}
