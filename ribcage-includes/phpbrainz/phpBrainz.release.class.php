<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA

phpBrainz is a php class for querying the musicbrainz web service.
Copyright (c) 2007 Jeff Sherlock
*/
/**
 * Represents a MusicBrainz release.
 * 
 * @author Jeff Sherlock
 * @copyright Jeff Sherlock 2007
 * @package phpBrainz
 * @name phpBrainz_Release
 * 
 */
class phpBrainz_Release{
    private $artist;
    private $title;
    private $tracksCount;
    private $id;
    private $discCount;
    private $asin;
    private $tracks;
    private $score;
    private $tracksOffset;
    
    function __construct(){
    	$this->tracks = array();
    }
    
    /**
     * Sets the artist for this release
     * object.
     *
     * @param phpBrainz_Artist $artist
     * @return none
     */
    public function setArtist(phpBrainz_Artist $artist){
        $this->artist = $artist;
    }
    /**
     * Returns the artist for this release
     *
     * @param none
     * @return phpBrainz_Artist
     */
    public function getArtist(){
        return $this->artist;
    }
    
    /**
     * Sets the musicbrainz id for this
     * release.
     *
     * @param string $id
     * @return none
     */
    public function setId($id){
        $this->id = $id;        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setTracksCount($trackCount){
        if(!is_numeric($trackCount) && strlen($trackCount)>0){
            die(print("setTrackCount requires an integer."));
        }
        $this->tracksCount = $trackCount;
    }
    public function getTracksCount($trackCount){
    	return $this->tracksCount;
    }
    
    public function addTrack($track){
    	if(!($track instanceof phpBrainz_Track)){
    		die(print("addTrack only takes a phpBrainz_Track object"));
    	}
    	$this->tracks[] = $track;
    }
    
    public function getTracks($track){
    	return $this->tracks;
    }
    
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = (string)$title;
    }
    
    public function getScore(){
        return $this->score;
    }
    public function setScore($score){
        $this->score = intval($score);
    }
    
    public function getTracksOffest(){
        return $this->tracksOffset;
    }
    public function setTracksOffset($offset){
        $this->tracksOffset = intval($offset);
    }
    
    /**
     * Returns the number of discs in this release, 
     * if this information is available.
     *
     * @return int
     */
    public function getDiscCount(){
        return $this->discCount;
    }
    /**
     * Sets the number of discs in this release.
     *
     * @param int
     */
    public function setDiscCount($count){
        $this->discCount = $count;
    }
    
    /**
     * Sets the asin value.
     * @param string $asin
     */
    public function setASIN($asin){
        $this->asin = $asin;
    }
    
    /**
     * Retrieves the asin value.
     * @param none
     * @return string
     */
    public function getASIN(){
        return $this->asin;
    }
    
}