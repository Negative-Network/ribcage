<h2>Add Release - Release Details</h2> 

<?php
if (isset($_POST['lookup']))
{
    $mbid = $_POST['musicbrainz_id'];
    $result = mb_get_release($mbid);

    if (is_wp_error($result))
    {
        ?>
        <?php
        switch ($result->get_error_code())
        {
            case 'ribcage-no-mbid':
                echo '<div id="message" class="updated fade"><p><strong>'.$result->get_error_message().'</strong></p></div>';
                break;
            case 'mb_not_found':
                ?>
                <p>Ribcage could not find a release with a MBID of <?php echo $mbid; ?> in the Musicbrainz database.</p>
                <p>Please enter the release manually, but don't forget to add it to Musicbrainz afterwards.</p>
                <?php
                break;
            case 'artist_not_found':
                // TODO Find out if we don't have this artist.
                ?>
                <p><?php echo $artist; ?> is not an artist in the Ribcage database. Yet.</p>
                <p>You need to <a href="admin.php?page=add_artist">add an artist</a> before you can add their releases.</p>
                <?php
                return (1);
                break;
        }
    }
    else
    {

        $artist_slug = $artist['artist_slug'];

        // Let people know we got some interesting things from Musicbrainz.
        set_transient('ribcage_got_mb', '1', 60 * 60);

        // Guess some things about our release.
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
        ));
    }
}
?>

<form action="<?php echo get_admin_url(); ?>admin.php?page=releases&action=new" method="post">
    <table class="form-table">             
        <tr valign="top">
            <th scope="row"><label for="release_artist">Release Artist</label></th> 
            <td>
                <?php ribcage_artists_dropdown('release_artist', $release['release_artist']); ?>
            </td> 
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_title">Release Name</label></th> 
            <td>
                <input type="text" style="width:320px;" class="regular-text code" value="<?php release_title(); ?>" name="release_title" id="release_title" maxlength="200" />										
            </td> 
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_title">Release Slug</label></th> 
            <td>
                <input type="text" style="width:320px;" class="regular-text code" value="<?php release_slug(); ?>" name="release_slug" id="release_slug" maxlength="200" />
                <span class="description">The URL you want for the release after the artist name, for example <?php echo home_url(); ?>/artist_name/release_slug</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_title">Release Date</label></th> 
            <td>
                <input type="text" style="width:320px;" class="regular-text code" value="<?php echo $release['release_date']; ?>" name="release_date" id="release_date" maxlength="200" /><span class="description">When is the record going to come out?</span>										
            </td> 
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_id">Catalogue Number</label></th> 
            <td>
                <?php echo get_option('ribcage_mark'); ?><input type="text" style="width:30px;" class="regular-text code" value="<?php echo $release['release_id']; ?>" name="release_id" id="release_id" maxlength="10" /><span class="description">This will be padded to be three digits</span>									
            </td> 
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_tracks_no">Number Of Tracks</label></th> 
            <td>
                <input type="text" style="width:30px;" class="regular-text code" value="<?php echo $release['release_tracks_no']; ?>" name="release_tracks_no" id="release_tracks_no" />									
            </td> 
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_time">Length of Release</label></th> 
            <td>
                <input type="text" style="width:70px;" class="regular-text code" value="<?php echo $release['release_time']; ?>" name="release_time" id="time" /><span class="description">Length of release in hh:mm:ss</span>	
            </td> 
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_physical">Physical Release</label></th>
            <td>
                <select name="release_physical" id="release_physical">
                    <?php
                    if (isset($release['release_physical']))
                    {
                        ?>
                        <option selected value ="<?php echo $release['release_physical']; ?>"><?php
                            if ($release['release_physical'] == 1)
                            {
                                echo 'Yes';
                            }
                            else
                            {
                                echo 'No';
                            };
                            ?></option>
                        <option value="<?php
                        if ($release['release_physical'] == 1)
                        {
                            echo '0';
                        }
                        else
                        {
                            echo '1';
                        }
                        ?>"><?php
                                    if ($release['release_physical'] == 1)
                                    {
                                        echo 'No';
                                    }
                                    else
                                    {
                                        echo 'Yes';
                                    };
                                    ?></option>
                    <?php } ?>
                    <option value ="0">No</option>
                    <option value = "1">Yes</option>
                </select>
                <span class="description">Is there a physical version of this release you are intending to sell?</span>									
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_allow_downloads">Allow Downloads?</label></th>
            <td>
                <select name="release_allow_download" id="release_allow_downloads">
                    <option selected value="1">Yes</option>
                    <option value="0">No</option>
                </select>							
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_allow_torrents">Allow Downloads By Torrent?</label></th>
            <td>
                <select name="release_allow_torrent" id="release_allow_torrents">
                    <option selected value="1">Yes</option>
                    <option value="0">No</option>
                </select>								
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_blurb_short">Short Description Of Release</label></th>
            <td><textarea name="release_blurb_short" id="release_blurb_short" rows="5" cols="80"></textarea>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="release_blurb_long">Long Description Of Release</label></th>
            <td><textarea name="release_blurb_long" id="release_blurb_long" rows="15" cols="80"></textarea>						
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="save_release" class="button-primary" value="Save and go to next step" />
    </p>
</form>