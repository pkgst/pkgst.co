<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class PackageNotFound implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return new Response([
            'response_type' => 'ephemeral',
            'text' => 'I couldn\'t find a package with those search terms, sorry!',
        ]);
    }
}
