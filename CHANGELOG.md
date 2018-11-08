# CHANGELOG

## [1.0.0-alpha] - 2018-11-xx
- Feature Message status to inform if a message was `seen`/`sent`.
- Feature MigrationsHandler for publishing timestamped migrations.
- Feature #22 User slug logic.

#### Update notes
Publish changes and run migration
```php
php artisan vendor:publish --tag="mercurius-public" --force
php artisan vendor:publish --tag="mercurius-seeds" --force
php artisan vendor:publish --tag="mercurius-migrations"
php artisan migrate
```

**(Optional)** Refresh dummy data
```php
php artisan migrate:fresh
php artisan db:seed --class=MercuriusDatabaseSeeder
```



## [0.0.10] - 2018-11-04
- Fix Chrome error, Promise was not loading.
- Fix replace sizeof() to count() on event UserStatusChanged.

## [0.0.9] - 2018-11-04
- Feature #12 Broadcast User Status.
- Added Events:
    * UserGoesActive
    * UserGoesInactive
    * UserStatusChanged
- Fix ConversationRepository->recipients() to return a Collection.
- Updated documentation.


## [0.0.8] - 2018-10-31
- Updated documentation in general.
- Added make SCSS + JS publishable.
- Added instructions how to customize Mercurius (Views, SCSS, JS).
- Fix style, on mobile, make the delete icon in messages always visible.
- Fix #7 conversations date.
- Fix #9 removing active conversation.


## [0.0.7] - 2018-10-20
- Changed Improve receivers controller #6
- Fix MessageModel: add return types #5
- Fix composer: set fixed versions and other configs #4
- Fix MessageRepository: Check user for deletion #3
- Fix some stuff #2


## [0.0.6] - 2018-10-15
- Fix scroll to the bottom when sending/receiving a message.


## [0.0.5] - 2018-10-12
- Fix when sending/receiving a message, scroll to the bottom.
- Fix ensure use of boolean types in order to support PostgreSQL.
- Changed documentation.


## [0.0.4] - 2018-10-11
- Fix SQL query to support PostgreSQL.


## [0.0.3] - 2018-10-11
- Fix messages id collision when appending a message, and request more data.


## [0.0.2] - 2018-10-11
- Changed documentation.
- Fix messages panel initialScrollY.


## [0.0.1] - 2018-10-10
- First Release beta.
