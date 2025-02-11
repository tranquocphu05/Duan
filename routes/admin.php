<?php

$action = $_GET['action'] ?? '/';

if (
    empty($_SESSION['user'])
    && !in_array($action, ['show-form-login', 'login'])
) {
    header('Location: ' . BASE_URL_ADMIN . '&action=show-form-login');
    exit();
}

match ($action) {
    '/'             => (new DashboardController)->index(),
    'test-show'     => (new TestController)->show(),

    'show-form-login' => (new AuthenController)->showFormLogin(),
    'login'           => (new AuthenController)->login(),
    'logout'          => (new AuthenController)->logout(),

    // CRUD User
    'users-index'    => (new UserController)->index(),
    'users-show'     => (new UserController)->show(),
    'users-create'   => (new UserController)->create(),
    'users-store'    => (new UserController)->store(),
    'users-edit'     => (new UserController)->edit(),
    'users-update'   => (new UserController)->update(),
    'users-delete'   => (new UserController)->delete(),

    // CRUD Book
    'books-index'    => (new BookController)->index(),
    'books-show'     => (new BookController)->show(),
    'books-create'   => (new BookController)->create(),
    'books-store'    => (new BookController)->store(),
    'books-edit'     => (new BookController)->edit(),
    'books-update'   => (new BookController)->update(),
    'books-delete'   => (new BookController)->delete(),

    // CRUD Order
    'orders-index'   => (new OrderController)->index(),
    'orders-show'    => (new OrderController)->show(),
    'orders-edit'    => (new OrderController)->edit(),
    'orders-update'  => (new OrderController)->update(),  // Thêm dòng này
};
