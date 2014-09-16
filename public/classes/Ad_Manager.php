<?php

define('FILENAME', "data/ads.csv");

class AdManager {
	public $filename = '';
	
	public function load_ad() {
		clearstatcache();
		if (filesize("$this->filename") == 0) {
				$ads_array = [];
			} else {
				$handle = fopen("$this->filename", 'r');
				while(!feof($handle)) {
					$row = fgetcsv($handle);
					if (!empty($row)) {
						$ads_array[] = $row;
					}
				}
				fclose($handle);
			}
			return $ads_array;
	}
	
	public function __construct($filename = FILENAME) {
		$this->filename = $filename;
	}

	public function save_file($data) {  
		$handle = fopen("$this->filename", 'w');
		foreach ($data as $key => $value) {
			fputcsv($handle, $value);
		}
		fclose($handle);
	}
	
	public function add_ad($data) { 
		$handle = fopen("$this->filename", 'w');
		foreach ($data as $key => $value) {
			fputcsv($handle, $value);
		}
		fclose($handle);
	}
	
	public function remove_ad() {
		if (isset($_GET['remove'])) {
			unset($ads_array[$_GET['remove']]);
			$ad_list->save_ad($ads_array);
			$ads_array = array_values($ads_array);
		}
	}

	public function update_ad() {
		$filename = 'data/ads.csv';

		$handle = fopen($filename, 'r');

		$ads_array = [];

		while(!feof($handle)) {
		  $ads_array[] = fgetcsv($handle);
		}

		fclose($handle);
	}
}