<h2>Release Tracks</h2>

<table width="300px"> 
    <thead>
        <tr>
            <td>No</td>
            <td>Track Name</td>
            <td>Length</td>		
        </tr>
    </thead>
    <?php while (have_tracks()) : the_track(); ?>
        <tr>
            <th scope="row"><?php track_no(); ?></th>
            <td><?php track_title(); ?></td>
            <td><?php echo $track['track_time']; ?></td>
            <td>
                <a href="<?php echo get_admin_url(); ?>admin.php?page=releases&action=edit_track&track=<?php track_id() ?>">Edit</a>
                - 
                <a href="<?php echo get_admin_url(); ?>admin.php?page=releases&action=delete_track&track=<?php track_id() ?>&_wpnonce=<?php echo $nonce ?>" onclick="if (confirm('You are about to delete \'<?php track_title(); ?> from <?php release_title(); ?>\'\n  \'Cancel\' to stop, \'OK\' to delete.')) {return true;}return false;">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p>
    <a href="<?php echo get_admin_url(); ?>admin.php?page=releases&action=tracks&release=<?php release_id() ?>" class="button-primary" />Add track</a>
</p>