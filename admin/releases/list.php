<?php
$alt = 0;
$total_downloads = 0;

register_column_headers('ribcage-manage-releases', array(
    'cb' => '<input type="checkbox" />',
    'release_image' => '',
    'release_title' => 'Release',
    'release_date' => 'Release Date',
    'local_downloads' => 'Local Downloads',
    'remote_downloads' => 'Remote Downloads',
    'total_downloads' => 'Total Downloads'
        )
);

?>
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2>Manage Releases <a href="<?php echo get_admin_url(); ?>admin.php?page=releases&action=new" class="add-new-h2">Add New</a></h2>
    <form action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_edit_artist" name="edit_artist">
        <table class="widefat post fixed" cellspacing="0">
            <thead>
                <tr>
                    <?php print_column_headers('ribcage-manage-releases'); ?>			
                </tr>
            </thead>
            <tfoot>
                <tr>			
                    <?php print_column_headers('ribcage-manage-releases', FALSE); ?>	
                </tr>
            </tfoot>            
            <tbody>
                <?php while (have_releases()) : the_release(); ?>
                    <?php $artist = get_artist($release['release_artist']); ?>
                    <?php
                    echo ($alt % 2) ? '<tr valign="top" class="">' : '<tr valign="top" class="alternate">';
                    ++$alt;
                    ?>		
                <th scope="row" class="check-column"><input type="checkbox" name="artistcheck[]" value="2" /></th>
                <td class="column-icon"><img src="<?php release_cover_tiny(); ?>" height="65px" width="65px" alt="<?php release_title(); ?>" /></td>
                <td class="column-name">
                    <strong><a class="row-title" href="?page=releases&release=<?php artist_id(); ?>" title="<?php artist_name(); ?>" ><?php artist_name(); ?> - <?php release_title(); ?></a></strong>
                    <br />
                    <div class="row-actions">
                        <!--<span class='stats'><a href="?page=releases&release=<?php release_id(); ?>&amp;action=stats&amp;_wpnonce=<?php echo $nonce ?>">Stats</a></span> |--> 
                        <span class='edit'><a href="?page=releases&release=<?php release_id(); ?>&amp;action=edit&amp;_wpnonce=<?php echo $nonce ?>">Edit</a></span> | 
                        <span class='reviews'><a href="?page=releases&release=<?php release_id(); ?>&amp;action=reviews&amp;_wpnonce=<?php echo $nonce ?>">Reviews</a></span> | 
                        <span class='delete'><a class='submitdelete' href='?page=releases&release=<?php release_id(); ?>&amp;action=delete&amp;_wpnonce=<?php echo $nonce ?>' onclick="if (confirm('You are about to delete \'<?php artist_name(); ?> - <?php release_title(); ?>\'\n  \'Cancel\' to stop, \'OK\' to delete.')) {return true;}return false;">Delete</a></span>
                    </div>
                </td>
                <td class="column-name"><?php echo date('j F Y', strtotime($release['release_date'])); ?></td>
                <td class="column-name"><?php release_downloads(); ?></td>
                <td class="column-name"><?php //remote_downloads();   ?></td>
                <td class="column-name"><?php //echo number_format(remote_downloads(FALSE)+release_downloads(FALSE)); $total_downloads = $total_downloads + remote_downloads(FALSE)+release_downloads(FALSE); update_option('ribcage_total_downloads', $total_downloads);                ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </form>
    <p>Served <?php echo number_format($total_downloads) ?> downloads so far.</p>
</div>
<?php
update_option('ribcage_total_downloads', $total_downloads);
