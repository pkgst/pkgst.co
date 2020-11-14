# Packagist Bot for Slack
A small web-app to add a `/packagist` command to a Slack team. The command returns the first result
it finds.

You can read more about it on [the website](https://pkgst.co).

## Installation
Click this button to add Packagist Bot for Slack to your team:

[![Install Packagist Bot for Slack](https://platform.slack-edge.com/img/add_to_slack.png)](https://slack.com/oauth/authorize?scope=commands&client_id=42702902791.80650681553&redirect_uri=https://pkgst.co/auth)

## Development
The `master` branch of this repository is automatically built and published to Digital Ocean App Platform. The `develop`
branch should be used to send fixes and new features to. 

Dependabot is set up to automatically update Composer dependencies and send PRs directly to `develop`. Once those fixes
have been merged in, the `develop` branch needs to be merged into `master` for the changes to go live.
