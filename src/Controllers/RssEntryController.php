<?php
/**
 * Created by PhpStorm.
 * User: sosek108
 * Date: 04.04.16
 * Time: 20:58
 *
 * Obsługuje API
 */

namespace Sosek\RssReader\Controllers;

use Carbon\Carbon;
use Faker\Provider\tr_TR\DateTime;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Sosek\RssReader\RssEntry;

/**
 * Class RssEntryController
 * @package Sosek\RssReader\Controllers
 */
class RssEntryController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * AKtualizuje baze danych z zewnetrznym serwerem.
     * Jako parametr w request trzeba podac 'url'
     */
    public function getUpdateFromOnline(Request $request)
    {
        $url = $request->input('url');

        if (empty($url) or filter_var($url, FILTER_VALIDATE_URL) == false) {
            return response('błędny adres url', 400);
        };


        $anyUpdated = false;

        $feedEntries = new \SimpleXMLElement($url, 0, true); //ze wzgledu na brak wymagan nie pokusze sie o sprawdzenie poprawnosci XML.
        $dbEntries= RssEntry::where(['source' => $url])->orderBy('created_at', 'desc')->get();

        $feedUpdated = new Carbon((string) $feedEntries->updated);
        if (count($dbEntries))
            $lastUpdated = $dbEntries[0]->created_at;

        if (empty($lastUpdated) or (!empty($lastUpdated) and $lastUpdated < $feedUpdated)) {
            foreach($feedEntries->entry as $feedEntry) {
                $feedEntryCreated = new Carbon($feedEntry->published);
                if (empty($lastUpdated) or $feedEntryCreated > $lastUpdated) {
                    //nowe wpisy
                    $link = '';
                    foreach($feedEntry->link as $link) {
                        if ((string)$link->attributes()->rel == 'alternate') {
                            $link = (string)$link->attributes()->href;
                            break;
                        }
                    }
                    $content = (string) (!empty($feedEntry->content) ? $feedEntry->content->asXML() : $feedEntry->summary->asXML());
                    $newRssEntry = new RssEntry();
                    $newRssEntry->title = (string) $feedEntry->title;
                    $newRssEntry->external_id = (string) $feedEntry->id;
                    $newRssEntry->content = $content;
                    $newRssEntry->url = $link;
                    $newRssEntry->source = $url;
                    $newRssEntry->created_at = $feedEntryCreated;
                    $newRssEntry->updated_at = null;
                    $newRssEntry->save();
                    $anyUpdated = true;
                }

            }
        }

        return response()->json([
            'any_updated' => $anyUpdated,
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Pobiera wszystkie elementy z bazy
     */
    public function getAll()
    {
        $rssEntries = RssEntry::orderBy('created_at', 'desc')->get();

        return response()->json($rssEntries);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Tworzy nowy element
     */
    public function postCreate(Request $request)
    {
        $newTitle = $request->input('title');
        $newContent = $request->input('content');

        if (empty($newContent) || empty($newTitle))
            return response('zle zapytanie', 400);

        $entry = new RssEntry();
        $entry->title = $newTitle;
        $entry->external_id = $newTitle . time();
        $entry->content = $newContent;
        $entry->url = '#';
        $entry->source = 'Local';
        $entry->updated_at = null;
        $entry->save();
        return response()->json($entry);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * Usuwa element
     */
    public function deleteDestroy($id)
    {
        $entry = RssEntry::where(['id' => $id]);
        if (empty($entry)) {
            return response('nie ma takiego id w bazie', 404);
        }

        $entry->delete();

        return response('ok');

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * Akturalizuje element
     */
    public function patchUpdate(Request $request, $id)
    {
        $edit = false;
        $entry = RssEntry::where(['id' => $id])->get()[0];
        if (empty($entry)) {
            return response('nie ma takiego id w bazie', 404);
        }
        $newTitle = $request->input('title');
        $newContent = $request->input('content');
        if (!empty($newTitle) && $newTitle != $entry->title) {
            $entry->title = $newTitle;
            $edit = true;
        }
        if (!empty($newContent) && $newContent != $entry->content) {
            $entry->content = $newContent;
            $edit = true;
        }
        if ($edit) {
            $entry->source = 'Local';
            $entry->save();
        }
        return response()->json($entry);
    }
} 