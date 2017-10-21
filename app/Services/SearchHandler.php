<?php

namespace App\Services;

use App\Http\Responses\PackageNotFound;
use App\Package;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SearchHandler
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * SearchHandler constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $query
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function search($query)
    {
        // Search query is in format "vendor/package-name"
        if (preg_match('~[a-z0-9]([_.-]?[a-z0-9]+)*\/[a-z0-9]([_.-]?[a-z0-9]+)*~', $query)) {
            return $this->searchWithVendor($query);
        }

        return $this->searchWithoutVendor($query);
    }

    /**
     * Search Packagist with a regular query.
     *
     * @param string $query
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    protected function searchWithoutVendor($query)
    {
        $result = $this->client->request('GET', 'https://packagist.org/search.json?q='.$query);

        $packages = json_decode($result->getBody(), true);

        if (empty($packages['results'])) {
            return new PackageNotFound;
        }

        list($package) = $packages['results'];

        return Package::fromSearchResult($package);
    }

    /**
     * Search for a specific package on Packagist.
     *
     * @param string $query
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    protected function searchWithVendor($query)
    {
        try {
            $result = $this->client->request('GET', 'https://packagist.org/packages/'.$query.'.json');
        } catch (RequestException $e) {
            return new PackageNotFound;
        }

        if ($result->getStatusCode() === 404) {
            return new PackageNotFound;
        }

        $response = json_decode($result->getBody(), true);

        return Package::fromPackageDetails($response);
    }
}
