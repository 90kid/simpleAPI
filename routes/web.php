<?php

use http\Client\Response;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/country/{country}', function ($country) {
    $client = new GuzzleHttp\Client();
    try {
        $res = $client->request('GET', 'https://restcountries.eu/rest/v2/name/' . $country);
        if($res->getStatusCode() === 200)
            return $res->getBody();
        else{
            return view('errors.missing', ['problem' => $res->getStatusCode()]);
        }
    }catch (GuzzleHttp\Exception\ClientException $e){
        return view('errors.missing', ['problem' => $e->getMessage()]);
    }
});
