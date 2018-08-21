<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

// Home > Login
Breadcrumbs::register('login', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', route('login'));
});

// Home > Login > Reset
Breadcrumbs::register('password.request', function ($breadcrumbs) {
    $breadcrumbs->parent('login');
    $breadcrumbs->push('Reset password', route('password.request'));
});

Breadcrumbs::register('register', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Register', route('register'));
});

Breadcrumbs::register('password.reset', function ($breadcrumbs) {
    $breadcrumbs->parent('password.request');
    $breadcrumbs->push('Change', route('password.reset'));
});

Breadcrumbs::register('cabinet', function ($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cabinet', route('cabinet'));
});