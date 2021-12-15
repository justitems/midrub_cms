<?php
/**
 * Fields
 *
 * PHP Version 7.4
 *
 * Fields Interface for Base Admin Fields
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license.md
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace CmsBase\Admin\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fields interface - allows to create fields in the administrator's panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license.md
 * @link     https://www.midrub.com/
 */
interface Fields {
    
    /**
     * The public method the_field gets the admin's field
     * 
     * @param array $field contains the field's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with the field
     */
    public function the_field($field);
 
}

/* End of file fields.php */