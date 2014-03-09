
<div class="wrap">

    <h2>Editing <?php release_title(); ?></h2>

    <form action="<?php echo get_admin_url(); ?>admin.php?page=releases&action=edit&release=<?php release_id() ?>" method="post">

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
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php release_slug(); ?>" name="release_slug" id="release_slug" maxlength="200" /><span class="description">The URL you want for the release after the artist name, for example <?php echo home_url(); ?>/artist_name/release_slug</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="release_title">Release Date</label></th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php echo $release['release_date']; ?>" name="release_date" id="release_date" maxlength="200" /><span class="description">When is the record going to come out?</span>										
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row"><label for="release_catalogue_no">Catalogue Number</label></th> 
                <td>
                    <?php echo get_option('ribcage_mark'); ?><input type="text" style="width:30px;" class="regular-text code" value="<?php echo $release['release_catalogue_no']; ?>" name="release_catalogue_no" id="release_catalogue_no" maxlength="10" /><span class="description">This will be padded to be three digits</span>									
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
                    <select name="release_physical">
                        <option value="1" <?php if($release['release_physical']) echo'selected'; ?>>Yes</option>
                        <option value="0" <?php if(!$release['release_physical']) echo'selected'; ?>>No</option>
                    </select>
                    <span class="description">Is there a physical version of this release you are intending to sell?</span>									
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="release_allow_download">Allow Downloads?</label></th>
                <td>
                    <select name="release_allow_download">
                        <option value="1" <?php if($release['release_allow_download']) echo'selected'; ?>>Yes</option>
                        <option value="0" <?php if(!$release['release_allow_download']) echo'selected'; ?>>No</option>
                    </select>							
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="release_allow_torrent">Allow Downloads By Torrent?</label></th>
                <td>
                    <select name="release_allow_torrent">
                        <option value="1" <?php if($release['release_allow_torrent']) echo'selected'; ?>>Yes</option>
                        <option value="0" <?php if(!$release['release_allow_torrent']) echo'selected'; ?>>No</option>
                    </select>									
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="release_blurb_short">Short Description Of Release</label></th>
                <td><textarea name="release_blurb_short" id="release_blurb_short" rows="5" cols="80"><?php echo $release['release_blurb_short']; ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="release_blurb_long">Long Description Of Release</label></th>
                <td><textarea name="release_blurb_long" id="release_blurb_long" rows="15" cols="80"><?php echo $release['release_blurb_long']; ?></textarea>						
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
        </p>
    </form>

    <?php include 'tracks.php'; ?>

</div>