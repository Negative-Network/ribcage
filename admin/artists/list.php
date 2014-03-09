
<div class="wrap">

    <h2>Manage Artists <a href="<?php echo get_admin_url(); ?>admin.php?page=artists&action=new" class="add-new-h2">Add New</a></h2>

    <form action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_manage_artists" name="manage_artists"> 
        <table class="widefat post fixed" cellspacing="0">
            <thead>
                <tr>
                    <?php print_column_headers('ribcage-manage-artist'); ?>			
                </tr>
            </thead>
            <tfoot>
                <tr>			
                    <?php print_column_headers('ribcage-manage-artist', FALSE); ?>	
                </tr>
            </tfoot>            
            <tbody>
                <?php while (have_artists()) : the_artist(); ?>
                    <?php
                    echo ($alt % 2) ? '<tr valign="top" class="">' : '<tr valign="top" class="alternate">';
                    ++$alt;
                    ?>		
                <th scope="row" class="check-column"><input type="checkbox" name="artistcheck[]" value="2" /></th>
                <td class="column-name">
                    <strong><a class="row-title" href="?page=artists&action=edit&artist=<?php artist_id(); ?>" title="<?php artist_name(); ?>" ><?php artist_name(); ?></strong></a><br />
                    <div class="row-actions">
                        <span class='edit'><a href="?page=artists&action=edit&artist=<?php artist_id(); ?>">Edit</a> | </span>
                        <span class='delete'><a href='?page=artists&action=delete&artist=<?php artist_id(); ?>&_wpnonce=<?php echo $nonce ?>' onclick="if (confirm('You are about to delete \'<?php artist_name(); ?>\'\n  \'Cancel\' to stop, \'OK\' to delete.')) {
                                        return true;
                                    }
                                    return false;">Delete</a></span>
                    </div>
                </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </form>
    
</div>