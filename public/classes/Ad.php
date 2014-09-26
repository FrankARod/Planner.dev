<?php

require_once('../dbconnect.php');

class Ad {

	public $dbc;
	public $id;
	public $title = '';
	public $body = '';
	public $date = '';
	public $username = '';
	public $email = '';

	public function __construct($dbc) {
		$this->dbc = $dbc;
	}

	public static function find($id) {
		$this->id = $id;
		$select_query = "SELECT * FROM items WHERE id = ?";
		$select_stmt = $this->dbc->prepare($select_query);
		$select_stmt->execute([$this->id]);

		$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

		$ad = new Ad();
		$ad->title = $row['title'];
		$ad->body = $row['body'];
		$ad->date = new DateTime($row['created_at']);
		$ad->username = $row['name'];
		$ad->email = $row['email'];

		return $ad;
	}

	public function save() {
		if (isset($this->id)) {
			$this->update();
		} else {
			$this->insert();
		}	
	}

	public function update() {
		$update_sql = "UPDATE items SET title = :title, body = :body, created_at = :created_at, name = :name, email = :email WHERE id = :id";
		$stmt = $this->dbc->prepare($update_sql);
		$stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
		$stmt->bindValue(':body', $this->body, PDO::PARAM_STR);
		$stmt->bindValue(':created_at', $this->date->date, PDO::PARAM_STR);
		$stmt->bindValue(':name', $this->username, PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function insert() {
		$insert_sql = "INSERT INTO items (title, body, name, email) VALUES (:title, :body, :name, :email)";
		$insert_stmt = $this->dbc->prepare($insert_sql);
		$insert_stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
		$insert_stmt->bindValue(':body', $this->body, PDO::PARAM_STR);
		// $insert_stmt->bindValue(':created_at', $this->date, PDO::PARAM_STR);
		$insert_stmt->bindValue(':name', $this->username, PDO::PARAM_STR);
		$insert_stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$insert_stmt->execute();
		$this->id = $this->dbc->lastInsertId();
	}
}
