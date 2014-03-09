<div class="wrap">

    <h2>Artist</h2>

    <form  method="post" id="ribcage_artist-form" name="artist-form">
    <!--<form action="<?php // echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']);   ?>&ribcage_action=add" method="post" id="ribcage_edit_artist" name="edit_artist">-->

        <table class="form-table">   
            <tr valign="top">
                <th scope="row"><label for="artist_name">Name</label></th> 
                <td>
                    <input type="text" value="<?php artist_name(); ?>" name="artist_name" id="artist_name" class="regular-text"/>												
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Sort Name</th> 
                <td>
                    <input type="text" value="<?php artist_name_sort(); ?>" name="artist_name_sort" id="artist_name_sort" class="regular-text" />
                    <span class="description">The name of the artist to be alphabetized. For example, 'Butterfly, The'.</span>
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist Slug</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_slug(); ?>" name="artist_slug" id="artist_slug" /><span class="description">The URL you want for the artist - for example <?php echo home_url(); ?>/artists/artist_slug</span>
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Signup Date</th> 
                <td>
                    <input type="text" style="width:100px;" class="regular-text code" value="<?php echo $artist['artist_signed']; ?>" name="artist_signed" id="artist_signed" maxlength="50" /><span class="description">The date the artist signed for your label</span>
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Creative Commons license</th> 
                <td>
                    <?php echo ribcage_cc_dropdown(isset($artist_license_val) ? $artist_license_val : false); ?>
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist's Music Brainz ID</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_musicbrainz(); ?>" name="artist_mbid" id="artist_mbid" maxlength="50" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Website URL</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_website_link(); ?>" name="artist_link_website" id="artist_link_website" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">MySpace URL</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_myspace_link(); ?>" name="artist_link_myspace" id="artist_link_myspace" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Facebook URL</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_facebook_link(); ?>" name="artist_link_facebook" id="artist_link_facebook" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist Biography</th> 
                <td>
                    <textarea rows="5" cols="50" name="artist_bio" id="artist_bio" class="regular-text"><?php echo $artist['artist_bio']; ?></textarea>
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Short One Paragraph Description of Artist</th> 
                <td>
                    <textarea rows="5" cols="50" name="artist_blurb_tiny" id="artist_blurb_tiny" class="regular-text"><?php echo $artist['artist_blurb_tiny']; ?></textarea>
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist Picture 1</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_1(); ?>" name="artist_picture_1" id="artist_picture_1" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist Picture 2</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_2(); ?>" name="artist_picture_2" id="artist_picture_2" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist Picture 3</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_3(); ?>" name="artist_picture_3" id="artist_picture_3" maxlength="200" />
                </td> 
            </tr>
            <tr valign="top">
                <th scope="row">Artist Picture HQ Zipfile URL</th> 
                <td>
                    <input type="text" style="width:320px;" class="regular-text code" value="<?php if (isset($artist_picture_zip_val)) echo $artist_picture_zip_val; ?>" name="artist_picture_zip" id="artist_picture_zip" maxlength="200" />
                </td> 
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
        </p>
    </form>
</div>