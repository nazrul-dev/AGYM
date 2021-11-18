<?php

use App\Http\Livewire\Account;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Loan\Data as LoanData;
use App\Http\Livewire\Master\{Product as MasterProduct, Category, Staff, Stock};
use App\Http\Livewire\Members\Data as MembersData;
use App\Http\Livewire\Members\{ExpiredMember, HistoryRenew, Info};
use App\Http\Livewire\Reports\Stock as ReportsStock;
use App\Http\Livewire\Reports\Transaction;
use App\Http\Livewire\Setting;
use App\Http\Livewire\Simpanan;
use App\Http\Livewire\Transactions\{NewMember, Product, Renew, Rent, Cash, Data, Info as TransactionsInfo, SelectTypeTransaction};
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/setting/{type?}', Setting::class)->name('setting');
    Route::get('/account', Account::class)->name('account');
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('transaction-info/{transaction}', TransactionsInfo::class)->name('info');
        Route::get('/select-type', SelectTypeTransaction::class)->name('select.type');
        Route::get('/pos-product', Product::class)->name('product');
        Route::get('/new-member', NewMember::class)->name('new.member');
        Route::get('/renew-member', Renew::class)->name('renew.member');
        Route::get('/rent', Rent::class)->name('rent');
        Route::get('/cash', Cash::class)->name('cash');
        Route::get('/data', Data::class)->name('data');
    });
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/data', MembersData::class)->name('data');
        Route::get('/expired-member', ExpiredMember::class)->name('expired');
        Route::get('/history-renew/{member}', HistoryRenew::class)->name('history.renew');
        Route::get('/info-member/{member}', Info::class)->name('info');
    });

    Route::prefix('loans')->name('loans.')->group(function () {
        Route::get('/data', LoanData::class)->name('data');
    });
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/product', MasterProduct::class)->name('product');
        Route::get('/category', Category::class)->name('category');
        Route::get('/staff', Staff::class)->name('staff');
    });
    Route::prefix('stocks')->name('stocks.')->group(function () {
        Route::get('/data/{type?}', Stock::class)->name('data');
    });
    Route::get('simpanan', Simpanan::class)->name('simpanan');
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('transactions', Transaction::class)->name('transactions');
        Route::get('stocks', ReportsStock::class)->name('stocks');
    });
});

require __DIR__ . '/auth.php';
