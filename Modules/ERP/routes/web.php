<?php
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('erp::dashboard'))->name('dashboard');
