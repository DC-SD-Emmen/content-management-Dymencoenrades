<?php 

class Game {

    private $title;
    private $genre;
    private $platform;
    private $release_date;
    private $rating;
    private $description;
    private $gameicon;
    private $gamebackgroundicon;
    private $id;

    public function __construct($title, $genre, $platform, $release_date, $rating, $description, $gameicon, $gamebackgroundicon, $id) {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->platform = $platform;
        $this->release_date = $release_date;
        $this->rating = $rating;
        $this->description = $description;
        $this->gameicon = $gameicon;
        $this->gamebackgroundicon = $gamebackgroundicon;
    }
  
    // title
    public function set_title($title) {
        $this->title = $title;
    }

    public function get_title() {
        return $this->title;
    }

    // genre
    public function set_genre($genre) {
        $this->genre = $genre;
    }
  
    public function get_genre() {
        return $this->genre;
    }

    // platform
    public function set_platform($platform) {
        $this->platform = $platform;
    }
  
    public function get_platform() {
        return $this->platform;
    }

    // release_date
    public  function set_release_date($release_date) {
        $this->release_date = $release_date;
    }
  
    public function get_release_date() {
        return $this->release_date;
    }

    // rating
    public function set_rating($rating) {
        $this->rating = $rating;
    }
  
    public function get_rating() {
        return $this->rating;
    }
    
    // description
    public function set_description($description) {
        $this->description = $description;
    }
  
    public function get_description() {
        return $this->description;
    }
    
    // gameicon
    public function set_gameicon($gameicon) {
        $this->gameicon = $gameicon;
    }
  
    public function get_gameicon() {
        return $this->gameicon;
    }
        
    // gamebackgroundicon
    public function set_gamebackgroundicon($gamebackgroundicon) {
        $this->gamebackgroundicon = $gamebackgroundicon;
    }
  
    public function get_gamebackgroundicon() {
        return $this->gamebackgroundicon;
    }

    // id
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function get_id() {
        return $this->id;
    }
}

?>