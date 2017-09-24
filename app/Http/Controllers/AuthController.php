<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

class AuthController extends Controller
{
    /**
     * Authenticate with Slack. Stolen from Chris White <https://github.com/cwhite92/XKCDBot>
     *
     * @param \Illuminate\Http\Request                       $request
     * @param \League\OAuth2\Client\Provider\GenericProvider $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, GenericProvider $provider)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        try {
            // We'll just request an access token and do nothing with it, completing the OAuth flow
            $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code'),
            ]);
        } catch (IdentityProviderException $e) {
            // Silently fail... shhhh.
        }

        return redirect('/installed');
    }
}
