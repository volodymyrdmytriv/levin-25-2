/**
* @version 2.0.3 2013-04-08
* @package Joomla
* @subpackage Intellectual Property
* @copyright (C) 2013 the Thinkery
* @license GNU/GPL see LICENSE.php
*/

--
-- Table structure for table `#__iproperty`
--

CREATE TABLE IF NOT EXISTS `#__iproperty` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mls_id` varchar(25) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stype_freq` varchar(200) NOT NULL,
  `listing_office` int(10) unsigned NOT NULL DEFAULT '0',
  `street_num` varchar(20) NOT NULL,
  `street` varchar(255) NOT NULL,
  `street2` varchar(255) NOT NULL,
  `apt` varchar(12) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `hide_address` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `show_map` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `short_description` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `terms` text NOT NULL,
  `agent_notes` text NOT NULL,
  `city` varchar(55) NOT NULL,
  `locstate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `province` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `region` varchar(255) NOT NULL,
  `county` varchar(55) NOT NULL,
  `country` smallint(5) unsigned NOT NULL DEFAULT '0',
  `latitude` varchar(255) NOT NULL DEFAULT '0',
  `longitude` varchar(255) NOT NULL DEFAULT '0',
  `gbase_address` varchar(255) NOT NULL,
  `concat_address` varchar(255) NOT NULL,
  `price` decimal(12,2) unsigned NOT NULL,
  `price2` decimal(12,2) unsigned NOT NULL,
  `call_for_price` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `show_address` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `beds` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `baths` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  `reception` varchar(255) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `income` varchar(100) NOT NULL,
  `sqft` int(10) unsigned NOT NULL DEFAULT '0',
  `lotsize` varchar(100) NOT NULL,
  `lot_acres` varchar(100) NOT NULL,
  `yearbuilt` varchar(20) NOT NULL DEFAULT '0',
  `heat` varchar(100) NOT NULL DEFAULT '0',
  `cool` varchar(100) NOT NULL,
  `fuel` varchar(100) NOT NULL DEFAULT '0',
  `garage_type` varchar(100) NOT NULL DEFAULT '0',
  `garage_size` varchar(100) NOT NULL DEFAULT '0',
  `zoning` varchar(100) NOT NULL DEFAULT '0',
  `frontage` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siding` varchar(100) NOT NULL DEFAULT '0',
  `roof` varchar(100) NOT NULL DEFAULT '0',
  `propview` varchar(100) NOT NULL DEFAULT '0',
  `school_district` varchar(100) NOT NULL DEFAULT '0',
  `lot_type` varchar(100) NOT NULL DEFAULT '0',
  `style` varchar(100) NOT NULL,
  `hoa` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `reo` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `vtour` varchar(125) NOT NULL,
  `video` text NOT NULL,
  `gbase_url` varchar(100) NOT NULL DEFAULT '0',
  `gbase_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `available` date NOT NULL DEFAULT '0000-00-00',
  `metadesc` varchar(255) NOT NULL,
  `metakey` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL,
  `ip_source` char(30) DEFAULT NULL,
  `listing_info` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_source` (`ip_source`),
  KEY `listing_office` (`listing_office`),
  KEY `stype` (`stype`),
  KEY `city` (`city`),
  KEY `locstate` (`locstate`),
  KEY `postcode` (`postcode`),
  KEY `price` (`price`,`sqft`,`beds`,`baths`,`city`,`stype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_agentmid`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_agentmid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prop_id` int(10) unsigned NOT NULL,
  `agent_id` int(10) unsigned NOT NULL,
  `agent_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip_source` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prop_id` (`prop_id`,`agent_id`),
  KEY `agent_id` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_agents`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_agents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `agent_type` tinyint(4) NOT NULL DEFAULT '0',
  `hometeam` tinyint(4) NOT NULL DEFAULT '0',
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `company` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(25) NOT NULL DEFAULT '',
  `mobile` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(25) NOT NULL DEFAULT '',
  `street` varchar(50) NOT NULL,
  `street2` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `locstate` tinyint(3) unsigned NOT NULL,
  `province` varchar(50) NOT NULL,
  `postcode` varchar(15) NOT NULL DEFAULT '',
  `country` smallint(5) unsigned NOT NULL,
  `website` varchar(100) NOT NULL DEFAULT '',
  `bio` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL,
  `icon` varchar(100) NOT NULL DEFAULT '',
  `msn` varchar(100) NOT NULL,
  `skype` varchar(100) NOT NULL,
  `gtalk` varchar(100) NOT NULL,
  `linkedin` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `social1` varchar(100) NOT NULL,
  `alicense` varchar(100) NOT NULL,
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL,
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ip_source` char(30) DEFAULT NULL,
  `params` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_source` (`ip_source`),
  KEY `company` (`company`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_amenities`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_amenities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL,
  `cat` tinyint(3) NOT NULL DEFAULT 1,
  `language` char(7) NOT NULL,
  `ip_source` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Table structure for table `#__iproperty_categories`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `parent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT '',
  `ip_source` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_companies`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_companies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `street` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `locstate` tinyint(3) unsigned NOT NULL,
  `province` varchar(50) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `country` smallint(5) unsigned NOT NULL,
  `fax` varchar(20) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `website` varchar(125) NOT NULL,
  `featured` tinyint(1) unsigned NOT NULL,
  `icon` varchar(125) NOT NULL DEFAULT '',
  `clicense` varchar(100) NOT NULL,
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL,
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `ip_source` char(30) DEFAULT NULL,
  `params` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_source` (`ip_source`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_countries`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `mc_name` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Default list of countries' AUTO_INCREMENT=205 ;

--
-- Table structure for table `#__iproperty_currency`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_currency` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(125) NOT NULL,
  `currency` varchar(225) NOT NULL,
  `curr_abbreviation` varchar(3) NOT NULL,
  `curr_code` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=243 ;

--
-- Table structure for table `#__iproperty_images`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `fname` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(5) NOT NULL DEFAULT '.jpg',
  `path` varchar(255) NOT NULL DEFAULT '',
  `remote` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'set true if remote file',
  `owner` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  `state` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ip_source` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `propid` (`propid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_openhouses`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_openhouses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `prop_id` int(11) NOT NULL,
  `openhouse_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `openhouse_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comments` text NOT NULL DEFAULT '',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `prop_id` (`prop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_propmid`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_propmid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prop_id` int(11) unsigned NOT NULL DEFAULT '0',
  `cat_id` int(11) unsigned NOT NULL DEFAULT '0',
  `amen_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ip_source` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prop_id` (`prop_id`,`cat_id`),
  KEY `prop_id_2` (`prop_id`,`amen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_saved`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_saved` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `prop_id` int(11) NOT NULL DEFAULT '0',
  `notes` varchar(255) NOT NULL DEFAULT '',
  `search_string` varchar(255) NOT NULL DEFAULT '',
  `email_update` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `last_sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__iproperty_settings`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_settings` (
  `id` tinyint(1) NOT NULL DEFAULT '1',
  `offline` tinyint(1) NOT NULL DEFAULT '0',
  `offmessage` varchar(255) NOT NULL DEFAULT '',
  `showtitle` tinyint(1) NOT NULL DEFAULT '0',
  `street_num_pos` tinyint(1) NOT NULL DEFAULT '0',
  `showsold` tinyint(1) NOT NULL DEFAULT '1',
  `showpending` tinyint(1) NOT NULL DEFAULT '1',
  `banner_display` tinyint(1) NOT NULL DEFAULT '1',
  `currency` char(3) NOT NULL DEFAULT '$',
  `currency_digits` tinyint(2) NOT NULL DEFAULT '0',
  `currency_pos` tinyint(1) NOT NULL DEFAULT '1',
  `nformat` tinyint(1) NOT NULL DEFAULT '1',
  `footer` tinyint(1) NOT NULL DEFAULT '1',
  `measurement_units` tinyint(1) NOT NULL DEFAULT '0',
  `send_requests` tinyint(1) NOT NULL DEFAULT '0',
  `copy_admin` tinyint(1) NOT NULL DEFAULT '0',
  `new_days` int(5) NOT NULL DEFAULT '7',
  `updated_days` int(5) NOT NULL DEFAULT '7',
  `rss` int(3) NOT NULL DEFAULT '0',
  `iplayout` tinyint(1) NOT NULL DEFAULT '2',
  `show_scats` tinyint(1) NOT NULL DEFAULT '1',
  `cat_entries` tinyint(1) NOT NULL DEFAULT '1',
  `cat_photo_width` smallint(5) unsigned NOT NULL DEFAULT '60',
  `cat_recursive` tinyint(1) NOT NULL DEFAULT '1',
  `show_featured` tinyint(1) NOT NULL DEFAULT '1',
  `featured_pos` tinyint(1) NOT NULL DEFAULT '1',
  `cat_featured` tinyint(1) NOT NULL DEFAULT '0',
  `cat_featured_pos` tinyint(1) NOT NULL DEFAULT '0',
  `num_featured` tinyint(2) NOT NULL DEFAULT '3',
  `show_sendtofriend` tinyint(1) NOT NULL DEFAULT '1',
  `show_flyer` tinyint(1) NOT NULL DEFAULT '1',
  `show_print` tinyint(1) NOT NULL DEFAULT '0',
  `featured_accent` varchar(10) NOT NULL DEFAULT '#ff0000',
  `perpage` tinyint(2) NOT NULL DEFAULT '20',
  `overview_char` smallint(5) unsigned NOT NULL DEFAULT '200',
  `imgpath` varchar(255) NOT NULL DEFAULT '/media/com_iproperty/pictures/',
  `maximgsize` varchar(20) NOT NULL DEFAULT '7000',
  `maximgs` tinyint(1) NOT NULL DEFAULT '0',
  `gplibrary` varchar(20) NOT NULL DEFAULT 'gd2',
  `imgwidth` smallint(5) unsigned NOT NULL DEFAULT '640',
  `imgheight` smallint(5) unsigned DEFAULT NULL,
  `imgproportion` tinyint(1) NOT NULL DEFAULT '1',
  `imgquality` tinyint(2) NOT NULL DEFAULT '90',
  `watermark` tinyint(1) NOT NULL DEFAULT '1',
  `watermark_text` varchar(255) NOT NULL DEFAULT 'Watermark',
  `thumbwidth` smallint(5) unsigned NOT NULL DEFAULT '100',
  `thumbheight` smallint(5) unsigned DEFAULT NULL,
  `thumbproportion` tinyint(1) NOT NULL DEFAULT '1',
  `thumbquality` tinyint(3) unsigned NOT NULL DEFAULT '100',
  `googlemap_enable` tinyint(1) NOT NULL DEFAULT '1',
  `accent` varchar(7) NOT NULL DEFAULT '',
  `secondary_accent` varchar(7) NOT NULL DEFAULT '',
  `force_accents` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `gallery_width` smallint(5) unsigned NOT NULL DEFAULT '700',
  `gallery_height` smallint(5) unsigned NOT NULL DEFAULT '400',
  `gallerytype` tinyint(1) NOT NULL DEFAULT '1',
  `tab_width` smallint(5) unsigned NOT NULL DEFAULT '300',
  `tab_height` smallint(5) unsigned NOT NULL DEFAULT '275',
  `flyer_logo` varchar(255) NOT NULL,
  `flyer_email` varchar(200) NOT NULL,
  `flyer_phone` varchar(25) NOT NULL,
  `flyer_tinyurl` tinyint(1) NOT NULL DEFAULT '1',
  `disclaimer` text NOT NULL,
  `notify_sendfriend` tinyint(1) NOT NULL DEFAULT '1',
  `notify_saveprop` tinyint(1) NOT NULL DEFAULT '1',
  `notify_newprop` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `moderate_listings` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notify_savesearch` tinyint(1) NOT NULL DEFAULT '1',  
  `form_recipient` tinyint(1) NOT NULL DEFAULT '0',
  `form_copyadmin` tinyint(1) NOT NULL DEFAULT '0',
  `form_storeforms` tinyint(1) NOT NULL DEFAULT '0',
  `require_login` tinyint(1) NOT NULL DEFAULT '0',
  `edit_rights` tinyint(1) NOT NULL DEFAULT '0',
  `auto_publish` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auto_agent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `approval_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `show_saveproperty` tinyint(1) NOT NULL DEFAULT '1',
  `show_savesearch` tinyint(1) NOT NULL DEFAULT '1',
  `show_propupdate` tinyint(1) NOT NULL DEFAULT '0',
  `show_searchupdate` tinyint(1) NOT NULL DEFAULT '0',
  `show_mtgcalc` tinyint(1) NOT NULL DEFAULT '1',
  `show_agent` tinyint(1) NOT NULL DEFAULT '1',
  `agent_photo_width` smallint(5) unsigned NOT NULL DEFAULT '90',
  `agent_show_image` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_address` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_contact` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_email` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_fax` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_mobile` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_phone` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_website` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_featured` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_social` tinyint(1) NOT NULL DEFAULT '1',
  `agent_show_license` tinyint(1) NOT NULL DEFAULT '1',
  `agent_feat_num` tinyint(2) NOT NULL DEFAULT '5',
  `agent_feat_pos` tinyint(1) NOT NULL DEFAULT '1',
  `company_photo_width` smallint(5) unsigned NOT NULL DEFAULT '90',
  `co_show_image` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_address` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_contact` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_email` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_fax` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_phone` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_website` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_featured` tinyint(1) NOT NULL DEFAULT '1',
  `co_show_license` tinyint(1) NOT NULL DEFAULT '1',
  `co_feat_num` tinyint(2) NOT NULL DEFAULT '5',
  `co_feat_pos` tinyint(1) NOT NULL DEFAULT '1',
  `qs_show_keyword` tinyint(1) NOT NULL DEFAULT '1',
  `qs_show_cat` tinyint(1) NOT NULL DEFAULT '1',
  `qs_show_stype` tinyint(1) NOT NULL DEFAULT '1',
  `qs_show_country` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_city` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_state` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_province` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_county` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_region` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_minbeds` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_minbaths` tinyint(1) NOT NULL DEFAULT '0',
  `qs_show_price` tinyint(1) NOT NULL DEFAULT '0',
  `adv_price_low` int(10) unsigned NOT NULL DEFAULT '50000',
  `adv_price_high` int(10) unsigned NOT NULL DEFAULT '1000000',
  `adv_beds_low` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `adv_beds_high` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `adv_baths_low` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `adv_baths_high` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `adv_sqft_low` smallint(5) unsigned NOT NULL DEFAULT '900',
  `adv_sqft_high` smallint(5) unsigned NOT NULL DEFAULT '20000',
  `adv_default_lat` varchar(100) NOT NULL DEFAULT '47.6725282',
  `adv_default_long` varchar(100) NOT NULL DEFAULT '-116.7679661',
  `adv_default_zoom` tinyint(2) NOT NULL DEFAULT '13',
  `adv_show_hoa` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_reo` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_wf` tinyint(1) NOT NULL DEFAULT '0',
  `adv_maptype` varchar(50) NOT NULL DEFAULT 'ROADMAP',
  `adv_show_stype` tinyint(1) NOT NULL DEFAULT '1',
  `adv_show_preview` tinyint(1) NOT NULL DEFAULT '1',
  `adv_show_country` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_county` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_region` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_locstate` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_province` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_thumb` tinyint(1) NOT NULL DEFAULT '1',
  `adv_show_amen` tinyint(1) NOT NULL DEFAULT '0',
  `adv_show_shapetools` tinyint(1) NOT NULL DEFAULT '1',
  `adv_perpage` smallint(6) NOT NULL DEFAULT '20',
  `adv_nolimit` tinyint(1) NOT NULL DEFAULT '0',
  `default_state` int(11) NOT NULL DEFAULT '0',
  `default_company` int(11) NOT NULL DEFAULT '0',
  `default_agent` int(11) NOT NULL DEFAULT '0',
  `default_category` int(11) NOT NULL DEFAULT '0',
  `default_country` int(11) NOT NULL DEFAULT '0',
  `default_a_sort` varchar(20) NOT NULL DEFAULT 'a.ordering',
  `default_a_order` varchar(4) NOT NULL DEFAULT 'ASC',
  `default_c_sort` varchar(20) NOT NULL DEFAULT 'ordering',
  `default_c_order` varchar(4) NOT NULL DEFAULT 'ASC',
  `default_p_sort` varchar(20) NOT NULL DEFAULT 'p.price',
  `default_p_order` varchar(4) NOT NULL DEFAULT 'DESC',
  `baths_fraction` tinyint(1) NOT NULL DEFAULT '1',
  `default_currency` varchar(4) NOT NULL,
  `pro_api_key` varchar(125) NOT NULL,
  `pro_last_run` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pro_show_search` tinyint(4) NOT NULL,
  `pro_propview_position` tinyint(4) NOT NULL,
  `feed_gbase` tinyint(1) NOT NULL DEFAULT '0',
  `feed_gbaseuk` tinyint(1) NOT NULL DEFAULT '0',
  `feed_zillow` tinyint(1) NOT NULL DEFAULT '0',
  `feed_kml` tinyint(1) NOT NULL DEFAULT '0',
  `max_zoom` tinyint(2) NOT NULL DEFAULT '21',
  `ie_expire` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `#__iproperty_states`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_states` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `mc_name` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Default list of states' AUTO_INCREMENT=52 ;

--
-- Table structure for table `#__iproperty_stypes`
--

CREATE TABLE IF NOT EXISTS `#__iproperty_stypes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `banner_image` varchar(255) NOT NULL DEFAULT '',
  `banner_color` varchar(7) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `show_banner` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
