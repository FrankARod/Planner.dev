<?php
	require_once('../dbconnect.php');
	require_once('classes/Ad.php');
	define('FILENAME', "data/ads.csv");
	class AdManager {
		public function load_ad() {
			$ad_stmt = $this->dbc->query("SELECT id FROM items");
			$ads_array = [];
			while ($row = $ad_stmt->fetch(PDO::FETCH_ASSOC)) {
				$ad = new Ad($this->dbc, $row['id']);
				$ads_array[] = $ad;
			}
			return $ads_array;
		}
		public $dbc;
		public function __construct($dbc) {
			$this->dbc = $dbc;
		}
	}
?>