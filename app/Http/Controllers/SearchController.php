<?php

namespace App\Http\Controllers;

use App\Services\SearchHandler;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Respond to the webhook from Slack.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \App\Services\SearchHandler $handler
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function __invoke(Request $request, SearchHandler $handler)
    {
        $query = trim($request->get('text'), '/');

        return $handler->search($query);
    }
}
