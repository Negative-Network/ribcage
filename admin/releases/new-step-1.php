<?php
// Clear the memory decks, in case we have a half finished transaction.
delete_transient('ribcage_temp_tracks');
delete_transient('ribcage_temp_data');
delete_transient('ribcage_allow_download');
delete_transient('ribcage_allow_torrent');
?>

<h2>Add Release - Musicbrainz Lookup</h2>
<form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=releases&action=new">
    <p>Please enter the <a href="http://musicbrainz.org" target="_blank">Musicbrainz</a> ID and Ribcage will lookup the release and fill in the details automtically. This should be the Musicbrainz ID of the specific release, not the release group.</p> 
    <p>If your release does not have a Musicbrainz ID, or if you wish to enter the release entirely manually, click on Skip.</p>
    <p>Adding a track to Musicbrainz and then adding it to Ribcage makes it so you only have to type out the details of your release once. It also means that details of your release will be available on a central database, accessible to all.</p>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="musicbrainz_id">Musicbrainz ID</label></th>
            <td><input type="text" name="musicbrainz_id" value="" placeholder="bce40d0a-6b5f-4d75-97c7-916d67d584f6" class="regular-text code"/></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="lookup" class="button-primary" value="<?php _e('Lookup') ?>" />
        <input type="submit" name="skip" class="button-secondary" value="<?php _e('Skip') ?>" />
    </p>
</form>