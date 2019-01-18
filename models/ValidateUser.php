<?php
class ValidateUser {
	private $username;
	private $email;
	private $password1;
	private $password2;
	private $errors = [];
	private $db;


	public function __construct($username, $email, $password1, $password2, $db){
		$this->username = $username;
		$this->email = $email;
		$this->password1 = $password1;
		$this->password2 = $password2;
		$this->db = $db;
	}

	public function validateUsername(){
		if ($this->username) {
			if (!is_int($this->username[0])) {

				if (strlen($this->username) >= 4) {
					if (!$this->checkFromDb('username', $this->username)) {
						return true;
					} else {
						$this->setError('username','Such user already exists');
						return false;
					}
				} else {
					$this->setError('username','The username couldn\'t be less than 4 symbols');
					return false;
				}
			} else {
				$this->setError('username','The username couldn\'t start with number');
				return false;
			}
		} else {
			$this->setError('username','The username couldn\'t be empty');
			return false;
		}
	}

	public function validateEmail(){
		if ($this->email){
			$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
			if (preg_match_all($pattern, $this->email)) {
				if (!$this->checkFromDb('email', $this->email)) {
					return true;
				} else {
					$this->setError('email','This email is already used!');
					return false;
				}
			} else {
				$this->setError('email','The email is not in right form');
				return false;
			}
		} else {
			$this->setError('email','The email couldn\'t be empty');
			return false;
		}
	}

	public function validatePassword(){
		if ($this->password1 === $this->password2) {
			if (strlen($this->password1) >= 8) {
				return true;
			} else {
				$this->setError('password','The password couldn\'t be less than 8 symbols!');
			}
		} else {
			$this->setError('password','The passwords are not identical!');
		}
	}


	public function checkFromDb($column, $value){
		if ($column && $value) {
			return $this->db->exist('user', $column, $value) ? true : false;
		}
	}

	public function validate(){
		$this->validateUsername();
		$this->validateEmail();
		$this->validatePassword();

		return !$this->errors ? true : false;
	}

	public function getErrors(){
		return $this->errors;
	}

	public function setError($item, $error){
		$this->errors[$item][] = $error;
	}
}