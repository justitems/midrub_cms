<!doctype html>
<html lang="en">
    <head>

        <!-- Title -->
        <title><?php md_get_the_title(); ?></title>

        <!-- Required meta tags -->
        <meta charset="utf-8">

        <!-- Set the initial zoom level when the page is first loaded -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Set website url -->
        <meta name="url" content="<?php echo site_url(); ?>">
        
        <?php md_get_the_meta_description(); ?>
        <?php md_get_the_meta_keywords(); ?>

        <?php md_get_the_frontend_header(); ?>

        <!-- Styles -->
        <?php md_get_the_css_urls(); ?>

    </head>
    <body>