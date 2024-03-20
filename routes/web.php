<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware(['auth','can:admin'])->group(function () {

    Volt::route('/user-admin',          'admin/admin-table')->name('user.admin');
    Volt::route('/user-admin/{id}',     'admin/admin-form')->name('user.admin.form');
    Volt::route('/user-member',         'member/member-table')->name('user.member');
    Volt::route('/user-member/{id}',    'member/member-form')->name('user.member.form');

    Route::get('/sample/counter',       \App\Livewire\Counter::class)->name('sample.counter');
    Volt::route('/sample/volt-counter', 'sample/counter')->name('sample.volt-counter');

});
