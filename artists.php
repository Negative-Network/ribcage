<?php

/**
 * Includes the administration functions and adds admin panes.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @package Ribcage
 * @subpackage Administration
 * */

/**
 * Adds Ribcage admin panes
 *
 * With a little advice from Davide Benini's Event Manager for an example. (benini.davide@gmail.com)
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_admin_menu() {

    add_object_page(__('Music Label', 'music label'), __('Music Label'), 'administrator', 'artists', 'ribcage_manage_artists', '');
    add_submenu_page('artists', 'Ribcage', 'Artists', 'administrator', 'artists', 'ribcage_manage_artists');
    add_submenu_page('artists', 'Ribcage', 'Releases', 'administrator', 'releases', 'ribcage_manage_releases');
    add_submenu_page('artists', 'Ribcage', 'Products', 'administrator', 'products', 'ribcage_manage_products');
    add_submenu_page('artists', 'Ribcage', 'Orders', 'administrator', 'orders', 'ribcage_manage_orders');
    add_submenu_page('artists', 'Settings', 'Settings', 'administrator', 'options', 'ribcage_options');

    register_setting('ribcage', 'ribcage_paypal_email'); // E-mail to send money to via Paypal
    register_setting('ribcage', 'ribcage_image_location'); // The directory to begin the directory tree of images for artists and release covers
    register_setting('ribcage', 'ribcage_file_location'); // The directory to begin the directory tree of files for audio and one sheets
    register_setting('ribcage', 'ribcage_release_image_huge'); // The directory to store huge images (defaults to _image_location/covers/huge)
    register_setting('ribcage', 'ribcage_release_image_large'); // The directory to store large cover images (defaults to _image_location/covers/large)
    register_setting('ribcage', 'ribcage_release_image_tiny'); // The directory to store medium tiny images (defaults to _image_location/covers/tiny)
    register_setting('ribcage', 'ribcage_release_onesheet_pdf'); // The directory to store one sheets for releases (defaults to _file_location/pdf/onesheets)
    register_setting('ribcage', 'ribcage_mark'); // The record label mark, Records On Ribs uses ROR, for example
    register_setting('ribcage', 'ribcage_postage_country'); // The default postage for a purchased item within the country you are in
    register_setting('ribcage', 'ribcage_postage_worldwide'); // The default postage for a purchased item worldwide
    register_setting('ribcage', 'ribcage_press_contact'); // E-mail for the press contact
    register_setting('ribcage', 'ribcage_total_downloads'); // Total number of downloads so far
}

add_action('admin_menu', 'ribcage_admin_menu');

global $page, $action;

$page = 'artists';
if (isset($_REQUEST['page'])) $page = $_REQUEST['page'];

$action = 'default';
if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];

require_once dirname(__FILE__).'/admin/functions.php';

require_once dirname(__FILE__).'/admin/artists/index.php';
require_once dirname(__FILE__).'/admin/releases.php';
require_once dirname(__FILE__).'/admin/products.php';
require_once dirname(__FILE__).'/admin/orders.php';
?>