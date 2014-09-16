<?php

class Ad {
    
    public $title = '';
    public $body = '';
    public $date = '';
    public $username = '';
    public $email = '';
    public function __construct($title, $body, $date, $username, $email, $filename = FILENAME) {
        $this->filename = $filename;
        $this->title = $title;
        $this->body = $body;
        $this->date = $date;
        $this->username = $username;
        $this->email = $email;
    }
}

$printable_ads = [];
foreach ($ads_array as $key => $ad) {
    $printable_ads[$key] = new Ad($ad[0], $ad[1], $ad[2], $ad[3], $ad[4]);
}