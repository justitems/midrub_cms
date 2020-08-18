<?php
/**
 * MY_Loader Loader
 *
 * PHP Version 5.6
 *
 * MY_Loader contains the MY_Loader class
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * MY_Loader class - loads the elements with new location
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class MY_Loader extends CI_Loader {
    
    /**
     * The public method ext_view loads an external view
     * 
     * @param string $path contains the new view's path
     * @param string $view contains the view's template
     * @param array $args contains the array to pass
     * 
     * @return array with new view parameters
     */
    public function ext_view($path, $view, $args = array(), $return = FALSE) {

        // Set new view path
        $this->_ci_view_paths = array_merge(
                $this->_ci_view_paths,
                array( $path . '/' => TRUE)
            );
        
        // Return new view parameters
        return $this->_ci_load(
                array(
                    '_ci_view' => $view,
                    '_ci_vars' => $this->_ci_prepare_view_vars($args),
                    '_ci_return' => $return
                ));
        
    }
    
    /**
     * The public method ext_model loads external model
     * 
     * @param string $path contains the new model's path
     * @param string $name contains the model's name
     * 
     * @return object with model parameters
     */
    public function ext_model( $path, $name, $slug ) {

        // Set model name
        $model = $name;
        
        // Add the model directory path
        $this->_ci_model_paths = array_unique(
                array_merge(
                    $this->_ci_model_paths,
                    array( $path)
                    )
                );
        
        // List all model paths
        foreach ($this->_ci_model_paths as $mod_path) {
            
            // Verify if the CI_Model class exists
            if ( ! class_exists('CI_Model')) {
                load_class('Model', 'core');
            }
            
            // Require new model
            require_once $path . strtolower($model) . '.php';
            
            // Set the model name
            $this->$name = new $model();
            
            // Add model to _ci_models
            $this->_ci_models[] = $name;
            
            // Load model
            $this->load->model( $name, $slug );
            
            return $this;
                
        }

        // Couldn't find the model
        show_error('Unable to locate the model you have specified: ' . $model);
        
    }
   
}