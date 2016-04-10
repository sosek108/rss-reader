<?php
/**
 * Created by PhpStorm.
 * User: sosek108
 * Date: 04.04.16
 * Time: 20:58
 *
 * Wyświetlanie RSS
 */

namespace Sosek\RssReader\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class RssReaderController extends BaseController
{
    public function showFeed()
    {
        $url = config('rss-reader.urldefault');

        return View::make('rss-reader::show');

    }
} 