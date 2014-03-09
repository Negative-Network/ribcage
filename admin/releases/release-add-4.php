<?php
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
