<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List questionnaires
Route::get('questionnaires', 'QuestionnaireController@index');

// Show questionnaire
Route::get('questionnaire/{id}', 'QuestionnaireController@show');

// Crete new questionnaire
Route::post('questionnaire', 'QuestionnaireController@store');

// Update questionnaire
Route::put('questionnaire', 'QuestionnaireController@store');

// Delete questionnaire
Route::delete('questionnaire/{id}', 'QuestionnaireController@destroy');
