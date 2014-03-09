<?php
/**
 * Artist management
 *
 * @package Ribcage
 * @subpackage Administration
 * */

/**
 * Manages artists - adds, deletes, edits.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 * */
function ribcage_manage_artists() {

    global $page, $action, $artists, $artist;
    
    if($page != 'artists') return;

    $artist_id = 0;
    $artist = null;
    if (isset($_REQUEST['artist']))
    {
        $artist_id = (int) $_REQUEST['artist'];
        $artist = get_artist($artist_id);
    }

    register_column_headers('ribcage-manage-artist', array(
        'cb' => '<input type="checkbox" />',
        'artist' => 'Artist'
            )
    );


    switch ($action)
    {
        case 'new':

            if ($_POST)
            {
                global $wpdb;
                $wpdb->show_errors();
                //slice off two variables at the end to prepare for implodes
                array_pop($_POST); // submit button var
                //split apart associative array into different parts to prepare for implodes
                $post_keys = array_keys($_POST);
                $post_vals = array_values($_POST);
                //construct field name list and vals to post
                $string_keys = implode($post_keys, ",");
                $string_vals = "'".implode($post_vals, "','")."'";
                //insert
                $sql = "INSERT INTO ".$wpdb->prefix."ribcage_artists ($string_keys) VALUES ($string_vals)";
                $results = $wpdb->query($sql);
                $wpdb->hide_errors();
                //load newly created artist
                $artist = get_artist_by_slug($_POST['artist_slug']);
                echo '<div id="message" class="updated fade"><p><strong>Artist created</strong></p></div>';
            }

            include 'form.php';
            break;

        case 'edit':

            if ($_POST)
            {
                global $wpdb;
                $wpdb->show_errors();
                array_pop($_POST); // submit button var
                $sql = "UPDATE ".$wpdb->prefix."ribcage_artists SET ";
                foreach ($_POST as $key => $value) $sql .= $key."='".$value."', ";
                $sql .= " artist_id = ".$artist_id." WHERE artist_id = ".$artist_id;
                $results = $wpdb->query($sql);
                $wpdb->hide_errors();
                echo '<div id="message" class="updated fade"><p><strong>Artist updated</strong></p></div>';
                //reload artist data
                $artist = get_artist($artist_id);
            }

            include 'form.php';
            break;


        case 'delete':
            check_admin_referer('ribcage_manage');
            
            if (isset($_GET['_wpnonce']))
            {
                if (wp_verify_nonce($_GET['_wpnonce'], 'ribcage_manage'))
                {
                    if(delete_artist($artist_id)) $message = 'Artist deleted';
                    else $message = 'This artist was not found in the database';
                }
                else $message = 'Security check failed. Please try to delete again';
            }
            echo '<div id="message" class="updated fade"><p><strong>'.$message.'</strong></p></div>';

        default :
            $nonce = wp_create_nonce('ribcage_manage');
            $artists = list_artists_blurb();
            $alt = 0;
            include 'list.php';
            break;
    }
}

/**
 * Manages press articles about an artist.
 *
 * @author Alex Andrews <alex@recordsonribs.com>
 * @return void
 */
function ribcage_manage_press() {
    ?>
    <div class="wrap">
        <h2>Add Press</h2>

    </div>
    <?php
}
?>