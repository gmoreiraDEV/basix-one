<?php
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('crm::dashboard'))->name('dashboard');
