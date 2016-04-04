<?php


//Main page for rss-reader
Route::get('/rss', function () {
    return view('rss-reader::index');
});
