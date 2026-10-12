<?php


require_once __DIR__ . '/../core/db_class.php';


class Customer extends Database
{
   
    public function insertCustomer($name, $email, $pass, $country, $city, $contact, $image, $role, $address = null)
    {
        
        $sql = "
            INSERT INTO customer (
                customer_name,
                customer_email,
                customer_pass,
                customer_country,
                customer_city,
                customer_contact,
                customer_image,
                user_role,
                customer_address
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        
        return $this->execute(
            $sql,
            [$name, $email, $pass, $country, $city, $contact, $image, $role, $address]
        );
    }

    public function getAllCustomers()
    {
        $sql = "
            SELECT
                customer_id,
                customer_name,
                customer_email,
                customer_country,
                customer_city,
                customer_contact,
                customer_image,
                user_role
            FROM customer
            ORDER BY customer_id DESC
            
        ";

        return $this->fetchAll($sql);
    }
  
    public function addCustomer($name, $email, $passwordHash, $country, $city, $contact, $address)
    {
        $this->insertCustomer($name, $email, $passwordHash, $country, $city,
            $contact, null, 2, $address);
        return (int) $this->getConnection()->lastInsertId();
    }

    public function emailExists($email)
    {
        return $this->fetchOne(
            'SELECT customer_id FROM customer WHERE customer_email = ?', [$email]
        ) !== false;
    }

    public function getCustomerByEmail($email)
    {
        return $this->fetchOne('SELECT * FROM customer WHERE customer_email = ?', [$email]);
    }

    public function login($email, $pass)
    {
        $customer = $this->getCustomerByEmail($email);
        if (!$customer || !password_verify($pass, $customer['customer_pass'])) {
            return false;
        }
        unset($customer['customer_pass']);
        return $customer;
    }
}

class CustomerClass extends Customer
{
}
