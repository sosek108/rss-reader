<?php


//Main page for rss-reader
Route::get('/rss', 'Controllers\RssReaderController@showFeed');

//Route::group(['prefix' => '/rss-entry'], function() {
//    Route::resource('/', 'Controllers\RssEntryController',
//        ['only' => ['create', 'destroy', 'update']]);
//    Route::get('/list', 'Controllers\RssEntryController@listAll');
//    Route::get('/update', 'Controllers\RssEntryController@updateFromOnline');
    Route::controller('/rss-entry', 'Controllers\RssEntryController');
//});
