<?php
/**
 * Please, ensure you have this string in the file htaccess RewriteCond $1 !^(index\.php|cron\.php|update\.php|adminer\.php|assets|images|js|css|uploads|favicon.png)
 * cron\.php must be present in the string above.
 */
define('cron','1');

// Require the index.php
require_once 'index.php';

// I was able to add only a clean curl code instead these 3 rows of code but the problem is in url, i want to simply for user the use of cron job
get(site_url('cron-job'));