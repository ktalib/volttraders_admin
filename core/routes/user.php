<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CryptoDepositController;
use App\Http\Controllers\User\CopyExpertController;
use App\Http\Controllers\User\StakingController;
use App\Http\Controllers\User\UserAssetController;



Route::namespace('User\Auth')->name('user.')->middleware('guest')->group(function () {
    Route::controller('LoginController')->group(function(){
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function(){
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function(){
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function(){
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller('SocialiteController')->group(function () {
        Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
        Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
    });
});

Route::middleware('auth')->name('user.')->group(function () {

    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    //authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function(){
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['check.status','registration.complete'])->group(function () {

        Route::namespace('User')->group(function () {

            Route::controller('UserController')->group(function(){
                Route::get('dashboard', 'home')->name('home');  
       

                   
            

                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form','kycForm')->name('kyc.form');
                Route::get('kyc-data','kycData')->name('kyc.data');
                Route::post('kyc-submit','kycSubmit')->name('kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions','transactions')->name('transactions');

                Route::post('add-device-token','addDeviceToken')->name('add.device.token');


                Route::get('pair/add/to/favorite/{pairSym}', 'addToFavorite')->name('add.pair.to.favorite');
                Route::get('all/currency', 'allCurrency')->name('currency.all');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function(){
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });

            Route::controller('PlanController')->name('plan.')->prefix('plan')->group(function () {
                Route::get('/', 'list')->name('list');
                Route::get('buy/{id}', 'buy')->name('buy');
                Route::post('save', 'savePlan')->name('save');
                Route::get('history', 'history')->name('history');
                Route::post('renew', 'renewPlan')->name('renew');

                Route::get('plan/progress', 'progress')->name('progress');
            });

            Route::controller('OrderController')->group(function () {
                Route::name('order.')->prefix('order')->group(function () {
                    Route::get('open', 'open')->name('open');
                    Route::get('completed', 'completed')->name('completed');
                    Route::get('canceled', 'canceled')->name('canceled');
                    Route::post('cancel/{id}', 'cancel')->name('cancel');
                    Route::post('update/{id}', 'update')->name('update');
                    Route::get('history', 'history')->name('history');
                });
                Route::get('trade/history', 'tradeHistory')->name('trade.history');
            });

            Route::controller("OrderController")->prefix('order')->name('order.')->group(function () {
                Route::post('save/{symbol}', 'save')->name('save');
            });

              //wallet
              Route::controller('WalletController')->name('wallet.')->prefix('wallet')->group(function () {
                Route::get('list', 'list')->name('list');
                Route::get('{currencySymbol}', 'view')->name('view');
                Route::post('convert', 'convert')->name('convert');
            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function(){
                Route::middleware('kyc')->group(function(){
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        // Payment
        Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function(){
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
    });
});

// Trade
Route::middleware(['auth'])->group(function () {
    Route::post('/user/trade', [UserController::class, 'store'])->name('user.trade.store');
});

Route::get('/crypto_deposit', [CryptoDepositController::class, 'cryptoDeposit'])->name('crypto.deposit.index');
Route::post('/crypto_deposit', [CryptoDepositController::class, 'store'])->name('user.crypto.deposit.store');


Route::get('/copy_expert', [CopyExpertController::class, 'CopyExpert'])->name('copy.expert.index');
Route::post('/copy_expert', [CopyExpertController::class, 'store'])->name('copy.expert.store');
Route::post('/copy_expert', [CopyExpertController::class, 'storeCopy'])->name('copy.expert.storeCopy');
Route::get('/user_assets', [UserAssetController::class, 'index'])->name('user.assets.index');
Route::get('/market', [UserAssetController::class, 'Market'])->name('market.index');
Route::get('/trade', [UserAssetController::class, 'trade'])->name('trade.index');
Route::get('/signals', [UserAssetController::class, 'Signal'])->name('user.signals.index');
Route::post('/purchase', [UserAssetController::class, 'purchase'])->name('signals.purchase');
Route::get('/subscribers', [UserAssetController::class, 'subscribers'])->name('subscribers.index');
Route::post('/buy', [UserAssetController::class, 'buy'])->name('subscribers.buy');
Route::get('/staking', [StakingController::class, 'index'])->name('staking.index');
Route::post('/staking', [StakingController::class, 'store'])->name('user.staking.store');
 
