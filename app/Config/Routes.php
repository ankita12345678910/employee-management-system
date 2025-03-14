<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'EmployeeController::dashboard',['as'=>'dashboard']);
$routes->match(['GET', 'POST'], 'manage/employee/(:segment)', 'EmployeeController::manageEmployee/$1', ['as' => 'employee_manage']);
$routes->get('list/employee', 'EmployeeController::listEmployee', ['as' => 'all_employee']);
$routes->delete('delete/employee/(:num)', 'EmployeeController::deleteEmployee/$1', ['as' => 'delete_employee']);
$routes->match(['GET', 'POST'], 'login', 'AuthController::login', ['as' => 'login']);
$routes->get('logout', 'AuthController::logout', ['as' => 'logout']);
