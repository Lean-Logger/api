<?php

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

$router->group(['prefix' => 'api', 'namespace' => 'App\Presentation\Http\Controllers'], function () use ($router) {

    $router->group(['middleware' => ['logintoken']], function() use ($router) {
        $router->post('exercises', ['as' => 'add-exercise-to-library', 'uses' => 'AddExerciseToLibraryController@execute']);
        $router->put('exercises/{id}', ['as' => 'edit-exercise', 'uses' => 'EditExerciseController@execute']);

        $router->post('logout', ['as' => 'logout-user', 'uses' => 'LogoutUserController@execute']);
    });

//    $router->delete('exercises/{uuid}', ['as' => 'remove-exercise-from-library', 'uses' => 'RemoveExerciseFromLibraryController@execute']);
//
//    $router->get('workouts', ['as' => 'get-workouts', 'uses' => 'GetWorkoutsController@execute']);
//    $router->post('workouts', ['as' => 'start-workout', 'uses' => 'StartWorkoutController@execute']);
//    $router->post('workouts/{uuid}/exercises', ['as' => 'add-exercise-to-workout', 'uses' => 'AddExerciseToWorkoutController@execute']);
//    $router->put('workouts/{uuid}/finish', ['as' => 'finish-workout', 'uses' => 'FinishWorkoutController@execute']);

    $router->post('login', ['as' => 'login-user', 'uses' => 'LoginUserController@execute']);

    $router->post('register', ['as' => 'register-user', 'uses' => 'RegisterUserController@execute']);

    $router->post('request-password-reset', ['as' => 'request-password-reset', 'uses' => 'RequestPasswordResetController@execute']);
    $router->post('reset-password', ['as' => 'reset-password', 'uses' => 'ResetPasswordController@execute']);

//    $router->put('profile', ['as' => 'update-profile', 'uses' => 'UpdateProfileController@execute']);
});

