<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Set website url -->
    <meta name="url" content="<?php echo site_url(); ?>">

    <!-- Title -->
    <title><?php get_the_title(); ?></title>

    <!-- Styles -->
    <?php get_the_css_urls(); ?>

</head>
<body>
<?php echo get_payment_view(); ?>

<?php get_the_js_urls(); ?>
</body>
</html>