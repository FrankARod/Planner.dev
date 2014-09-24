<?php

class Filestore {

		private $filename = '';

		private $is_csv = false;

		function __construct($filename = '')
		{
			$this->filename = $filename;
			if (substr($this->filename, -3) == 'csv') {
				$this->is_csv = true;
			}
		}

		/**
			* Returns array of lines in $this->filename
		*/
		private function read_lines()
		{
			$handle = fopen($this->filename, 'r');
			$list = fread($handle, filesize($this->filename));
			fclose($handle);
			return explode(PHP_EOL, $list);
		}

		/**
			* Writes each element in $array to a new line in $this->filename
		*/
		private function write_lines($array)
		{
		 	$handle = fopen($this->filename, 'w');
			$list = implode(PHP_EOL, $array);
			fwrite($handle, $list);
			fclose($handle);
		}

		/**
			* Reads contents of csv $this->filename, returns an array
			*/
		private function read_csv()
		{
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

		/**
			* Writes contents of $array to csv $this->filename
			*/
		private function write_csv($array)
		{
			$handle = fopen($this->filename, 'w');
			foreach ($array as $key => $value) {
				fputcsv($handle, $value);
			}
			fclose($handle);
		}

		public function read() {
			if ($this->is_csv) {
				return $this->read_csv();
			}
			else {
				return $this->read_lines();
			}
		}

		public function write($array) {
			if ($this->is_csv) {
				$this->write_csv($array);
			} else {
				$this->write_lines($array);
			}
		}

}