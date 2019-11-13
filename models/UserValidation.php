<?php

class UserValidation
{
	const PATTERN = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

	private $username;
	private $email;
	private $password1;
	private $password2;
	private $errors = [];
	private $db;
	

	public function __construct($username, $email, $password1, $password2, $db)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password1 = $password1;
		$this->password2 = $password2;
		$this->db = $db;
	}

	public function validateUsername()
	{
		if ($this->username) {
			if (!is_int($this->username[0])) {
				if ($this->hasUsernameAllowedLength()) {
					$this->isUserExist();
				}
			} else {
				$this->setError('username', 'The username couldn\'t start with number');
			}
		} else {
			$this->setError('username', 'The username couldn\'t be empty');
		}
	}

	public function validateEmail()
	{
		if ($this->email)
			if ($this->isRightEmail()) 
				$this->isEmailExist();
		else $this->setError('email','The email couldn\'t be empty');
	}

	private function isRightEmail(): bool
	{
		if (!preg_match_all(self::PATTERN, $this->email)) {
			$this->setError('email','The email is not in right form');
			return false;
		}

		return true;
	}

	private function isEmailExist(): bool
	{
		if ($this->checkFromDb('email', $this->email)) {
			$this->setError('email', 'This email is already used!');
			return false;
		}

		return true;
	}

	private function isUserExist(): bool
	{
		if ($this->checkFromDb('username', $this->username)) {
			$this->setError('username', 'Such user already exists');
			return false;
		}

		return true;
	}

	public function validatePassword()
	{
		if ($this->isPasswordConfirmed())
			$this->hasPasswordAllowedLength();
	}

	private function isPasswordConfirmed(): bool
	{
		if ($this->password1 !== $this->password2) {
			$this->setError('password', 'The passwords are not identical!');
			return false;
		}

		return true;
	}

	private function hasPasswordAllowedLength(): bool 
	{
		if (strlen($this->password1) < 8) {
			$this->setError('password', 'The password couldn\'t be less than 8 symbols!');
			return false;
		}

		return true;
	}

	private function hasUsernameAllowedLength(): bool
	{
		if (strlen($this->username) < 4) {
			$this->setError('username','The username couldn\'t be less than 4 symbols');
			return false;
		}

		return true;
	}

	public function checkFromDb(string $column, $value): bool
	{
		if ($column && $value) {
			return $this->db->exist('user', $column, $value);
		}

		return false;
	}

	public function validate()
	{
		$this->validateUsername();
		$this->validateEmail();
		$this->validatePassword();

		return !$this->errors;
	}

	public function getErrors(): array
	{
		return $this->errors;
	}

	public function setError(string $item, string $error)
	{
		$this->errors[$item][] = $error;
	}
}