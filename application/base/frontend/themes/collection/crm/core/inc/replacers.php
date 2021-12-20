<?php
/**
 * Replacers Theme Inc
 *
 * This file contains the theme's replacers
 * used in the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constant
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The public method md_set_replacer registers a replacer
 * 
 * @since 0.0.8.5
 */
md_set_replacer('code', function ($args = array()) {

    if ( isset($args['start']) ) {

        return str_replace('{code}', '<blockquote><pre><code>', $args['content']);

    } else if ( isset($args['end']) ) {

        return str_replace('{|code}', '</code></pre></blockquote>', $args['content']);

    } else {

        return $args['content'];

    }

});

/**
 * The public method md_set_replacer registers a replacer
 * 
 * @since 0.0.8.5
 */
md_set_replacer('alert', function ($args = array()) {

    $content = str_replace(array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>'), array('<h1 class="alert-heading">', '<h2 class="alert-heading">', '<h3 class="alert-heading">', '<h4 class="alert-heading">', '<h5 class="alert-heading">', '<h6 class="alert-heading">'), $args['content']);

    if ( isset($args['start']) ) {

        if ( isset($args['type']) ) {

            return str_replace('{alert type="' . $args['type'] . '"}', '<div class="alert alert-' . $args['type'] . '" role="alert">', $content);

        } else {

            return str_replace('{alert}', '<div class="alert alert-light" role="alert">', $content);

        }

    } else if ( isset($args['end']) ) {

        return str_replace('{|alert}', '</div>', $content);

    } else {

        return $content;

    }

});