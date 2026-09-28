<?php
require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../classes/CustomerClass.php';

class CustomerController
{
    private $customer;

    // Connect lazily so connection errors are caught inside each operation.
    private function model()
    {
        if ($this->customer === null) {
            $this->customer = new Customer();
        }
        return $this->customer;
    }

    // Retained from the starter for functions/customer_functions.php.
    public function selectAll()
    {
        return $this->model()->getAllCustomers();
    }

    private function failure($message)
    {
        return ['success' => false, 'error' => $message];
    }

    private function length($value)
    {
        // Count UTF-8 characters without requiring the mbstring extension.
        return preg_match_all('/./us', $value, $matches);
    }

    public function register($data)
    {
        $limits = ['name' => 100, 'email' => 50, 'country' => 30,
            'city' => 30, 'contact' => 15, 'address' => 255];
        foreach ($limits as $field => $max) {
            $length = $this->length($data[$field]);
            if ($length === false || $length < 1 || $length > $max) {
                return $this->failure(ucfirst($field) . " must contain 1 to $max characters.");
            }
        }
        if ($this->length($data['name']) < 2) {
            return $this->failure('Enter a name with at least 2 characters.');
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->failure('Enter a valid email address.');
        }
        if (!in_array($data['country'], COUNTRIES, true)) {
            return $this->failure('Choose a country from the list.');
        }
        if (!preg_match('/\A[0-9+\- ]{7,15}\z/', $data['contact']) ||
            preg_match_all('/[0-9]/', $data['contact']) < 7) {
            return $this->failure('Contact must have at least 7 digits and at most 15 characters; +, - and spaces are allowed.');
        }
        $pass = $data['password'];
        if (strpos($pass, "\0") !== false || strlen($pass) > 72 ||
            !preg_match('/\A(?=.*[0-9]).{8,}\z/u', $pass)) {
            return $this->failure('Password needs at least 8 characters and one digit, with a maximum of 72 UTF-8 bytes.');
        }

        try {
            $model = $this->model();
            if ($model->emailExists($data['email'])) {
                return $this->failure('Email already registered. Please log in.');
            }
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $id = $model->addCustomer($data['name'], $data['email'], $hash,
                $data['country'], $data['city'], $data['contact'], $data['address']);
            return ['success' => true, 'customer' => [
                'customer_id' => $id, 'customer_name' => $data['name'],
                'customer_email' => $data['email'], 'user_role' => 2,
            ]];
        } catch (PDOException $exception) {
            if ((int) ($exception->errorInfo[1] ?? 0) === 1062) {
                return $this->failure('Email already registered. Please log in.');
            }
            error_log($exception->getMessage());
            return $this->failure('Registration could not be completed. Check the database setup and error log.');
        }
    }

    public function login($email, $pass)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50 ||
            $pass === '' || strlen($pass) > 72 || strpos($pass, "\0") !== false) {
            return $this->failure('Enter a valid email and password.');
        }
        try {
            $model = $this->model();
            $customer = $model->login($email, $pass);
            if (!$customer) {
                return $this->failure('Incorrect email or password.');
            }
            return ['success' => true, 'customer' => $customer];
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return $this->failure('Login could not be completed. Check the database setup and error log.');
        }
    }
}
