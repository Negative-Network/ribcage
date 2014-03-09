
<div class="wrap">

    <?php echo $title; ?>

    <form action="<?php echo $form_action; ?>" method="post">

        <input type="hidden" value="<?php echo $release['release_id']; ?>" name="track_release_id"/>
        <input type="hidden" value="<?php echo $track['track_id']; ?>" name="track_id"/>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="track_mbid">Track MusicBrainz ID</label></th> 
                <td>
                    <input type="text"  class="regular-text" value="<?php echo $track['track_mbid']; ?>" name="track_mbid" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row"><label for="track_number">Track number</label></th> 
                <td>
                    <input type="text" style="width:30px;" class="regular-text" value="<?php echo $track['track_number']; ?>" name="track_number" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row"><label for="track_title">Track Name</label></th> 
                <td>
                    <input type="text"  class="regular-text" value="<?php echo $track['track_title']; ?>" name="track_title" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row"><label for="track_slug">Track Slug</label></th> 
                <td>
                    <input type="text"  class="regular-text" value="<?php echo $track['track_slug']; ?>" name="track_slug" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row"><label for="track_time">Track Length</label></th> 
                <td>
                    <input type="text"  class="regular-text" value="<?php echo $track['track_time']; ?>" name="track_time" maxlength="200" />
                </td> 
            </tr>
<!--            <tr valign="top">
                <th scope="row"><label for="track_mp3">Track MP3</label></th> 
                <td>
                    <input type="text"  class="regular-text" value="<?php echo $track['track_mp3']; ?>" name="track_mp3" maxlength="200" />
                </td> 
            </tr>-->
        </table>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Save Track" />
            <a href="<?php echo get_admin_url(); ?>admin.php?page=releases&action=edit&release=<?php release_id() ?>" class="button-primary" />Back</a>
        </p>
    </form>

</div>
