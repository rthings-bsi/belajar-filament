<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email dari WebPKL', function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Email');
        });
        return 'Email berhasil dikirim! Cek Mailtrap inbox.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
