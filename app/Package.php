<?php

namespace App;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class Package implements Responsable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $repository;

    /**
     * @var int
     */
    protected $downloads;

    /**
     * @var int
     */
    protected $favers;

    /**
     * Package constructor.
     *
     * @param array $packageDetails
     */
    protected function __construct(array $packageDetails)
    {
        foreach ($packageDetails as $property => $value) {
            if (! property_exists($this, $property)) {
                continue;
            }

            $this->$property = $value;
        }
    }

    /**
     * @return string
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * @return int
     */
    public function downloads()
    {
        return number_format($this->downloads);
    }

    /**
     * @return int
     */
    public function favers()
    {
        return number_format($this->favers);
    }

    /**
     * @return string
     */
    public function installCommand()
    {
        return sprintf('```composer require %s```', $this->name);
    }

    /**
     * Create a new Package object from a unserialized packagist search response.
     *
     * @param array $searchResult
     *
     * @return static
     */
    public static function fromSearchResult(array $searchResult)
    {
        return new self($searchResult);
    }

    /**
     * Create a new Package object from a unserialized Packagist package details response.
     *
     * @param array $packageDetails
     *
     * @return static
     */
    public static function fromPackageDetails(array $packageDetails)
    {
        if (! array_key_exists('package', $packageDetails)) {
            throw new \InvalidArgumentException('Missing package details in response');
        }

        $package = $packageDetails['package'];
        $package['url'] = 'https://packagist.org/packages/'.$package['name'];
        $package['downloads'] = $package['downloads']['total'];

        return new self($package);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return new Response([
            'response_type' => 'in_channel',
            'attachments' => [
                [
                    'fallback' => $this->description,
                    'title' => $this->name,
                    'title_link' => $this->url,
                    'text' => $this->description,
                    'mrkdwn_in' => ['fields'],
                    'fields' => [
                        [
                            'title' => ':sparkles: Stars',
                            'value' => $this->favers(),
                            'short' => true,
                        ],
                        [
                            'title' => ':arrow_down: Downloads',
                            'value' => $this->downloads(),
                            'short' => true,
                        ],
                        [
                            'title' => ':package: Install command',
                            'value' => $this->installCommand(),
                            'short' => false,
                        ],
                    ],
                ],
            ],
        ]);
    }
}

