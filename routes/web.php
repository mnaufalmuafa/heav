<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('dashboard');
});

// Route::get('/', 'buyer\SearchController@search');

Route::middleware(['LoginAndSignUpMiddleware'])->group(function() {
    Route::get('/login', 'LoginController@index')
        ->name('login');

    Route::post('/login', 'LoginController@checkLogin');

    Route::get('/signup', 'SignUpController@index')
        ->name('signup');

    Route::post('/signup', 'SignUpController@signUp');

    Route::prefix('/account')->group(function() {
        Route::get('/begin_reset_password', 'LoginController@beginResetPassword');
        Route::post('/begin_reset_password', 'LoginController@resetPassword');
        Route::get('/reset/password/from/email', 'LoginController@changePassword');
        Route::get('/reset/password/sent', 'LoginController@resetPasswordSent')->name('reset-password-sent');
        Route::post('/reset/password/from/email', 'LoginController@updatePassword');
    });
});

Route::post('/logout', 'LogoutController@index');

Route::get('/account/verificate', 'SignUpController@verificateEmail');

Route::get('/search/book', 'buyer\SearchController@search');

Route::prefix('/get')->group(function() {
    Route::get('/get_people_gave_stars_count_all_rating/{id}', 'buyer\BookController@getPeopleGaveStarsCountAllRating');
    Route::get('/get_people_gave_stars_count_by_rating/{id}/{rating}', 'buyer\BookController@getPeopleGaveStarsCountByRating');
    Route::get('/get_reviews_by_book_id/{bookId}', 'buyer\BookController@getReviewsByBookId');
});

Route::middleware(['IsLogin'])->group(function() {
    Route::get('/email/verification', 'SignUpController@emailVerification')
        ->middleware('IsTheEmailNotVerified')
        ->name('email-verification');

    Route::middleware(['HasTheEmailBeenVerified'])->group(function(){
        // UNTUK BUYER
        Route::get('/dashboard', 'buyer\DashboardController@index')
            ->name('dashboard');

        Route::get('/search', 'buyer\SearchController@index')
            ->name('search');

        Route::post('/bepublisher', 'publisher\DashboardController@bePublisher');

        Route::get('/book/detail/{id}/{slug}', 'buyer\BookController@index');

        Route::prefix('/get')->group(function() {
            Route::get('/get_user_role_for_ebook_info_page/{bookId}', 'buyer\BookController@getUserRoleForEbookInfoPage');
        });

        // UNTUK PUBLISHER
        Route::prefix('/publisher')->middleware('DoesPublishers')->group(function() {

            Route::get('/dashboard', 'publisher\DashboardController@index')
                ->name('dashboard-publisher');

            Route::get('/edit', 'publisher\DashboardController@editDataPublisher')
                ->name('edit-data-publisher');
            
            Route::post('/edit', 'publisher\DashboardController@updateDataPublisher')
                ->name('edit-data-publisher-POST');
            
            Route::get('/input/book', 'publisher\BookController@create')
                ->name('input-book');

            Route::post('/input/book', 'publisher\BookController@store')
                ->name('input-book-POST');

            Route::middleware(['DoesPublisherHaveThatBook'])->group(function() {
                Route::get('/edit/book', 'publisher\BookController@edit')
                    ->name('edit-book');

                Route::post('/edit/book', 'publisher\BookController@update')
                    ->name('edit-book-POST');

                Route::post('/delete/book', 'publisher\BookController@destroy')
                    ->name('delete-book');
            });

        });
    });

        
});

