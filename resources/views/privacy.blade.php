@extends('layouts.master')

@section('title', 'Privacy')

@section('content')
    <h1>Privacy</h1>

    <p>
        This app does not collect any of the data it recieves. It simply relays whatever you type after <code>/packagist</code>
        to <a href="//packagist.org">packagist.org</a>'s API and forms a proper reponse to send back to your Slack channel.
        In fact, the application is <a href="//github.com/pkgst/website">open source</a> so you can see how it works for yourself!
    </p>

    <p>
        When using Packagist Bot, Slack provides it with some basic information. You can find out more about this data from
        <a href="//api.slack.com/slash-commands">their API docs</a>. Packagist Bot does not collect any email addresses,
        names or any other personal identifyable information.
    </p>
@endsection
