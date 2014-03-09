<?php
/**
 * Functions for handling releases, adding reviews to releases, etc.
 *
 * @package Ribcage
 * @subpackage Administration
 * */

/**
 * Manage releases panel - sends you out to add releases, remove releases, add reviews (and eventually add tracks).
 *
 * @return void
 */
function ribcage_manage_releases() {

    global $page, $action, $release, $releases, $artist, $tracks, $track;

    if ($page != 'releases') return;

    $release_id = 0;
    $release = null;
    if (isset($_REQUEST['release']))
    {
        $release_id = (int) $_REQUEST['release'];
        $release = get_release($release_id);
    }

    $track_id = 0;
    $track = null;
    if (isset($_REQUEST['track']))
    {
        $track_id = (int) $_REQUEST['track'];
        $track = get_track($track_id);
        $release = get_release($track['track_release_id']);
    }

    switch ($action)
    {
        case 'stats':
            ribcage_release_stats();
            break;

        case 'new':

            if (!$_POST)
            {   //default asking for MusicBrains lookup
                include 'releases/new-step-1.php';
            }
            else
            {
                if (!isset($_POST['save_release'])) include 'releases/new-step-2.php';
                else
                {
                    // Add release to database
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
                    $sql = "INSERT INTO ".$wpdb->prefix."ribcage_releases ($string_keys) VALUES ($string_vals)";
                    $results = $wpdb->query($sql);
                    $wpdb->hide_errors();
                    //load newly created artist
                    $release = get_release_by_slug($_POST['release_slug']);
                    echo '<div id="message" class="updated fade"><p><strong>Release created</strong></p></div>';
                    include 'releases/edit.php';
                }
            }

            break;

        case 'delete_track':

//            check_admin_referer('ribcage_manage');
            
            $message = 'This track was not found in the database';
            if (isset($_GET['_wpnonce']))
            {
                if (wp_verify_nonce($_GET['_wpnonce'], 'ribcage_manage'))
                {
                    global $wpdb;
                    $release_id = $track['track_release_id'];
                    if ($wpdb->query("DELETE FROM `$wpdb->ribcage_tracks` WHERE `track_id` = $track_id LIMIT 1;")) {
                        $message = 'Track deleted';
                        $release = get_release($release_id);
                    }
                }
                else $message = 'Security check failed. Please try to delete again';
            }
            echo '<div id="message" class="updated fade"><p><strong>'.$message.'</strong></p></div>';
            
            $artist = get_artist($release['release_artist']);
            $tracks = $release['release_tracks'];
            $nonce = wp_create_nonce('ribcage_manage');
            
            include 'releases/edit.php';
            break;


        case 'edit':

            $artist = get_artist($release['release_artist']);
            $tracks = $release['release_tracks'];
            $nonce = wp_create_nonce('ribcage_manage');

            if ($_POST)
            {
                // Add release to database
                global $wpdb;
                $wpdb->show_errors();
                array_pop($_POST); // submit button var
                //update
                $sql = "UPDATE ".$wpdb->prefix."ribcage_releases SET ";
                foreach ($_POST as $key => $value) $sql .= $key."='".$value."', ";
                $sql = substr($sql, 0, -2);
                $sql .= " WHERE release_id = ".$release_id;
                $results = $wpdb->query($sql);
                $wpdb->hide_errors();
                //load newly created release
                $release = get_release($release_id);
                echo '<div id="message" class="updated fade"><p><strong>Release updated</strong></p></div>';
            }

            include 'releases/edit.php';
            break;


        case 'delete':

            check_admin_referer('ribcage_manage');

            if (isset($_GET['_wpnonce']))
            {
                if (wp_verify_nonce($_GET['_wpnonce'], 'ribcage_manage'))
                {
                    if (delete_release($release_id)) $message = 'Release deleted';
                    else $message = 'This release was not found in the database';
                }
                else $message = 'Security check failed. Please try to delete again';
            }
            echo '<div id="message" class="updated fade"><p><strong>'.$message.'</strong></p></div>';

        case 'tracks':
            if ($_POST)
            {
                // Add track to database
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
                $sql = "INSERT INTO ".$wpdb->prefix."ribcage_tracks ($string_keys) VALUES ($string_vals)";
                $results = $wpdb->query($sql);
                $wpdb->hide_errors();
                //load newly created track
                $track = get_track_by_slug($_POST['track_slug']);
                echo '<div id="message" class="updated fade"><p><strong>Track added</strong></p></div>';
            }
            $form_action = get_admin_url().'admin.php?page=releases&action='.$action.'&release='.$release['release_id'];
            $title = '<h2>Add track for '.release_title(false).'</h2>';
            include 'releases/track-form.php';
            break;

        case 'edit_track':
            if ($_POST)
            {
                // Add release to database
                global $wpdb;
                $wpdb->show_errors();
                array_pop($_POST); // submit button var
                //update
                $sql = "UPDATE ".$wpdb->prefix."ribcage_tracks SET ";
                foreach ($_POST as $key => $value) $sql .= $key."='".$value."', ";
                $sql = substr($sql, 0, -2);
                $sql .= " WHERE track_id = ".$_POST['track_id'];
                $results = $wpdb->query($sql);
                $wpdb->hide_errors();
                //load newly created artist
                $track = get_track($track['track_id']);
                echo '<div id="message" class="updated fade"><p><strong>Track updated</strong></p></div>';
            }
            $form_action = get_admin_url().'admin.php?page=releases&action='.$action.'&track='.$track['track_id'];
            $title = '<h2>Edit : '.$track['track_title'].' from : '.release_title(false).'</h2>';
            include 'releases/track-form.php';
            break;


        case 'reviews':
            ribcage_manage_reviews();
            break;

        default :
            $nonce = wp_create_nonce('ribcage_manage');
            $releases = list_recent_releases_blurb();
            include 'releases/list.php';
            break;
    }
}

/**
 * Administration panel for adding a release.
 *
 * @return void
 */
function ribcage_add_release() {
    global $release, $artist, $tracks, $track;
    ?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
    <?php
    $release = null;
    if (isset($_POST['release'])) $release = $_POST['release'];
    $release = stripslashes($release);
    $release = unserialize($release);

    unset($_POST['release']);
    unset($_POST['Submit']);

    // Stage 4 - Add the release to the database.
    if (isset($_REQUEST['ribcage_action']) and $_REQUEST['ribcage_action'] == 'add_release' && $_REQUEST['ribcage_step'] == '4')
    {
        ?>
            <h2>Add Release - Adding To Database</h2>
            <?php
            // Load everything we have so far.
            $release = get_transient('ribcage_temp_data');
            $release = unserialize($release);

            $tracks = get_transient('ribcage_temp_tracks');
            $tracks = unserialize($tracks);

            // Correct the data we have here with additions from the previous form.
            foreach ($_POST as $key => $var)
            {
                if (preg_match("/^track_stream_/", $key))
                {
                    $number = str_replace('track_stream_', '', $key);
                    $number = $number - 1;
                    $tracks [$number]['track_stream'] = $var;
                    continue;
                }
                $release[$key] = $var;
            }

            /*
              ?>
              <pre>
              <?php print_r($release); ?>
              <?php print_r($tracks); ?>
              </pre>
              <?php
             */

            // Save all of this just incase we have a problem.
            set_transient('ribcage_temp_data', serialize($release), 60 * 60);
            set_transient('ribcage_temp_tracks', serialize($release), 60 * 60);

            // Checks on the data so far.
            foreach ($tracks as $track)
            {
                if (false === @file_get_contents($track['track_stream']))
                {
                    $errors[] = '<p>The streaming file for the track '.$track['track_title'].' does not exist at <code>'.$track['track_stream'].'</code>.</p>';
                    //$fatal_error = true;
                }
            }

            $formats = array('mp3', 'ogg', 'flac');

            foreach ($formats as $format)
            {
                if ($release["release_$format"])
                {
                    if (!file_exists(ABSPATH.$release["release_$format"]))
                    {
                        $errors[] = '<p>The file you set for the '.$format.' downloads does not exist at <code>'.$release["release_$format"].'</code>.</p>';
                        $missing_uploads = true;
                    }
                }
            }

            if ($release["release_one_sheet"])
            {
                if (!file_exists(ABSPATH.$release["release_one_sheet"]))
                {
                    $errors[] = '<p>The file you set for the one sheet does not exist at <code>'.$release["release_one_sheet"].'</code>.</p>';
                    $missing_uploads = 1;
                }
            }

            foreach ($formats as $format)
            {
                if ($release["release_torrent_$format"])
                {
                    if (false === @file_get_contents($release["release_torrent_$format"], 0, null, 0, 1))
                    {
                        $errors[] = '<p>The file you set for the '.$format.' torrent does not exist at <code>'.$release["release_torrent_$format"].'</code>.</p>';
                    }
                }
            }

            $sizes = array('tiny', 'large', 'huge');

            foreach ($sizes as $size)
            {
                if ($release["release_cover_image_$size"])
                {
                    if (false === @file_get_contents($release["release_cover_image_$size"], 0, null, 0, 1))
                    {
                        $errors[] = '<p>The '.$size.' cover image does not exist at <code>'.$release["release_cover_image_$size"].'</code>.</p>';
                        $missing_uploads = true;
                    }
                    $check_images = true;
                }
            }

            if (!$check_images)
            {
                $errors[] = '<p>No cover images have been set!</p>';
            }

            if ($missing_uploads)
            {
                $errors[] = "<p>We've got missing files here, don't forget to upload them!</p>";
            }

            // Show errors.
            if (is_array($errors))
            {
                ?>
                <h3>Errors</h3>
                <p>The following errors have been found in what you have entered.</p> 
                <?php
                foreach ($errors as $error)
                {
                    print $error;
                }
                // TODO Set some kind of flag to remind the user that their are incomplete elements of the release.
                if ($fatal_error)
                {
                    ?>
                    <p>There are too many errors to continue, please go back and correct them.</p>
                    <p class="submit">
                        <input type="submit" name="Submit" class="button-primary" value="Back" />
                    </p>
                <?php
                return;
            }
        }
        ?>
            <p>Added <?php release_title(); ?> to the database.</p>
            <?php
            global $wpdb;

            $wpdb->show_errors();

            // Add release to database
            $string_keys = implode(array_keys($release), ",");
            $string_values = "'".implode(array_values($release), "','")."'";

            $sql = "INSERT INTO ".$wpdb->prefix."ribcage_releases
					($string_keys)
					VALUES
					($string_values)";
            //echo $sql;
            $results = $wpdb->query($sql);

            // Add tracks to database
            foreach ($tracks as $tr)
            {
                $tr['track_title'] = mysql_real_escape_string($tr['track_title']);
                $string_keys = implode(array_keys($tr), ",");
                $string_values = "'".implode(array_values($tr), "','")."'";

                $sql = " 
			INSERT INTO wp_ribcage_tracks 
			($string_keys)
			VALUES
			($string_values)
			";

                //echo $sql;
                $results = $wpdb->query($sql);
            }

            delete_transient('ribcage_temp_tracks');
            delete_transient('ribcage_temp_data');

            delete_transient('ribcage_allow_download');
            delete_transient('ribcage_allow_torrent');

            $wpdb->hide_errors();

            if (!$release['release_mbid'])
            {
                echo "<p>Don't forget to add the release to <a href=\"http://musicbrainz.org\">MusicBrainz</a>. It will make your life a lot easier!</p>";
            }

            return 0;
        }

        // Stage 3 - Where are the files related to this release?
        elseif (isset($_REQUEST['ribcage_action']) and $_REQUEST['ribcage_action'] == 'add_release' && $_REQUEST['ribcage_step'] == '3')
        {
            // Load everything up of any interest. By now we should have a fair bit.
            $release = get_transient('ribcage_temp_data');
            $release = unserialize($release);

            $allow_download = get_transient('ribcage_allow_download');
            $allow_torrent = get_transient('ribcage_allow_torrent');

            // Set the tracks from the previous stage $_POST
            $total_tracks = $release['release_tracks_no'];
            $t = 1;

            $artist = get_artist($release['release_artist']);
            $artist_slug = $artist['artist_slug'];

            while (count($tracks) != $total_tracks)
            {
                $tracks [] = array(
                    'track_number' => $_POST["track_number_$t"],
                    'track_title' => $_POST["track_title_$t"],
                    'track_time' => $_POST["track_time_$t"],
                    'track_release_id' => $release['release_id'],
                    'track_mbid' => $_POST["track_mbid_$t"],
                    'track_slug' => ribcage_slugize($_POST["track_title_$t"]),
                    'track_stream' => get_option('siteurl').get_option('ribcage_file_location').'audio'.ribcage_slugize($_POST['track_title_$t'])."/$artist_slug/".ribcage_slugize($release['release_title']).'/stream/'.str_pad($t, 2, "0", STR_PAD_LEFT).'.mp3'
                );
                $t++;
            }

            set_transient('ribcage_temp_tracks', serialize($tracks), 60 * 60);
            ?>
            <h2>Add Release - Upload Files</h2>
            <form action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=add_release&ribcage_step=4" method="post" id="ribcage_add_release" name="add_release">
            <?php if ($allow_download == 1)
            {
                ?>
                    <h3>Downloads</h3>
                    <p>At the moment Ribcage has no facility to upload downloads for your release. But it has made the following guess as to where your downloads might be - please check them.</p>
                    <table class="form-table">             
            <?php
            if ($release['release_mp3'])
            {
                ?>
                            <tr valign="top">
                                <th scope="row"><label for="release_mp3">.zip Location For MP3</label></th> 
                                <td>
                                    <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_mp3']; ?>" name="release_mp3" id="release_mp3" maxlength="200" />
                                </td> 
                            </tr>
                <?php
            }

            if ($release['release_ogg'])
            {
                ?>
                            <tr valign="top">
                                <th scope="row"><label for="release_ogg">.zip Location For Ogg</label></th> 
                                <td>
                                    <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_ogg']; ?>" name="release_ogg" id="release_ogg" maxlength="200" />
                                </td> 
                            </tr>
                <?php
            }

            if ($release['release_flac'])
            {
                ?>
                            <tr valign="top">
                                <th scope="row"><label for="release_ogg">.zip Location For Flac</label></th> 
                                <td>
                                    <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_flac']; ?>" name="release_flac" id="release_flac" maxlength="200" />
                                </td> 
                            </tr>
                <?php
            }
        }
        else
        {
            unset($release['release_mp3']);
            unset($release['release_ogg']);
            unset($release['release_flac']);
        }
        ?>
                </table>
                    <?php if ($allow_torrent == 1)
                    {
                        ?>
                    <h3>Torrents</h3>
                    <p>The locations of your torrents for those downloads.</p>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><label for="release_torrent_mp3">Torrent For MP3</label></th> 
                            <td>
                                <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_torrent_mp3']; ?>" name="release_torrent_mp3" id="release_torrent_mp3" maxlength="200" />
                            </td> 
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="release_torrent_ogg">Torrent For Ogg</label></th> 
                            <td>
                                <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_torrent_ogg']; ?>" name="release_torrent_ogg" id="release_torrent_ogg" maxlength="200" />
                            </td> 
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="release_torrent_flac">Torrent For Flac</label></th> 
                            <td>
                                <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_torrent_flac']; ?>" name="release_torrent_flac" id="release_torrent_flac" maxlength="200" />
                            </td> 
                        </tr>
                    </table>
                    <?php
                }
                else
                {
                    unset($release['release_torrent_mp3']);
                    unset($release['release_torrent_ogg']);
                    unset($release['release_torrent_flac']);
                }
                ?>
                <h3>Streams</h3>
                <p>The following is our guess where the files to stream your release are located.</p>
                <table width="800px"> 
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Track Name</td>
                            <td>Stream Location</td>		
                        </tr>
                    </thead>
                    <?php $track_count = 1; ?>
                    <?php while (have_tracks()) : the_track(); ?>
                        <tr>
                            <th scope="row">
                                <?php track_no(); ?>
                            </th>
                            <td>
                                <?php track_title(); ?>
                            </td>
                            <td>
                                <input type="text" style="width:500px;" class="regular-text" value="<?php echo $track['track_stream']; ?>" name="track_stream_<?php echo $track_count; ?>" id="track_stream_<?php echo $track_count; ?>" maxlength="200" />											
                            </td>
                        </tr>
                        <?php $track_count++; ?>
                    <?php endwhile; ?>
                </table>
                <h3>Artwork</h3>
                <p>The following is our guess where the images for the artwork for your release are located.</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="release_cover_image_tiny">Tiny Cover Image</label></th> 
                        <td>
                            <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_cover_image_tiny']; ?>" name="release_cover_image_tiny" id="release_cover_image_tiny" maxlength="200" />
                        </td> 
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="release_cover_image_large">Large Cover Image</label></th> 
                        <td>
                            <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_cover_image_large']; ?>" name="release_cover_image_large" id="release_cover_image_large" maxlength="200" />
                        </td> 
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="release_cover_image_huge">Huge Cover Image</label></th> 
                        <td>
                            <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_cover_image_huge'] ?>" name="release_cover_image_huge" id="release_cover_image_huge" maxlength="200" />
                        </td> 
                    </tr>
                </table>
                <h3>Press</h4>
                    <p>Release One Sheet  <input type="text" style="width:480px;" class="regular-text code" value="<?php print $release['release_one_sheet']; ?>" name="release_one_sheet" id="release_one_sheet" maxlength="200" /></p>
                    <p class="submit">
                        <input type="submit" name="Submit" class="button-primary" value="Next" />
                    </p>
            </form>
            <?php
            set_transient('ribcage_temp_data', serialize($release), 60 * 60);
        }

        // Stage 2 - Check release tracks are correct.
        elseif (isset($_REQUEST['ribcage_action']) and $_REQUEST['ribcage_action'] == 'add_release')
        {
            // Get the tracks that have been set, if we have been sent any.
            $tracks = get_transient('ribcage_temp_tracks');
            $tracks = unserialize($tracks);

            if (!$tracks)
            {
                $track_count = 0;
                while ($track_count < $_POST['release_tracks_no'])
                {
                    $track_count++;
                    $tracks [] = array(
                        'track_title' => '',
                        'track_time' => '',
                        'track_release_id' => $release['release_id'],
                        'track_mbid' => '',
                        'track_slug' => '',
                        'track_number' => $track_count,
                        'track_stream' => ''
                    );
                }
            }

            $artist = get_artist($_POST['release_artist']);
            $release['release_artist'] = $_POST['release_artist'];
            $release['release_tracks'] = $tracks;

            set_transient('ribcage_allow_download', $_POST['allow_download'], 60 * 60);
            set_transient('ribcage_allow_torrent', $_POST['allow_torrent'], 60 * 60);

            unset($_POST['allow_download']);
            unset($_POST['allow_torrent']);

            // Whack all the inputed variables into $release
            foreach ($_POST as $key => $var)
            {
                $release[$key] = $var;
            }

            // If we don't have any data from Musicbrainz then this is the time to guess some stuff.
            $test = get_transient('ribcage_got_mb');

            if ($test != 1)
            {
                $artist = get_artist($release['release_artist']);
                $artist_slug = $artist['artist_slug'];

                $release = array_merge($release, array(
                    'release_cover_image_tiny' => get_option('siteurl').get_option('ribcage_image_location').'covers/tiny/'.$release['release_slug'].'.jpg',
                    'release_cover_image_large' => get_option('siteurl').get_option('ribcage_image_location').'covers/large/'.$release['release_slug'].'.jpg',
                    'release_cover_image_huge' => get_option('siteurl').get_option('ribcage_image_location').'covers/huge/'.$release['release_slug'].'.jpg',
                    'release_mp3' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-mp3.zip',
                    'release_ogg' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-ogg.zip',
                    'release_flac' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-flac.zip',
                    'release_torrent_mp3' => '',
                    'release_torrent_ogg' => '',
                    'release_torrent_flac' => '',
                    'release_one_sheet' => get_option('siteurl').get_option('ribcage_file_location').'pdf/onesheets/'.$release['release_slug'].'.pdf',
                        )
                );
            }
            ?>
            <h2>Add Release - Track Details</h2>
            <p>Please check the following details for <?php artist_name(); ?> - <?php release_title(); ?>.</p>
            <?php ribcage_tracks_form(); ?>
        </div>
        <?php
        // Dump this because we already have tracks save in $tracks, hased in the database as ribcage_temp_tracks.
        unset($release['release_tracks']);

        // Save data.
        $saved_temp = unserialize(get_transient('ribcage_temp_data'));

        if ($saved_temp)
        {
            $temp = array_merge($release, $saved_temp);
            $temp = serialize($temp);
        }
        else
        {
            $temp = serialize($release);
        }

        set_transient('ribcage_temp_data', $temp, 60 * 60);

        return 0;
    }
    ?>
    </div>
    <?php
}

/**
 * Add a review of a specific release.
 *
 * @return void
 */
function ribcage_manage_reviews() {
    global $releases, $release, $artist, $tracks, $track;

    $release = get_release($_REQUEST['release'], false, true);
    $reviews = $release['release_reviews'];
    $artist['artist_name'] = get_artistname_by_id($release['release_artist']);
    ?>
    <div class="wrap">
        <h2>Manage Reviews of <?php artist_name(); ?> - <?php release_title(); ?></h2>
    <?php
    if (count($reviews) == 0)
    {
        echo "<p>No reviews yet. Why not add one now?</p>";
    }
    else
    {
        register_column_headers('ribcage-manage-reviews', array(
            'cb' => '<input type="checkbox" />',
            'review_' => 'Reviewer'
                )
        );

        echo "<pre>".print_r($reviews)."</pre>";
    }
    ?>
        <h3>Add a review</h3>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="review_url">Review URL</label></th>
                <td><input type="text" name="review_url" value="" class="regular-text code"/><span class="description">The URL of the review, if the review is online.</span>								</td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="review_url">Publication</label></th>
                <td><input type="text" name="review_url" value="" class="regular-text code"/><span class="description">The name of the publication that reviewed the release</span>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Add Review" />
        </p>
    </form>
    </div>
    <?php
}

/**
 * Produces a page of statistics about the release we have.
 *
 * @return void
 */
function ribcage_release_stats() {
    echo "Stats";
}
?>