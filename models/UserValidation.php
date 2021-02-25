<?php
declare(strict_types=1);

class UserValidation
{
    const PATTERN = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

//    private string $username;
//    private string $email;
//    private string $password1;
//    private string $password2;
    private array $errors = [];
    private \PDO $db;
    private User $user;

    public function __construct(User $user, PDO $db)
    {
        $this->user = $user;
        $this->db = $db;
    }

    private function validateUsername(): void
    {
        if ($this->user->username === '') {
            $this->setError('username', 'The username couldn\'t be empty');
        }

        if ($this->user->username[0] >= '0' && $this->user->username[0] <= '9') {
            $this->setError(
                'username',
                'The username couldn\'t start with number'
            );
        }

        if (mb_strlen($this->user->username) < 4) {
            $this->setError('username','The username couldn\'t be less than 4 symbols');
        }

        if ($this->checkFromDb('username', $this->user->username)) {
            $this->setError('username', 'Such user already exists');
        }
    }

    public function validateEmail(): void
    {
        if ($this->user->email === '') {
            $this->setError('email','The email couldn\'t be empty');
        }

        if (!preg_match_all(self::PATTERN, $this->user->email)) {
            $this->setError('email','The email is not in right form');
        }

        if ($this->checkFromDb('email', $this->user->email)) {
            $this->setError('email', 'This email is already used!');
         }
    }

    public function validatePassword(): void
    {
        if ($this->user->password1 !== $this->user->password2) {
            $this->setError('password', 'The passwords are not identical!');
        }

        if (strlen($this->user->password1) < 8) {
            $this->setError('password', 'The password couldn\'t be less than 8 symbols!');
        }
    }

    public function checkFromDb(string $column, $value): bool
    {
        if ($column && $value) {
            return $this->db->exist('user', $column, $value);
        }

        return false;
    }

    public function validate(): bool
    {
        $this->validateUsername();
        $this->validateEmail();
        $this->validatePassword();

        return $this->errors === [];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function setError(string $item, string $error)
    {
        $this->errors[$item][] = $error;
    }
}