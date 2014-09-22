<?php
require('../inc/filestore.php');
class AddressDataStore  extends Filestore {
		public function save_file($address_book) {	
			$this->write_csv();
		}
		public function read_file() {
			return $this->read_csv();
		}
}