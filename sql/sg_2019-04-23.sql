# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.38)
# Database: sg
# Generation Time: 2019-04-23 05:09:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table wp_commentmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_commentmeta`;

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table wp_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_comments`;

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table wp_links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_links`;

CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table wp_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_options`;

CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`)
VALUES
	(1,'siteurl','http://sg.local','yes'),
	(2,'home','http://sg.local','yes'),
	(3,'blogname','SITE TITLE','yes'),
	(4,'blogdescription','SITE TAGLINE','yes'),
	(5,'users_can_register','0','yes'),
	(6,'admin_email','devs@mylogins.com.au','yes'),
	(7,'start_of_week','1','yes'),
	(8,'use_balanceTags','0','yes'),
	(9,'use_smilies','1','yes'),
	(10,'require_name_email','1','yes'),
	(11,'comments_notify','1','yes'),
	(12,'posts_per_rss','10','yes'),
	(13,'rss_use_excerpt','0','yes'),
	(14,'mailserver_url','mail.example.com','yes'),
	(15,'mailserver_login','login@example.com','yes'),
	(16,'mailserver_pass','password','yes'),
	(17,'mailserver_port','110','yes'),
	(18,'default_category','1','yes'),
	(19,'default_comment_status','open','yes'),
	(20,'default_ping_status','open','yes'),
	(21,'default_pingback_flag','1','yes'),
	(22,'posts_per_page','10','yes'),
	(23,'date_format','F j, Y','yes'),
	(24,'time_format','g:i a','yes'),
	(25,'links_updated_date_format','F j, Y g:i a','yes'),
	(26,'comment_moderation','0','yes'),
	(27,'moderation_notify','1','yes'),
	(28,'permalink_structure','/%postname%/','yes'),
	(29,'rewrite_rules','a:88:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:38:\"index.php?&page_id=6&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}','yes'),
	(30,'hack_file','0','yes'),
	(31,'blog_charset','UTF-8','yes'),
	(32,'moderation_keys','','no'),
	(33,'active_plugins','a:13:{i:0;s:34:\"advanced-custom-fields-pro/acf.php\";i:1;s:33:\"classic-editor/classic-editor.php\";i:2;s:35:\"crop-thumbnails/crop-thumbnails.php\";i:3;s:37:\"disable-comments/disable-comments.php\";i:4;s:33:\"duplicate-post/duplicate-post.php\";i:5;s:45:\"enable-media-replace/enable-media-replace.php\";i:6;s:19:\"mailgun/mailgun.php\";i:7;s:39:\"mce-table-buttons/mce_table_buttons.php\";i:8;s:33:\"pdf-thumbnails/pdf-thumbnails.php\";i:9;s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";i:10;s:57:\"scalable-vector-graphics-svg/scalable-vector-graphics.php\";i:11;s:53:\"simple-custom-post-order/simple-custom-post-order.php\";i:12;s:43:\"sticky-posts-switch/sticky-posts-switch.php\";}','yes'),
	(34,'category_base','','yes'),
	(35,'ping_sites','http://rpc.pingomatic.com/','yes'),
	(36,'comment_max_links','2','yes'),
	(37,'gmt_offset','10','yes'),
	(38,'default_email_category','1','yes'),
	(39,'recently_edited','a:2:{i:0;s:109:\"/Users/mattdwyer/Sites/internal/legpress/wp-content/plugins/acf-post-type-selector/acf-post-type-selector.php\";i:1;s:0:\"\";}','no'),
	(40,'template','sg','yes'),
	(41,'stylesheet','sg','yes'),
	(42,'comment_whitelist','1','yes'),
	(43,'blacklist_keys','','no'),
	(44,'comment_registration','0','yes'),
	(45,'html_type','text/html','yes'),
	(46,'use_trackback','0','yes'),
	(47,'default_role','subscriber','yes'),
	(48,'db_version','44719','yes'),
	(49,'uploads_use_yearmonth_folders','1','yes'),
	(50,'upload_path','','yes'),
	(51,'blog_public','1','yes'),
	(52,'default_link_category','2','yes'),
	(53,'show_on_front','page','yes'),
	(54,'tag_base','','yes'),
	(55,'show_avatars','1','yes'),
	(56,'avatar_rating','G','yes'),
	(57,'upload_url_path','','yes'),
	(58,'thumbnail_size_w','150','yes'),
	(59,'thumbnail_size_h','150','yes'),
	(60,'thumbnail_crop','1','yes'),
	(61,'medium_size_w','300','yes'),
	(62,'medium_size_h','300','yes'),
	(63,'avatar_default','mystery','yes'),
	(64,'large_size_w','1024','yes'),
	(65,'large_size_h','1024','yes'),
	(66,'image_default_link_type','none','yes'),
	(67,'image_default_size','','yes'),
	(68,'image_default_align','','yes'),
	(69,'close_comments_for_old_posts','0','yes'),
	(70,'close_comments_days_old','14','yes'),
	(71,'thread_comments','1','yes'),
	(72,'thread_comments_depth','5','yes'),
	(73,'page_comments','0','yes'),
	(74,'comments_per_page','50','yes'),
	(75,'default_comments_page','newest','yes'),
	(76,'comment_order','asc','yes'),
	(77,'sticky_posts','a:0:{}','yes'),
	(78,'widget_categories','a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),
	(79,'widget_text','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
	(80,'widget_rss','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
	(81,'uninstall_plugins','a:2:{s:53:\"simple-custom-post-order/simple-custom-post-order.php\";s:18:\"scporder_uninstall\";s:33:\"classic-editor/classic-editor.php\";a:2:{i:0;s:14:\"Classic_Editor\";i:1;s:9:\"uninstall\";}}','no'),
	(82,'timezone_string','','yes'),
	(83,'page_for_posts','8','yes'),
	(84,'page_on_front','6','yes'),
	(85,'default_post_format','0','yes'),
	(86,'link_manager_enabled','0','yes'),
	(87,'finished_splitting_shared_terms','1','yes'),
	(88,'site_icon','0','yes'),
	(89,'medium_large_size_w','768','yes'),
	(90,'medium_large_size_h','0','yes'),
	(91,'initial_db_version','38590','yes'),
	(92,'wp_user_roles','a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:10:\"copy_posts\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:35:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:10:\"copy_posts\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}','yes'),
	(93,'fresh_site','0','yes'),
	(94,'WPLANG','en_AU','yes'),
	(95,'widget_search','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),
	(96,'widget_recent-posts','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),
	(97,'widget_recent-comments','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),
	(98,'widget_archives','a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),
	(99,'widget_meta','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),
	(100,'sidebars_widgets','a:2:{s:19:\"wp_inactive_widgets\";a:5:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:10:\"archives-2\";i:3;s:12:\"categories-2\";i:4;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}','yes'),
	(101,'widget_pages','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(102,'widget_calendar','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(103,'widget_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(104,'widget_nav_menu','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(105,'cron','a:7:{i:1555998313;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1556013212;a:2:{s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1556030064;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1556056424;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1556056449;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1556081597;a:1:{s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}','yes'),
	(106,'theme_mods_twentyseventeen','a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1484172396;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}}}}','yes'),
	(150,'recently_activated','a:0:{}','yes'),
	(151,'wpcf7','a:2:{s:7:\"version\";s:5:\"4.8.1\";s:13:\"bulk_validate\";a:4:{s:9:\"timestamp\";i:1484207783;s:7:\"version\";s:3:\"4.6\";s:11:\"count_valid\";i:1;s:13:\"count_invalid\";i:0;}}','yes'),
	(152,'scporder_install','1','yes'),
	(153,'widget_youtubechannelgallery_widget','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(154,'acf_version','5.7.13','yes'),
	(155,'duplicate_post_copytitle','1','yes'),
	(156,'duplicate_post_copydate','0','yes'),
	(157,'duplicate_post_copystatus','0','yes'),
	(158,'duplicate_post_copyslug','1','yes'),
	(159,'duplicate_post_copyexcerpt','1','yes'),
	(160,'duplicate_post_copycontent','1','yes'),
	(161,'duplicate_post_copypassword','0','yes'),
	(162,'duplicate_post_copyattachments','0','yes'),
	(163,'duplicate_post_copychildren','0','yes'),
	(164,'duplicate_post_copycomments','0','yes'),
	(165,'duplicate_post_taxonomies_blacklist','a:0:{}','yes'),
	(166,'duplicate_post_blacklist','','yes'),
	(167,'duplicate_post_types_enabled','a:2:{i:0;s:4:\"post\";i:1;s:4:\"page\";}','yes'),
	(168,'duplicate_post_show_row','1','yes'),
	(169,'duplicate_post_show_adminbar','1','yes'),
	(170,'duplicate_post_show_submitbox','1','yes'),
	(179,'duplicate_post_copythumbnail','1','yes'),
	(180,'duplicate_post_copytemplate','1','yes'),
	(181,'duplicate_post_copyformat','1','yes'),
	(182,'duplicate_post_copyauthor','0','yes'),
	(183,'duplicate_post_copymenuorder','1','yes'),
	(184,'duplicate_post_show_bulkactions','1','yes'),
	(187,'current_theme','THEME','yes'),
	(188,'theme_mods_legpress','a:3:{i:0;b:0;s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1555995980;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:7:\"youtube\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}','yes'),
	(189,'theme_switched','','yes'),
	(190,'options_404_message','<h2>Sorry that page doesn\'t exist!</h2>','no'),
	(191,'_options_404_message','field_5876ae4b3746e','no'),
	(192,'acf_pro_license','YToyOntzOjM6ImtleSI7czo3MjoiYjNKa1pYSmZhV1E5T0RJME5UaDhkSGx3WlQxa1pYWmxiRzl3WlhKOFpHRjBaVDB5TURFMkxUQTFMVEkzSURBMk9qTTRPak0xIjtzOjM6InVybCI7czoyMToiaHR0cDovL2xlZ3ByZXNzLmxvY2FsIjt9','yes'),
	(271,'widget_media_audio','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(272,'widget_media_image','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(273,'widget_media_video','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(283,'widget_custom_html','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(316,'mailgun','a:14:{s:6:\"region\";s:2:\"us\";s:6:\"useAPI\";s:1:\"1\";s:6:\"domain\";s:18:\"mg.mylogins.com.au\";s:6:\"apiKey\";s:36:\"key-xxx\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:6:\"secure\";s:1:\"1\";s:7:\"sectype\";s:3:\"ssl\";s:12:\"track-clicks\";s:2:\"no\";s:11:\"track-opens\";s:1:\"0\";s:12:\"from-address\";s:20:\"info@mylogins.com.au\";s:9:\"from-name\";s:0:\"\";s:13:\"override-from\";N;s:11:\"campaign-id\";s:0:\"\";}','yes'),
	(317,'widget_list_widget','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(392,'widget_media_gallery','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(450,'emr_news','1','yes'),
	(477,'duplicate_post_version','3.2.2','yes'),
	(478,'duplicate_post_show_notice','0','no'),
	(487,'disable_comments_options','a:5:{s:19:\"disabled_post_types\";a:3:{i:0;s:4:\"post\";i:1;s:4:\"page\";i:2;s:10:\"attachment\";}s:17:\"remove_everywhere\";b:1;s:9:\"permanent\";b:0;s:16:\"extra_post_types\";b:0;s:10:\"db_version\";i:6;}','yes'),
	(526,'classic-editor-replace','replace','yes'),
	(582,'sticky_posts_switch_options','a:3:{s:10:\"post_types\";a:1:{i:0;s:4:\"post\";}s:18:\"show_on_front_page\";a:1:{i:0;s:4:\"post\";}s:15:\"show_on_archive\";a:1:{i:0;s:4:\"post\";}}','yes'),
	(636,'wp_page_for_privacy_policy','0','yes'),
	(637,'show_comments_cookies_opt_in','1','yes'),
	(638,'db_upgraded','','yes'),
	(643,'can_compress_scripts','1','no'),
	(645,'scporder_notice','1','yes'),
	(689,'_site_transient_update_core','O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/en_AU/wordpress-5.1.1.zip\";s:6:\"locale\";s:5:\"en_AU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/en_AU/wordpress-5.1.1.zip\";s:10:\"no_content\";b:0;s:11:\"new_bundled\";b:0;s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.1.1\";s:7:\"version\";s:5:\"5.1.1\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.0\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1555995840;s:15:\"version_checked\";s:5:\"5.1.1\";s:12:\"translations\";a:0:{}}','no'),
	(691,'_site_transient_update_plugins','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1555995840;s:7:\"checked\";a:21:{s:34:\"advanced-custom-fields-pro/acf.php\";s:6:\"5.7.13\";s:33:\"classic-editor/classic-editor.php\";s:3:\"1.4\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:5:\"5.1.1\";s:35:\"crop-thumbnails/crop-thumbnails.php\";s:5:\"1.2.4\";s:37:\"disable-comments/disable-comments.php\";s:5:\"1.9.0\";s:33:\"duplicate-post/duplicate-post.php\";s:5:\"3.2.2\";s:45:\"enable-media-replace/enable-media-replace.php\";s:5:\"3.2.9\";s:21:\"flamingo/flamingo.php\";s:3:\"1.9\";s:19:\"mailgun/mailgun.php\";s:5:\"1.7.1\";s:39:\"mce-table-buttons/mce_table_buttons.php\";s:3:\"3.3\";s:27:\"ninja-forms/ninja-forms.php\";s:6:\"3.4.10\";s:41:\"ninja-forms-conditionals/conditionals.php\";s:6:\"3.0.17\";s:39:\"ninja-forms-style/ninja-forms-style.php\";s:6:\"3.0.25\";s:37:\"ninja-forms-multi-part/multi-part.php\";s:6:\"3.0.22\";s:33:\"pdf-thumbnails/pdf-thumbnails.php\";s:5:\"2.2.0\";s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";s:5:\"3.1.0\";s:57:\"scalable-vector-graphics-svg/scalable-vector-graphics.php\";s:3:\"3.4\";s:53:\"simple-custom-post-order/simple-custom-post-order.php\";s:5:\"2.4.3\";s:43:\"sticky-posts-switch/sticky-posts-switch.php\";s:5:\"1.9.2\";s:43:\"wp-instagram-widget/wp-instagram-widget.php\";s:5:\"2.0.3\";s:51:\"youtube-channel-gallery/youtube-channel-gallery.php\";s:3:\"2.4\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:17:{s:33:\"classic-editor/classic-editor.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/classic-editor\";s:4:\"slug\";s:14:\"classic-editor\";s:6:\"plugin\";s:33:\"classic-editor/classic-editor.php\";s:11:\"new_version\";s:3:\"1.4\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/classic-editor/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/classic-editor.1.4.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671\";s:2:\"1x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671\";s:2:\"1x\";s:69:\"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676\";}s:11:\"banners_rtl\";a:0:{}}s:36:\"contact-form-7/wp-contact-form-7.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/contact-form-7\";s:4:\"slug\";s:14:\"contact-form-7\";s:6:\"plugin\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:11:\"new_version\";s:5:\"5.1.1\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/contact-form-7/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/contact-form-7.5.1.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/contact-form-7/assets/icon-256x256.png?rev=984007\";s:2:\"1x\";s:66:\"https://ps.w.org/contact-form-7/assets/icon-128x128.png?rev=984007\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901\";s:2:\"1x\";s:68:\"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427\";}s:11:\"banners_rtl\";a:0:{}}s:35:\"crop-thumbnails/crop-thumbnails.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:29:\"w.org/plugins/crop-thumbnails\";s:4:\"slug\";s:15:\"crop-thumbnails\";s:6:\"plugin\";s:35:\"crop-thumbnails/crop-thumbnails.php\";s:11:\"new_version\";s:5:\"1.2.4\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/crop-thumbnails/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/crop-thumbnails.1.2.4.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:60:\"https://ps.w.org/crop-thumbnails/assets/icon.svg?rev=1228698\";s:3:\"svg\";s:60:\"https://ps.w.org/crop-thumbnails/assets/icon.svg?rev=1228698\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/crop-thumbnails/assets/banner-1544x500.jpg?rev=626571\";s:2:\"1x\";s:69:\"https://ps.w.org/crop-thumbnails/assets/banner-772x250.jpg?rev=626571\";}s:11:\"banners_rtl\";a:0:{}}s:37:\"disable-comments/disable-comments.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:30:\"w.org/plugins/disable-comments\";s:4:\"slug\";s:16:\"disable-comments\";s:6:\"plugin\";s:37:\"disable-comments/disable-comments.php\";s:11:\"new_version\";s:5:\"1.9.0\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/disable-comments/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/plugin/disable-comments.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/disable-comments/assets/icon-256x256.png?rev=971176\";s:2:\"1x\";s:68:\"https://ps.w.org/disable-comments/assets/icon-128x128.png?rev=971176\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/disable-comments/assets/banner-1544x500.png?rev=1652560\";s:2:\"1x\";s:71:\"https://ps.w.org/disable-comments/assets/banner-772x250.png?rev=1652560\";}s:11:\"banners_rtl\";a:0:{}}s:33:\"duplicate-post/duplicate-post.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/duplicate-post\";s:4:\"slug\";s:14:\"duplicate-post\";s:6:\"plugin\";s:33:\"duplicate-post/duplicate-post.php\";s:11:\"new_version\";s:5:\"3.2.2\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/duplicate-post/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/duplicate-post.3.2.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/duplicate-post/assets/icon-256x256.png?rev=1612753\";s:2:\"1x\";s:67:\"https://ps.w.org/duplicate-post/assets/icon-128x128.png?rev=1612753\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:69:\"https://ps.w.org/duplicate-post/assets/banner-772x250.png?rev=1612986\";}s:11:\"banners_rtl\";a:0:{}}s:45:\"enable-media-replace/enable-media-replace.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:34:\"w.org/plugins/enable-media-replace\";s:4:\"slug\";s:20:\"enable-media-replace\";s:6:\"plugin\";s:45:\"enable-media-replace/enable-media-replace.php\";s:11:\"new_version\";s:5:\"3.2.9\";s:3:\"url\";s:51:\"https://wordpress.org/plugins/enable-media-replace/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/enable-media-replace.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/enable-media-replace/assets/icon-256x256.png?rev=1940728\";s:2:\"1x\";s:73:\"https://ps.w.org/enable-media-replace/assets/icon-128x128.png?rev=1940728\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/enable-media-replace/assets/banner-1544x500.png?rev=1940728\";s:2:\"1x\";s:75:\"https://ps.w.org/enable-media-replace/assets/banner-772x250.png?rev=1940728\";}s:11:\"banners_rtl\";a:0:{}}s:21:\"flamingo/flamingo.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:22:\"w.org/plugins/flamingo\";s:4:\"slug\";s:8:\"flamingo\";s:6:\"plugin\";s:21:\"flamingo/flamingo.php\";s:11:\"new_version\";s:3:\"1.9\";s:3:\"url\";s:39:\"https://wordpress.org/plugins/flamingo/\";s:7:\"package\";s:55:\"https://downloads.wordpress.org/plugin/flamingo.1.9.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/flamingo/assets/icon-128x128.png?rev=1540977\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:62:\"https://ps.w.org/flamingo/assets/banner-772x250.png?rev=544829\";}s:11:\"banners_rtl\";a:0:{}}s:19:\"mailgun/mailgun.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:21:\"w.org/plugins/mailgun\";s:4:\"slug\";s:7:\"mailgun\";s:6:\"plugin\";s:19:\"mailgun/mailgun.php\";s:11:\"new_version\";s:5:\"1.7.1\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/mailgun/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/mailgun.1.7.1.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:58:\"https://s.w.org/plugins/geopattern-icon/mailgun_6d494f.svg\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/mailgun/assets/banner-772x250.jpg?rev=628208\";}s:11:\"banners_rtl\";a:0:{}}s:39:\"mce-table-buttons/mce_table_buttons.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:31:\"w.org/plugins/mce-table-buttons\";s:4:\"slug\";s:17:\"mce-table-buttons\";s:6:\"plugin\";s:39:\"mce-table-buttons/mce_table_buttons.php\";s:11:\"new_version\";s:3:\"3.3\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/mce-table-buttons/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/mce-table-buttons.3.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/mce-table-buttons/assets/icon-256x256.png?rev=971854\";s:2:\"1x\";s:69:\"https://ps.w.org/mce-table-buttons/assets/icon-128x128.png?rev=971854\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/mce-table-buttons/assets/banner-1544x500.png?rev=971854\";s:2:\"1x\";s:71:\"https://ps.w.org/mce-table-buttons/assets/banner-772x250.png?rev=971854\";}s:11:\"banners_rtl\";a:0:{}}s:27:\"ninja-forms/ninja-forms.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:25:\"w.org/plugins/ninja-forms\";s:4:\"slug\";s:11:\"ninja-forms\";s:6:\"plugin\";s:27:\"ninja-forms/ninja-forms.php\";s:11:\"new_version\";s:6:\"3.4.10\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/ninja-forms/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/ninja-forms.3.4.10.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/ninja-forms/assets/icon-256x256.png?rev=1649747\";s:2:\"1x\";s:64:\"https://ps.w.org/ninja-forms/assets/icon-128x128.png?rev=1649747\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/ninja-forms/assets/banner-1544x500.png?rev=2069024\";s:2:\"1x\";s:66:\"https://ps.w.org/ninja-forms/assets/banner-772x250.png?rev=2069024\";}s:11:\"banners_rtl\";a:0:{}}s:33:\"pdf-thumbnails/pdf-thumbnails.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/pdf-thumbnails\";s:4:\"slug\";s:14:\"pdf-thumbnails\";s:6:\"plugin\";s:33:\"pdf-thumbnails/pdf-thumbnails.php\";s:11:\"new_version\";s:5:\"2.2.0\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/pdf-thumbnails/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/pdf-thumbnails.2.2.0.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:58:\"https://s.w.org/plugins/geopattern-icon/pdf-thumbnails.svg\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}}s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:35:\"w.org/plugins/regenerate-thumbnails\";s:4:\"slug\";s:21:\"regenerate-thumbnails\";s:6:\"plugin\";s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";s:11:\"new_version\";s:5:\"3.1.0\";s:3:\"url\";s:52:\"https://wordpress.org/plugins/regenerate-thumbnails/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/regenerate-thumbnails.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:74:\"https://ps.w.org/regenerate-thumbnails/assets/icon-128x128.png?rev=1753390\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/regenerate-thumbnails/assets/banner-1544x500.jpg?rev=1753390\";s:2:\"1x\";s:76:\"https://ps.w.org/regenerate-thumbnails/assets/banner-772x250.jpg?rev=1753390\";}s:11:\"banners_rtl\";a:0:{}}s:57:\"scalable-vector-graphics-svg/scalable-vector-graphics.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:42:\"w.org/plugins/scalable-vector-graphics-svg\";s:4:\"slug\";s:28:\"scalable-vector-graphics-svg\";s:6:\"plugin\";s:57:\"scalable-vector-graphics-svg/scalable-vector-graphics.php\";s:11:\"new_version\";s:3:\"3.4\";s:3:\"url\";s:59:\"https://wordpress.org/plugins/scalable-vector-graphics-svg/\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/plugin/scalable-vector-graphics-svg.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:73:\"https://ps.w.org/scalable-vector-graphics-svg/assets/icon.svg?rev=1591449\";s:3:\"svg\";s:73:\"https://ps.w.org/scalable-vector-graphics-svg/assets/icon.svg?rev=1591449\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}}s:53:\"simple-custom-post-order/simple-custom-post-order.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:38:\"w.org/plugins/simple-custom-post-order\";s:4:\"slug\";s:24:\"simple-custom-post-order\";s:6:\"plugin\";s:53:\"simple-custom-post-order/simple-custom-post-order.php\";s:11:\"new_version\";s:5:\"2.4.3\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/simple-custom-post-order/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/simple-custom-post-order.2.4.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/simple-custom-post-order/assets/icon-256x256.jpg?rev=1859717\";s:2:\"1x\";s:77:\"https://ps.w.org/simple-custom-post-order/assets/icon-256x256.jpg?rev=1859717\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:79:\"https://ps.w.org/simple-custom-post-order/assets/banner-772x250.jpg?rev=1859717\";}s:11:\"banners_rtl\";a:0:{}}s:43:\"sticky-posts-switch/sticky-posts-switch.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:33:\"w.org/plugins/sticky-posts-switch\";s:4:\"slug\";s:19:\"sticky-posts-switch\";s:6:\"plugin\";s:43:\"sticky-posts-switch/sticky-posts-switch.php\";s:11:\"new_version\";s:5:\"1.9.2\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/sticky-posts-switch/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/sticky-posts-switch.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/sticky-posts-switch/assets/icon-256x256.jpg?rev=1631517\";s:2:\"1x\";s:72:\"https://ps.w.org/sticky-posts-switch/assets/icon-128x128.jpg?rev=1631517\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/sticky-posts-switch/assets/banner-1544x500.jpg?rev=1631702\";s:2:\"1x\";s:74:\"https://ps.w.org/sticky-posts-switch/assets/banner-772x250.jpg?rev=1631702\";}s:11:\"banners_rtl\";a:0:{}}s:43:\"wp-instagram-widget/wp-instagram-widget.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:33:\"w.org/plugins/wp-instagram-widget\";s:4:\"slug\";s:19:\"wp-instagram-widget\";s:6:\"plugin\";s:43:\"wp-instagram-widget/wp-instagram-widget.php\";s:11:\"new_version\";s:5:\"2.0.3\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/wp-instagram-widget/\";s:7:\"package\";s:68:\"https://downloads.wordpress.org/plugin/wp-instagram-widget.2.0.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/wp-instagram-widget/assets/icon-256x256.png?rev=1155549\";s:2:\"1x\";s:72:\"https://ps.w.org/wp-instagram-widget/assets/icon-128x128.png?rev=1155549\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/wp-instagram-widget/assets/banner-1544x500.png?rev=1155549\";s:2:\"1x\";s:74:\"https://ps.w.org/wp-instagram-widget/assets/banner-772x250.png?rev=1155549\";}s:11:\"banners_rtl\";a:0:{}}s:51:\"youtube-channel-gallery/youtube-channel-gallery.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:37:\"w.org/plugins/youtube-channel-gallery\";s:4:\"slug\";s:23:\"youtube-channel-gallery\";s:6:\"plugin\";s:51:\"youtube-channel-gallery/youtube-channel-gallery.php\";s:11:\"new_version\";s:3:\"2.4\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/youtube-channel-gallery/\";s:7:\"package\";s:70:\"https://downloads.wordpress.org/plugin/youtube-channel-gallery.2.4.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:76:\"https://ps.w.org/youtube-channel-gallery/assets/icon-128x128.png?rev=1175102\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/youtube-channel-gallery/assets/banner-1544x500.png?rev=1175102\";s:2:\"1x\";s:78:\"https://ps.w.org/youtube-channel-gallery/assets/banner-772x250.png?rev=1175102\";}s:11:\"banners_rtl\";a:0:{}}}}','no'),
	(696,'_site_transient_update_themes','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1555995973;s:7:\"checked\";a:1:{s:2:\"sg\";s:3:\"1.0\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}}','no'),
	(698,'_site_transient_timeout_theme_roots','1555997772','no'),
	(699,'_site_transient_theme_roots','a:1:{s:2:\"sg\";s:7:\"/themes\";}','no'),
	(700,'_transient_timeout_acf_plugin_updates','1556082236','no'),
	(701,'_transient_acf_plugin_updates','a:4:{s:7:\"plugins\";a:0:{}s:10:\"expiration\";i:86400;s:6:\"status\";i:1;s:7:\"checked\";a:1:{s:34:\"advanced-custom-fields-pro/acf.php\";s:6:\"5.7.13\";}}','no'),
	(703,'_site_transient_timeout_browser_12864c2b9e076f38c6ce47669c990ca1','1556600724','no'),
	(704,'_site_transient_browser_12864c2b9e076f38c6ce47669c990ca1','a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:13:\"73.0.3683.103\";s:8:\"platform\";s:9:\"Macintosh\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}','no'),
	(705,'_site_transient_timeout_php_check_c10b24bcda05543594ded94839f19c88','1556600726','no'),
	(706,'_site_transient_php_check_c10b24bcda05543594ded94839f19c88','a:5:{s:19:\"recommended_version\";s:3:\"7.3\";s:15:\"minimum_version\";s:5:\"5.2.4\";s:12:\"is_supported\";b:0;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}','no'),
	(709,'theme_mods_sg','a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;}','yes'),
	(710,'_transient_timeout_plugin_slugs','1556082477','no'),
	(711,'_transient_plugin_slugs','a:21:{i:0;s:34:\"advanced-custom-fields-pro/acf.php\";i:1;s:33:\"classic-editor/classic-editor.php\";i:2;s:36:\"contact-form-7/wp-contact-form-7.php\";i:3;s:35:\"crop-thumbnails/crop-thumbnails.php\";i:4;s:37:\"disable-comments/disable-comments.php\";i:5;s:33:\"duplicate-post/duplicate-post.php\";i:6;s:45:\"enable-media-replace/enable-media-replace.php\";i:7;s:21:\"flamingo/flamingo.php\";i:8;s:19:\"mailgun/mailgun.php\";i:9;s:39:\"mce-table-buttons/mce_table_buttons.php\";i:10;s:27:\"ninja-forms/ninja-forms.php\";i:11;s:41:\"ninja-forms-conditionals/conditionals.php\";i:12;s:39:\"ninja-forms-style/ninja-forms-style.php\";i:13;s:37:\"ninja-forms-multi-part/multi-part.php\";i:14;s:33:\"pdf-thumbnails/pdf-thumbnails.php\";i:15;s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";i:16;s:57:\"scalable-vector-graphics-svg/scalable-vector-graphics.php\";i:17;s:53:\"simple-custom-post-order/simple-custom-post-order.php\";i:18;s:43:\"sticky-posts-switch/sticky-posts-switch.php\";i:19;s:43:\"wp-instagram-widget/wp-instagram-widget.php\";i:20;s:51:\"youtube-channel-gallery/youtube-channel-gallery.php\";}','no');

/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_postmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_postmeta`;

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`)
VALUES
	(8,6,'_edit_last','1'),
	(9,6,'_edit_lock','1484171530:1'),
	(10,8,'_edit_last','1'),
	(11,8,'_edit_lock','1484171590:1'),
	(12,10,'_form','<label> Your Name (required)\n    [text* your-name] </label>\n\n<label> Your Email (required)\n    [email* your-email] </label>\n\n<label> Subject\n    [text your-subject] </label>\n\n<label> Your Message\n    [textarea your-message] </label>\n\n[submit \"Send\"]'),
	(13,10,'_mail','a:8:{s:7:\"subject\";s:27:\"SITE TITLE \"[your-subject]\"\";s:6:\"sender\";s:38:\"[your-name] <wordpress@legpress.local>\";s:4:\"body\";s:163:\"From: [your-name] <[your-email]>\nSubject: [your-subject]\n\nMessage Body:\n[your-message]\n\n--\nThis e-mail was sent from a contact form on SITE TITLE (http://sg.local)\";s:9:\"recipient\";s:20:\"devs@mylogins.com.au\";s:18:\"additional_headers\";s:22:\"Reply-To: [your-email]\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";i:0;s:13:\"exclude_blank\";i:0;}'),
	(14,10,'_mail_2','a:9:{s:6:\"active\";b:0;s:7:\"subject\";s:27:\"SITE TITLE \"[your-subject]\"\";s:6:\"sender\";s:37:\"SITE TITLE <wordpress@legpress.local>\";s:4:\"body\";s:105:\"Message Body:\n[your-message]\n\n--\nThis e-mail was sent from a contact form on SITE TITLE (http://sg.local)\";s:9:\"recipient\";s:12:\"[your-email]\";s:18:\"additional_headers\";s:30:\"Reply-To: devs@mylogins.com.au\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";i:0;s:13:\"exclude_blank\";i:0;}'),
	(15,10,'_messages','a:8:{s:12:\"mail_sent_ok\";s:45:\"Thank you for your message. It has been sent.\";s:12:\"mail_sent_ng\";s:71:\"There was an error trying to send your message. Please try again later.\";s:16:\"validation_error\";s:61:\"One or more fields have an error. Please check and try again.\";s:4:\"spam\";s:71:\"There was an error trying to send your message. Please try again later.\";s:12:\"accept_terms\";s:69:\"You must accept the terms and conditions before sending your message.\";s:16:\"invalid_required\";s:22:\"The field is required.\";s:16:\"invalid_too_long\";s:22:\"The field is too long.\";s:17:\"invalid_too_short\";s:23:\"The field is too short.\";}'),
	(16,10,'_additional_settings',NULL),
	(17,10,'_locale','en_AU'),
	(18,11,'_email','devs@mylogins.com.au'),
	(19,11,'_name','admin'),
	(20,11,'_props','a:2:{s:10:\"first_name\";s:0:\"\";s:9:\"last_name\";s:0:\"\";}'),
	(21,11,'_last_contacted','2017-01-12 07:56:23'),
	(22,12,'_edit_last','1'),
	(23,12,'_edit_lock','1555906723:1'),
	(32,20,'_edit_last','1'),
	(33,20,'_edit_lock','1504052332:1');

/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_posts`;

CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
VALUES
	(6,1,'2017-01-11 21:54:22','2017-01-11 21:54:22','Welcome to this website!','Home','','publish','closed','closed','','home','','','2017-01-11 21:54:22','2017-01-11 21:54:22','',0,'http://sg.local/?page_id=6',0,'page','',0),
	(7,1,'2017-01-11 21:54:22','2017-01-11 21:54:22','Welcome to this website!','Home','','inherit','closed','closed','','6-revision-v1','','','2017-01-11 21:54:22','2017-01-11 21:54:22','',6,'http://sg.local/2017/01/11/6-revision-v1/',0,'revision','',0),
	(8,1,'2017-01-12 07:55:33','2017-01-11 21:55:33','','News','','publish','closed','closed','','news','','','2017-01-12 07:55:33','2017-01-11 21:55:33','',0,'http://sg.local/?page_id=8',0,'page','',0),
	(9,1,'2017-01-12 07:55:33','2017-01-11 21:55:33','','News','','inherit','closed','closed','','8-revision-v1','','','2017-01-12 07:55:33','2017-01-11 21:55:33','',8,'http://sg.local/2017/01/12/8-revision-v1/',0,'revision','',0),
	(10,1,'2017-01-12 07:56:23','2017-01-11 21:56:23','<label> Your Name (required)\n    [text* your-name] </label>\n\n<label> Your Email (required)\n    [email* your-email] </label>\n\n<label> Subject\n    [text your-subject] </label>\n\n<label> Your Message\n    [textarea your-message] </label>\n\n[submit \"Send\"]\nSITE TITLE \"[your-subject]\"\n[your-name] <wordpress@legpress.local>\nFrom: [your-name] <[your-email]>\nSubject: [your-subject]\n\nMessage Body:\n[your-message]\n\n--\nThis e-mail was sent from a contact form on SITE TITLE (http://sg.local)\ndevs@mylogins.com.au\nReply-To: [your-email]\n\n0\n0\n\nSITE TITLE \"[your-subject]\"\nSITE TITLE <wordpress@legpress.local>\nMessage Body:\n[your-message]\n\n--\nThis e-mail was sent from a contact form on SITE TITLE (http://sg.local)\n[your-email]\nReply-To: devs@mylogins.com.au\n\n0\n0\nThank you for your message. It has been sent.\nThere was an error trying to send your message. Please try again later.\nOne or more fields have an error. Please check and try again.\nThere was an error trying to send your message. Please try again later.\nYou must accept the terms and conditions before sending your message.\nThe field is required.\nThe field is too long.\nThe field is too short.','Contact form 1','','publish','closed','closed','','contact-form-1','','','2017-01-12 07:56:23','2017-01-11 21:56:23','',0,'http://sg.local/?post_type=wpcf7_contact_form&p=10',0,'wpcf7_contact_form','',0),
	(11,1,'2017-01-12 07:56:23','2017-01-11 21:56:23','devs@mylogins.com.au\nadmin','devs@mylogins.com.au','','publish','closed','closed','','matt-dwyer-yourtemporary-com','','','2017-01-12 07:56:23','2017-01-11 21:56:23','',0,'http://sg.local/matt-dwyer-yourtemporary-com/',0,'flamingo_contact','',0),
	(12,1,'2017-01-12 08:15:05','2017-01-11 22:15:05','a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:12:\"options_page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:25:\"acf-options-theme-options\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:8:\"seamless\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}','Theme Options','theme-options','publish','closed','closed','','group_5876ae3e825e9','','','2019-04-22 14:21:04','2019-04-22 04:21:04','',0,'http://sg.local/?post_type=acf-field-group&#038;p=12',0,'acf-field-group','',0),
	(13,1,'2017-01-12 08:15:05','2017-01-11 22:15:05','a:10:{s:4:\"type\";s:7:\"wysiwyg\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:4:\"tabs\";s:3:\"all\";s:7:\"toolbar\";s:4:\"full\";s:12:\"media_upload\";i:1;s:5:\"delay\";i:0;}','Message','message','publish','closed','closed','','field_5876ae4b3746e','','','2019-04-22 14:21:04','2019-04-22 04:21:04','',24,'http://sg.local/?post_type=acf-field&#038;p=13',0,'acf-field','',0),
	(20,1,'2017-08-30 10:21:05','2017-08-30 00:21:05','a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:9:\"post_type\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:4:\"page\";}}}s:8:\"position\";s:4:\"side\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}','Page Behaviour','page-behaviour','publish','closed','closed','','group_59a604b2bc5a0','','','2017-08-30 10:21:05','2017-08-30 00:21:05','',0,'http://sg.local/?post_type=acf-field-group&#038;p=20',0,'acf-field-group','',0),
	(21,1,'2017-08-30 10:21:05','2017-08-30 00:21:05','a:10:{s:4:\"type\";s:10:\"true_false\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:7:\"message\";s:27:\"Make this page inaccessible\";s:13:\"default_value\";i:0;s:2:\"ui\";i:0;s:10:\"ui_on_text\";s:0:\"\";s:11:\"ui_off_text\";s:0:\"\";}','Reroute to 404','page_inaccessible','publish','closed','closed','','field_59a604c5cf2cf','','','2017-08-30 10:21:05','2017-08-30 00:21:05','',20,'http://sg.local/?post_type=acf-field&p=21',0,'acf-field','',0),
	(22,1,'2017-08-30 10:21:05','2017-08-30 00:21:05','a:6:{s:4:\"type\";s:4:\"link\";s:12:\"instructions\";s:61:\"Redirect the user to the given URL when they access this page\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"return_format\";s:5:\"array\";}','Redirect','page_redirect','publish','closed','closed','','field_59a604dbcf2d0','','','2017-08-30 10:21:05','2017-08-30 00:21:05','',20,'http://sg.local/?post_type=acf-field&p=22',1,'acf-field','',0),
	(23,1,'2019-04-22 14:20:22','0000-00-00 00:00:00','','Auto Draft','','auto-draft','closed','closed','','','','','2019-04-22 14:20:22','0000-00-00 00:00:00','',0,'http://sg.local/?p=23',0,'post','',0),
	(24,1,'2019-04-22 14:21:04','2019-04-22 04:21:04','a:7:{s:4:\"type\";s:5:\"group\";s:12:\"instructions\";s:76:\"This will be displayed whenever the user accesses a page that doesn\'t exist.\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:6:\"layout\";s:5:\"block\";s:10:\"sub_fields\";a:0:{}}','404 page','404','publish','closed','closed','','field_5cbd41119b1e7','','','2019-04-22 14:21:04','2019-04-22 04:21:04','',12,'http://sg.local/?post_type=acf-field&p=24',0,'acf-field','',0);

/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_term_relationships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_term_relationships`;

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table wp_term_taxonomy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_term_taxonomy`;

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`)
VALUES
	(1,1,'category','',0,0),
	(2,2,'post_visibility','',0,0);

/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_termmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_termmeta`;

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table wp_terms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_terms`;

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  `term_order` int(4) DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`, `term_order`)
VALUES
	(1,'Uncategorised','uncategorised',0,0),
	(2,'sticky','sticky',0,0);

/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_usermeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_usermeta`;

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`)
VALUES
	(1,1,'nickname','admin'),
	(2,1,'first_name',''),
	(3,1,'last_name',''),
	(4,1,'description',''),
	(5,1,'rich_editing','true'),
	(6,1,'comment_shortcuts','false'),
	(7,1,'admin_color','fresh'),
	(8,1,'use_ssl','0'),
	(9,1,'show_admin_bar_front','true'),
	(10,1,'locale',''),
	(11,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),
	(12,1,'wp_user_level','10'),
	(13,1,'dismissed_wp_pointers','wp496_privacy'),
	(14,1,'show_welcome_panel','0'),
	(15,1,'session_tokens','a:4:{s:64:\"dc3c1421d8f69f72daedefdcd033bb38d86f56bf232982754d1367756525b5da\";a:4:{s:10:\"expiration\";i:1556079621;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:82:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:66.0) Gecko/20100101 Firefox/66.0\";s:5:\"login\";i:1555906821;}s:64:\"92acda6c61c2f328b4d79ba31aada290480e1d85568c2574a999fdf3f3f06e9d\";a:4:{s:10:\"expiration\";i:1556168722;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36\";s:5:\"login\";i:1555995922;}s:64:\"648c8a4b140084d2c877846f17730f654ef083f30923aa18af249c4df7ed1e5b\";a:4:{s:10:\"expiration\";i:1556168723;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36\";s:5:\"login\";i:1555995923;}s:64:\"66b23a280221725826eb7f4e133b0f57fd41a56d587ff320cce83246057ec425\";a:4:{s:10:\"expiration\";i:1556168724;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36\";s:5:\"login\";i:1555995924;}}'),
	(16,1,'wp_dashboard_quick_press_last_post_id','23'),
	(17,1,'wp_user-settings','hidetb=1&mfold=o'),
	(18,1,'wp_user-settings-time','1555995968'),
	(19,1,'closedpostboxes_dashboard','a:0:{}'),
	(20,1,'metaboxhidden_dashboard','a:1:{i:0;s:17:\"dashboard_primary\";}');

/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_users`;

CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`)
VALUES
	(1,'admin','$P$BzzF4e6G7s3jE14VGjuBWyXWLVihAb0','admin','devs@mylogins.com.au','','2017-01-11 21:53:32','',0,'admin');

/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
