<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


use Laravel\Lumen\Routing\Router;


$router->group(['prefix' => 'api/v1', ], function () use ($router) {

    // Routes for registering a new user.
    $router->post('register', 'AuthController@register');
    $router->get('register', function (){
        return response()->json([
            "data" => "Error: No provided data to register!"
        ]);
    });

    // TODO:: Verification by email or phone number.
   // $router->get('email/verify/{id}', ['as' => 'verification.verify', 'uses' => 'VerificationController@verify']);
    // $router->get('email/resend/{id}', ['as' => 'verification.resend', 'uses' => 'VerificationController@resend']);

    // Routes for login
    $router->post('login', 'AuthController@login');
    $router->get('login',  function (){
        return response()->json([
            "data" => "Error: No provided data to login!"
        ]);
    });

    // Routes for Create, Update, and Delete an Article!
    $router->get('create_article', 'ArticleController@create');
    $router->put('update_article/{id}', 'ArticleController@update');
    $router->delete('delete_article/{id}', 'ArticleController@delete');

    // Route for fetching user profile data with his articles.
    $router->get('profile/{id}', 'ProfileController@show');
});
