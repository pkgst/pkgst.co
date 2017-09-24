@extends('layouts.master')

@section('title', 'Packagist Bot for Slack')

@section('content')
    <h1>Packagist Bot for Slack</h1>
    <p>
        Click the button below to add Packagist Bot to your Slack team. This will add a <code>/packagist</code> command
        to search <a href="//packagist.org">Packagist</a>, the biggest repository of PHP packages directly
        from within Slack.
    </p>

    <blockquote>
        Packagist Bot is not owned by and/or affiliated with the good folks over at <a href="//packagist.org">Packagist</a>.
    </blockquote>

    <a href="//slack.com/oauth/authorize?scope=commands&client_id={{ config('services.slack.client_id') }}&redirect_uri={{ config('services.slack.redirect_uri') }}" class="no-style">
        <img alt="Add to Slack"
             height="40"
             width="139"
             src="//platform.slack-edge.com/img/add_to_slack.png"
             srcset="//platform.slack-edge.com/img/add_to_slack.png 1x, //platform.slack-edge.com/img/add_to_slack@2x.png 2x"
        />
    </a>

    <h2>Usage</h2>
    <p>
        You can search for <code>vendor/package-name</code> or simply give it a search term. It will try to return the
        package itself (if you include a <code>/</code>), otherwise it will return the top result from <a href="//packagist.org">Packagist</a>.
    </p>

    <img src="/images/demo.png">
@endsection
