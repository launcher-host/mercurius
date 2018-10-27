<p align="center">
    <a href="https://www.github.com/launcher-host/mercurius/" target="_blank">
        <img width="500px" src="docs/logo-mercurius_alt.png" title="mercurius logo">
    </a>
</p>

<h2 align="center">Messenger for Laravel</h2>

<p align="center">
<a href="https://travis-ci.org/launcher-host/mercurius"><img src="https://travis-ci.org/launcher-host/mercurius.svg?branch=master" alt="Build Status"></a>
<a href="https://styleci.io/repos/147903408/shield?style=flat"><img src="https://styleci.io/repos/147903408/shield?style=flat" alt="Build Status"></a>
<a href="https://packagist.org/packages/launcher/mercurius"><img src="https://poser.pugx.org/launcher/mercurius/v/stable.svg?format=flat" alt="Latest Version"></a>
<a href="https://packagist.org/packages/launcher/mercurius"><img src="https://poser.pugx.org/launcher/mercurius/downloads.svg?format=flat" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/launcher/mercurius"><img src="https://poser.pugx.org/launcher/mercurius/license.svg?format=flat" alt="License"></a>
</p>


## About

Mercurius is a real-time messenger system using Laravel and Vue.js, featuring a complete application that you can easily install with any Laravel project.

<br>


## Features

- Real-time Messenger
- Responsive
- Multilingual
- Browser notifications
- Unique UX, with dark and light theme
- Lazy load messages
- Remove conversations and messages
- Search recipients with auto-complete


<br>


### Screenshots
<small>Click thumbs to display larger image</small>
<p align="center">
    <a href="docs/mercurius_01_home.png" target="_blank" title="screenshot mercurius - no conversations"><img src="docs/mercurius_01_home.png" width="33%"></a>
    <a href="docs/mercurius_02_view_conversation.png" target="_blank" title="screenshot mercurius - view conversation"><img src="docs/mercurius_02_view_conversation.png" width="33%"></a>
    <a href="docs/mercurius_03_messages_hover.png" target="_blank" title="screenshot mercurius - messages hover"><img src="docs/mercurius_03_messages_hover.png" width="33%"></a>
</p>
<p align="center">
    <a href="docs/mercurius_04_compose_message.png" target="_blank" title="screenshot mercurius - compose message"><img src="docs/mercurius_04_compose_message.png" width="33%"></a>
    <a href="docs/mercurius_05_find_recipient_results.png" target="_blank" title="screenshot mercurius - find recipient results"><img src="docs/mercurius_05_find_recipient_results.png" width="33%"></a>
    <a href="docs/mercurius_06_user_settings.png" target="_blank" title="screenshot mercurius - user settings"><img src="docs/mercurius_06_user_settings.png" width="33%"></a>
</p>

<br>

### Preview
<small>Desktop version</small>
<small style="float: right; text-align: right;">Mobile version</small>
<a href="docs/mercurius_preview_2018-oct.gif" target="_blank">
    <img width="100%" src="docs/mercurius_preview_2018-oct.gif" title="mercurius preview">
</a>
<small style="text-align: right; float: right;">Desktop notifications</small>


<br>

## Demo

A demo version is available for testing, [click here](http://mercurius-demo.herokuapp.com/login) to try Mercurius.
For authenticate use any of the following credentials:

- Ian: `ian@launcher.host`
- Noa: `noa@launcher.host`
- Lua: `lua@launcher.host`

Password: `password`

Tip: open 2 different browsers and login with distinct users.

<br>

## Requirements

- Laravel 5.6 or 5.7
- Pusher account
- Vue.js 2.0
- BS 4

<br>

## Setup Pusher
If you don't have an account, create a free one on [pusher.com website](https://pusher.com/). Go to the dashboard, create a new app and take note of the API credentials.

Now, let's add the API keys to the `.env` file.
Also, change the `BROADCAST_DRIVER` to `pusher` (default is `log`).
```php
...
BROADCAST_DRIVER=pusher
...
PUSHER_APP_ID="xxxxxx"
PUSHER_APP_KEY="xxxxxxxxxxxxxxxxxxxx"
PUSHER_APP_SECRET="xxxxxxxxxxxxxxxxxxxx"
PUSHER_APP_CLUSTER="xx"
```



## Installation

##### 1. Register `BroadcastServiceProvider`
Open `config/app.php` and uncomment the line `App\Providers\BroadcastServiceProvider::class,`.


##### 2. Laravel Authentication
Skip this step if authentication is already setup, otherwise type:
```bash
php artisan make:auth
```


##### 3. Install Mercurius
```bash
composer require launcher/mercurius
```


##### 4. Publish the config file
```bash
php artisan vendor:publish --tag=mercurius-config
```


##### 5. Configuration (optional)

For changing the default configuration, open `/config/mercurius.php` and add your own.

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Mercurius Models
    |--------------------------------------------------------------------------
    |
    | Defines the models used with Mercurius, use it to extend Mercurius and
    | create your own implementation.
    |
    */

    'models' => [
        'user' => App\User::class,
        'messages' => Launcher\Mercurius\Models\Message::class,
    ],
];
```


##### 6. Install Mercurius

```bash
php artisan mercurius:install
composer dump-autoload
```


##### 7. Install dummy data (for testing)
```bash
php artisan db:seed --class=MercuriusDatabaseSeeder
```



## Demo Accounts
If you seed the dummy data, you will get 3 demo accounts for test the system.

- Ian: `ian@launcher.host`
- Noa: `noa@launcher.host`
- Lua: `lua@launcher.host`

Password: `password`



## Roadmap
- Unit tests
- Typing indicator
- Broadcast user status (when he goes on/off)
- Conversation with multiple users
- Search messages content
- Upload photos and attach files
- Preview images and videos
- Emoji support



## Support
- Create a [new issue](../../issues)
- Join us on [Slack Channel](http://mercurius-demo.herokuapp.com/join-slack-launcher-host)



## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for more information.



## Changelog
We keep a [CHANGELOG](CHANGELOG.md) with the information that has changed.



## Credits
- [Bruno Torrinha](https://torrinha.com)
- [All Contributors](../../contributors)



## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
