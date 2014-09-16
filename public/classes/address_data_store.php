<?php
class AddressDataStore {
		public $filename = '';
		public function save_file($address_book) {	
			$handle = fopen($this->filename, 'w');
			foreach ($address_book as $key => $value) {
				fputcsv($handle, $value);
			}
			fclose($handle);
		}
		public function read_file() {
			if (filesize($this->filename) == 0) {
				$address_book = [];
			} else {
				$handle = fopen($this->filename, 'r');
				while(!feof($handle)) {
					$row = fgetcsv($handle);
					if (!empty($row)) {
						$address_book[] = $row;
					}
				}
				fclose($handle);
			}
			return $address_book;
		}
		public function __construct($file = FILENAME) {
			$this->filename = $file;
		}
}