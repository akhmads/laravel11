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

    Volt::route('/contact',             'contact/contact-table')->name('master.contact');
    Volt::route('/contact/{id}',        'contact/contact-form')->name('master.contact.form');
    Volt::route('/item',                'item/item-table')->name('master.item');
    Volt::route('/item/{id}',           'item/item-form')->name('master.item.form');

    Route::get('/tenant/create', [\App\Http\Controllers\TenantSetupController::class, 'create']);
    Route::get('/tenant/drop', [\App\Http\Controllers\TenantSetupController::class, 'drop']);

    //Route::get('play', [\App\Http\Controllers\PlayController::class, 'index']);
    Volt::route('/play', 'play.play');
});
