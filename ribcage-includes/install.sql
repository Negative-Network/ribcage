-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 09, 2014 at 09:10 PM
-- Server version: 5.5.32-log
-- PHP Version: 5.4.25-pl0-gentoo

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vkwp`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_artists`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_artists` (
  `artist_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique artist ID.',
  `artist_name` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'The artist''s name.',
  `artist_name_sort` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'The name the artist is sorted by eg Butterfly, The.',
  `artist_slug` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'The name of the artist without punctuation, for a link. http://recordsonribs.com/artists/{artist_slug}',
  `artist_mbid` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Artist''s Music Brainz ID.',
  `artist_signed` date NOT NULL COMMENT 'The date the artist signed with us.',
  `artist_license` enum('by-nc-sa','by','by-nc','by-nd','by-sa','by-nc-nd') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Creative Commons license for artist (default) see http://en.wikipedia.org/wiki/Creative_Commons_licenses',
  `artist_bio` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'A long biography of the artist.',
  `artist_thumb` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `artist_picture_1` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A URL of a fairly large picture of the artist (1-3).',
  `artist_picture_2` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A URL of a fairly large picture of the artist (2-3).',
  `artist_picture_3` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A URL of a fairly large picture of the artist (3-3).',
  `artist_picture_zip` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A file location of a zip file containing high quality images of the artists for the press.',
  `artist_contact_email` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'E-mail address of the artist',
  `artist_contact_phone` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Phone number of the artist',
  `artist_blurb_tiny` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'A very short description of the artist (one sentence)',
  `artist_blurb_short` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Short description of the artist (one paragraph).',
  `artist_link_website` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'The artist''s website.',
  `artist_link_myspace` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'The artist''s myspace link.',
  `artist_link_facebook` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'URL of Facebook Group',
  PRIMARY KEY (`artist_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_donations`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_donations` (
  `donate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `donate_ipn` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`donate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_log_download_releases`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_log_download_releases` (
  `download_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `download_release_id` bigint(20) NOT NULL,
  `download_time` datetime NOT NULL,
  `download_user` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `download_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `download_format` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_log_download_tracks`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_log_download_tracks` (
  `download_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `download_track_id` bigint(20) NOT NULL,
  `download_time` datetime NOT NULL,
  `download_user` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `download_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `download_format` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_log_stream`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_log_stream` (
  `stream_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stream_track_id` bigint(20) NOT NULL,
  `stream_time` datetime NOT NULL,
  `stream_duration` bigint(20) NOT NULL,
  `stream_state` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `stream_user` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `stream_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`stream_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_orders`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_orders` (
  `order_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID of the order for tracking purposes',
  `order_product` bigint(20) NOT NULL COMMENT 'Product ID of the order',
  `order_paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has this been paid for?',
  `order_ipn` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Ribcage database to handle incoming orders from the shop.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_products`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_products` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID of the actual product',
  `product_related_release` bigint(20) NOT NULL COMMENT 'Release that this product is related to, if neccesary.',
  `product_name` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name of the product',
  `product_description` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description of product.',
  `product_cost` float NOT NULL COMMENT 'Cost of product in pounds stirling.',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_releases`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_releases` (
  `release_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A unique ID for the release.',
  `release_catalogue_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `release_artist` bigint(20) NOT NULL COMMENT 'The artist ID related to the release - this is then looked up in the artists database.',
  `release_date` date NOT NULL COMMENT 'The release date.',
  `release_title` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'The title of the release.',
  `release_slug` text COLLATE utf8_unicode_ci NOT NULL,
  `release_time` time NOT NULL COMMENT 'The total time of the release.',
  `release_mbid` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Musicbrainz ID of the release.',
  `release_blurb_tiny` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'A very short (one sentence) blurb for the release.',
  `release_cover_image_tiny` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `release_cover_image_large` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A URL of a large image of the cover.',
  `release_cover_image_huge` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Huge version of the cover, for press use.',
  `release_one_sheet` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'The URL of the onesheet of the release.',
  `release_blurb_short` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'A short blurb about the release.',
  `release_blurb_long` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'A long blurb about the release.',
  `release_tracks_no` bigint(20) NOT NULL COMMENT 'How many tracks are on the release?',
  `release_mp3` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'File location of the MP3 zip file.',
  `release_ogg` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'File location of the Ogg Vobris zip file.',
  `release_flac` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'File location of the FLAC zip file.',
  `release_torrent_mp3` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'URL of a torrent for the complete release.',
  `release_downloads` bigint(20) NOT NULL COMMENT 'How many times has the complete release been downloaded?',
  `release_physical` tinyint(1) NOT NULL COMMENT 'Do we have a physical as well?',
  `release_physical_cat_no` smallint(6) NOT NULL COMMENT 'The catalogue number of the physical release. (Normally one greater than the download release ID)',
  `release_torrent_ogg` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `release_torrent_flac` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `release_allow_download` tinyint(4) NOT NULL DEFAULT '0',
  `release_allow_torrent` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`release_id`),
  UNIQUE KEY `release_id` (`release_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_reviews`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_reviews` (
  `review_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `review_release_id` bigint(20) NOT NULL,
  `review_text` text COLLATE utf8_unicode_ci NOT NULL,
  `review_date` date NOT NULL,
  `review_link` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `review_author` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `review_weight` smallint(4) NOT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_ribcage_tracks`
--

CREATE TABLE IF NOT EXISTS `wp_ribcage_tracks` (
  `track_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique track ID.',
  `track_release_id` bigint(20) NOT NULL COMMENT 'The release the track is attached to.',
  `track_mbid` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Track''s Musicbrainz ID.',
  `track_title` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'The title of the track.',
  `track_slug` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `track_number` bigint(20) NOT NULL COMMENT 'The track number on the release.',
  `track_time` time NOT NULL COMMENT 'The length of time of the track.',
  `track_mp3` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A file location of the track as MP3.',
  `track_ogg` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A file location of the track as Ogg Vobris.',
  `track_flac` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A file location of the track as FLAC.',
  `track_stream` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'A file location of the track to stream (generally a 128 kbps CBR MP3)',
  PRIMARY KEY (`track_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
