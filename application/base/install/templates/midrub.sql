-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 18, 2020 at 04:20 AM
-- Server version: 10.1.45-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `midrubco_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` bigint(20) NOT NULL,
  `app` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `template` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `administrator_dashboard_widgets`
--

CREATE TABLE `administrator_dashboard_widgets` (
  `widget_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `widget_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `order` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classifications`
--

CREATE TABLE `classifications` (
  `classification_id` bigint(20) NOT NULL,
  `slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `parent` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classifications_meta`
--

CREATE TABLE `classifications_meta` (
  `meta_id` bigint(20) NOT NULL,
  `classification_id` bigint(20) NOT NULL,
  `meta_slug` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_extra` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `content_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contents_category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `contents_component` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `contents_theme` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `contents_template` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `contents_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents_classifications`
--

CREATE TABLE `contents_classifications` (
  `classification_id` bigint(20) NOT NULL,
  `content_id` bigint(20) NOT NULL,
  `classification_slug` text COLLATE utf8_unicode_ci NOT NULL,
  `classification_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents_meta`
--

CREATE TABLE `contents_meta` (
  `meta_id` bigint(20) NOT NULL,
  `content_id` bigint(20) NOT NULL,
  `meta_slug` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_extra` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` bigint(20) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL,
  `count` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_articles`
--

CREATE TABLE `faq_articles` (
  `article_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_articles_categories`
--

CREATE TABLE `faq_articles_categories` (
  `meta_id` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `category_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_articles_meta`
--

CREATE TABLE `faq_articles_meta` (
  `meta_id` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `category_id` int(6) NOT NULL,
  `parent` int(6) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories_meta`
--

CREATE TABLE `faq_categories_meta` (
  `meta_id` bigint(20) NOT NULL,
  `category_id` int(6) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` bigint(20) NOT NULL,
  `transaction_id` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `plan_id` int(6) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `invoice_title` text COLLATE utf8_unicode_ci NOT NULL,
  `invoice_text` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `taxes` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `total` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `from_period` datetime NOT NULL,
  `to_period` datetime NOT NULL,
  `gateway` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `media_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `cover` text COLLATE utf8_unicode_ci,
  `size` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE `networks` (
  `network_id` int(3) NOT NULL,
  `network_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `net_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `expires` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `token` text COLLATE utf8_unicode_ci,
  `secret` text COLLATE utf8_unicode_ci,
  `completed` tinyint(1) NOT NULL,
  `api_key` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_secret` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) NOT NULL,
  `notification_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `notification_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `notification_body` text COLLATE utf8_unicode_ci NOT NULL,
  `sent_time` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `template` tinyint(1) NOT NULL,
  `template_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_title`, `notification_name`, `notification_body`, `sent_time`, `template`, `template_name`) VALUES
(1, 'Welcome to [site_name]', 'Welcome message(without confirmation)', '<p>You can login here: [login_address]</p><p>Using this username and password:</p><p>Username: [username]</p><p>Password: *** Password you set during signup ***</p><p>Cheers!</p><p>The [site_name] Team</p><p><br></p>', '', 1, 'welcome-message-no-confirmation'),
(2, 'Welcome to [site_name]', 'Welcome message(with confirmation)', '<p>To activate your account and verify your email address, </p><p>please click the following link: [confirmation_link]</p><p><br></p>', '', 1, 'welcome-message-with-confirmation'),
(3, 'Your account has been activated', 'Success confirmation message', '<p>Congratulations, your account has been activated!</p><p>You can login here: [login_address]</p><p>Using this username and password:</p><p>Username: [username]</p><p>Password: *** Password you set during signup ***</p><p>Cheers!</p><p>The [site_name] Team</p>', '', 1, 'success-confirmation-message'),
(4, 'Password Reset', 'Reset password message', '<p>Dear [username]</p><p>To reset the password to your [site_name]\'s account, click the link below: </p><p>[reset_link]<br></p>', '', 1, 'password-reset'),
(5, 'Your password has been reset successfully', 'Success password changed message', '<p>Congratulations, your account has been activated!</p><p>You can login here: [login_address]<br></p><p><br></p>', '', 1, 'success-password-changed'),
(6, 'Your message wasn\'t published successfully', 'Publishing message error', '<p>You messagge wasn\'t published successfully on a social network.</p><p>You can login here: [login_address]<br></p>', '', 1, 'error-sent-notification'),
(7, 'Resend Confirmation Email', 'Resend confirmation email', '<p>To activate your account and verify your email address,</p><p>please click the following link: [confirmation_link]</p>', '', 1, 'resend-confirmation-email'),
(8, 'Your new account was created successfully', 'Send password to new users', '<p>A new account has been created for you on [site_name].</p><p>You can login here <span xss=\"removed\">[login_address]</span></p><p><span xss=\"removed\">Username: [username]</span></p><p><span xss=\"removed\">Password: [password]</span></p>', '', 1, 'send-password-new-users'),
(9, 'Scheduled Notification', 'Scheduled notification', '<p>An user has scheduled a new message.</p><p>Please Sign In: <span xss=\"removed\">[login_address]</span></p><p><br></p>', '', 1, 'scheduled-notification'),
(12, 'New user registration', 'New user registration', 'A new user has registered at <span xss=\"removed\">[site_name]</span>', '', 1, 'new-user-notification'),
(1000, 'The Planned Post was completed', 'Post Completation Notification', '<p>Dear [username]</p><p>Your planned post, [post] was published the planned number of times and will not be more published.</p>', '', 1, 'planned-completed-confirmation'),
(1100, 'New Ticket Reply', 'New Ticket Reply', '<p>Dear [username]</p><p>You have a new reply for your opened ticket.</p>', '', 1, 'ticket-notification-reply'),
(2000, 'The Planned Email Template was completed', 'Email Template Completation Notification', '<p>Dear [username]</p><p>Your planned email template, [template] was sent the planned number of times and will not be more sent.</p>', '', 1, 'planned-email-completed-confirmation');

-- --------------------------------------------------------

--
-- Table structure for table `notifications_stats`
--

CREATE TABLE `notifications_stats` (
  `stat_id` bigint(20) NOT NULL,
  `notification_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_applications`
--

CREATE TABLE `oauth_applications` (
  `application_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_url` text COLLATE utf8_unicode_ci NOT NULL,
  `cancel_url` text COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_applications_permissions`
--

CREATE TABLE `oauth_applications_permissions` (
  `permission_id` bigint(20) NOT NULL,
  `application_id` bigint(20) NOT NULL,
  `permission_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_codes`
--

CREATE TABLE `oauth_authorization_codes` (
  `code_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_id` bigint(20) NOT NULL,
  `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_codes_permissions`
--

CREATE TABLE `oauth_authorization_codes_permissions` (
  `permission_id` bigint(20) NOT NULL,
  `code_id` bigint(20) NOT NULL,
  `permission_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_permissions`
--

CREATE TABLE `oauth_permissions` (
  `permission_id` bigint(20) NOT NULL,
  `permission_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_tokens`
--

CREATE TABLE `oauth_tokens` (
  `token_id` bigint(20) NOT NULL,
  `application_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_tokens_permissions`
--

CREATE TABLE `oauth_tokens_permissions` (
  `permission_id` bigint(20) NOT NULL,
  `token_id` bigint(20) NOT NULL,
  `permission_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` bigint(20) NOT NULL,
  `option_key` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` mediumtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_key`, `option_value`) VALUES
(1, 'cron_update_verify', '2020-08-18');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `txn_id` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_amount` decimal(7,2) NOT NULL,
  `payment_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `plan_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `source` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recurring` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(6) NOT NULL,
  `plan_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `plan_price` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `currency_sign` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `network_accounts` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sent_emails` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `storage` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `features` text COLLATE utf8_unicode_ci NOT NULL,
  `teams` tinyint(1) DEFAULT NULL,
  `header` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `period` bigint(10) NOT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `popular` tinyint(1) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `trial` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_name`, `plan_price`, `currency_sign`, `currency_code`, `network_accounts`, `sent_emails`, `storage`, `features`, `teams`, `header`, `period`, `visible`, `popular`, `featured`, `trial`) VALUES
(1, 'Free Plan', '4.00', '$', 'USD', '1', '10', '60000000', '1 Social Profiles\n1 Feed Rss\nReal-time Analytics\nMessage Scheduling\n', 5, 'for personal use', 30, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plans_meta`
--

CREATE TABLE `plans_meta` (
  `meta_id` int(6) NOT NULL,
  `plan_id` int(6) NOT NULL,
  `meta_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `referrer_id` bigint(20) NOT NULL,
  `referrer` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` bigint(20) NOT NULL,
  `earned` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `net_id` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `period` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `gateway` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_update` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `member_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `member_username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `member_password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `member_email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `about_member` text COLLATE utf8_unicode_ci,
  `date_joined` datetime NOT NULL,
  `last_access` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams_roles`
--

CREATE TABLE `teams_roles` (
  `role_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams_roles_permission`
--

CREATE TABLE `teams_roles_permission` (
  `permission_id` bigint(20) NOT NULL,
  `role_id` int(20) NOT NULL,
  `permission` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `important` tinyint(1) DEFAULT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_meta`
--

CREATE TABLE `tickets_meta` (
  `meta_id` bigint(20) NOT NULL,
  `ticket_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `net_id` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `gateway` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_fields`
--

CREATE TABLE `transactions_fields` (
  `field_id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `field_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `field_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_options`
--

CREATE TABLE `transactions_options` (
  `option_id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `option_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `update_id` bigint(20) NOT NULL,
  `slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `role` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_joined` datetime NOT NULL,
  `last_access` datetime DEFAULT NULL,
  `ip_address` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reset_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `activate` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `last_name`, `first_name`, `password`, `role`, `status`, `date_joined`, `last_access`, `ip_address`, `reset_code`, `activate`) VALUES
(104, 'administrator', 'admin@example.com', NULL, NULL, '$2a$08$CwRg961g2QCS1kBjA0NgAOs8Dg31QzOP6mNxF.OdrCd5BqAmtLyOe', 1, 1, '2016-08-11 10:37:16', '2020-08-16 07:53:37', '', ' ', ''),
(118, 'testuser', 'user@email.com', NULL, NULL, '$2a$08$fcmlgRj56zPvpYvAc3v9Ze8Tp4xX7cKmoSJZOhEqTIjvZmFtdfu/O', 0, 1, '2016-10-10 12:37:03', '2016-10-10 15:41:36', '', ' ', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_meta`
--

CREATE TABLE `users_meta` (
  `meta_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta_name` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `administrator_dashboard_widgets`
--
ALTER TABLE `administrator_dashboard_widgets`
  ADD PRIMARY KEY (`widget_id`);

--
-- Indexes for table `classifications`
--
ALTER TABLE `classifications`
  ADD PRIMARY KEY (`classification_id`);

--
-- Indexes for table `classifications_meta`
--
ALTER TABLE `classifications_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `contents_classifications`
--
ALTER TABLE `contents_classifications`
  ADD PRIMARY KEY (`classification_id`);

--
-- Indexes for table `contents_meta`
--
ALTER TABLE `contents_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `faq_articles`
--
ALTER TABLE `faq_articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `faq_articles_categories`
--
ALTER TABLE `faq_articles_categories`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `faq_articles_meta`
--
ALTER TABLE `faq_articles_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `faq_categories_meta`
--
ALTER TABLE `faq_categories_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `networks`
--
ALTER TABLE `networks`
  ADD PRIMARY KEY (`network_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notifications_stats`
--
ALTER TABLE `notifications_stats`
  ADD PRIMARY KEY (`stat_id`);

--
-- Indexes for table `oauth_applications`
--
ALTER TABLE `oauth_applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `oauth_applications_permissions`
--
ALTER TABLE `oauth_applications_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `oauth_authorization_codes_permissions`
--
ALTER TABLE `oauth_authorization_codes_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `oauth_permissions`
--
ALTER TABLE `oauth_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `oauth_tokens`
--
ALTER TABLE `oauth_tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `oauth_tokens_permissions`
--
ALTER TABLE `oauth_tokens_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `plans_meta`
--
ALTER TABLE `plans_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`referrer_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `teams_roles`
--
ALTER TABLE `teams_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `teams_roles_permission`
--
ALTER TABLE `teams_roles_permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `tickets_meta`
--
ALTER TABLE `tickets_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transactions_fields`
--
ALTER TABLE `transactions_fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `transactions_options`
--
ALTER TABLE `transactions_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_meta`
--
ALTER TABLE `users_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `administrator_dashboard_widgets`
--
ALTER TABLE `administrator_dashboard_widgets`
  MODIFY `widget_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classifications`
--
ALTER TABLE `classifications`
  MODIFY `classification_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classifications_meta`
--
ALTER TABLE `classifications_meta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `content_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents_classifications`
--
ALTER TABLE `contents_classifications`
  MODIFY `classification_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents_meta`
--
ALTER TABLE `contents_meta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_articles`
--
ALTER TABLE `faq_articles`
  MODIFY `article_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_articles_categories`
--
ALTER TABLE `faq_articles_categories`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_articles_meta`
--
ALTER TABLE `faq_articles_meta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `category_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories_meta`
--
ALTER TABLE `faq_categories_meta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `networks`
--
ALTER TABLE `networks`
  MODIFY `network_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2014;

--
-- AUTO_INCREMENT for table `notifications_stats`
--
ALTER TABLE `notifications_stats`
  MODIFY `stat_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_applications`
--
ALTER TABLE `oauth_applications`
  MODIFY `application_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_applications_permissions`
--
ALTER TABLE `oauth_applications_permissions`
  MODIFY `permission_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  MODIFY `code_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_authorization_codes_permissions`
--
ALTER TABLE `oauth_authorization_codes_permissions`
  MODIFY `permission_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_permissions`
--
ALTER TABLE `oauth_permissions`
  MODIFY `permission_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_tokens`
--
ALTER TABLE `oauth_tokens`
  MODIFY `token_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_tokens_permissions`
--
ALTER TABLE `oauth_tokens_permissions`
  MODIFY `permission_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plans_meta`
--
ALTER TABLE `plans_meta`
  MODIFY `meta_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `referrer_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `subscription_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `member_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams_roles`
--
ALTER TABLE `teams_roles`
  MODIFY `role_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams_roles_permission`
--
ALTER TABLE `teams_roles_permission`
  MODIFY `permission_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets_meta`
--
ALTER TABLE `tickets_meta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_fields`
--
ALTER TABLE `transactions_fields`
  MODIFY `field_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_options`
--
ALTER TABLE `transactions_options`
  MODIFY `option_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `update_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `users_meta`
--
ALTER TABLE `users_meta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;