<?php


require_once __DIR__ . '/../controllers/CustomerController.php';


function getAllCustomersList()
{
   
    $controller = new CustomerController();

    return $controller->selectAll();
}
