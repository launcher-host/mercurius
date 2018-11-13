# CHANGELOG

<a name="1.0.0-alpha.1"></a>
# [1.0.0-alpha.1](https://github.com/launcher-host/mercurius/releases/tag/1.0.0-alpha.1) (2018-11-13)

This release adds additional extendibility to Mercurius, with the following changes:

- feature: MercuriusUser trait added with scopeContacts() to filter users
- feature: custom models defined in config
- feature: custom user fields defined in config
- feature: (optional) the User name can result by merging multiple fields, e.g.: using `first_name` and `last_name`
- refactor: Eloquent models moved to root folder
- refactor: decouple ScriptVariables and refactor in general


<a name="1.0.0-alpha"></a>
# [1.0.0-alpha](https://github.com/launcher-host/mercurius/releases/tag/1.0.0-alpha) (2018-11-12)

- docs: general changes add notes on updating Mercurius
- chore: MigrationsHandler publish timestamped migrations
- feature: Users Slugs logic ([#22](https://github.com/launcher-host/mercurius/issues/22))
- feature: Messages Delivery Status to inform when messages are seen ([#27](https://github.com/launcher-host/mercurius/issues/27))

![mercurius_feature_message_delivery_status_2018-11-09](https://user-images.githubusercontent.com/34574/48246723-7171c780-e3e8-11e8-8355-6af23d425d64.gif)


### Update instructions
Publish changes and run migration
```php
php artisan vendor:publish --tag="mercurius-lang" --force
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


# [0.0.10](https://github.com/launcher-host/mercurius/releases/tag/0.0.10) (2018-11-04)
- Fix Chrome error, Promise was not loading.
- Fix replace sizeof() to count() on event UserStatusChanged.

# [0.0.9](https://github.com/launcher-host/mercurius/releases/tag/0.0.9) (2018-11-04)
- Feature #12 Broadcast User Status.
- Added Events:
    * UserGoesActive
    * UserGoesInactive
    * UserStatusChanged
- Fix ConversationRepository->recipients() to return a Collection.
- Updated documentation.

![mercurius_feature_broadcast_user_status_2018-11-04](https://user-images.githubusercontent.com/34574/47960355-1576ff80-dff2-11e8-8e33-43ba6d4a3eab.gif)

# [0.0.8](https://github.com/launcher-host/mercurius/releases/tag/0.0.8) (2018-10-31)
- Updated documentation in general.
- Added make SCSS + JS publishable.
- Added instructions how to customize Mercurius (Views, SCSS, JS).
- Fix style, on mobile, make the delete icon in messages always visible.
- Fix #7 conversations date.
- Fix #9 removing active conversation.


# [0.0.7](https://github.com/launcher-host/mercurius/releases/tag/0.0.7) (2018-10-20)
- Changed Improve receivers controller #6
- Fix MessageModel: add return types #5
- Fix composer: set fixed versions and other configs #4
- Fix MessageRepository: Check user for deletion #3
- Fix some stuff #2


# [0.0.6](https://github.com/launcher-host/mercurius/releases/tag/0.0.6) (2018-10-15)
- Fix scroll to the bottom when sending/receiving a message.


# [0.0.5](https://github.com/launcher-host/mercurius/releases/tag/0.0.5) (2018-10-12)
- Fix when sending/receiving a message, scroll to the bottom.
- Fix ensure use of boolean types in order to support PostgreSQL.
- Changed documentation.


# [0.0.4](https://github.com/launcher-host/mercurius/releases/tag/0.0.4) (2018-10-11)
- Fix SQL query to support PostgreSQL.


# [0.0.3](https://github.com/launcher-host/mercurius/releases/tag/0.0.3) (2018-10-11)
- Fix messages id collision when appending a message, and request more data.


# [0.0.2](https://github.com/launcher-host/mercurius/releases/tag/0.0.2) (2018-10-11)
- Changed documentation.
- Fix messages panel initialScrollY.


# [0.0.1](https://github.com/launcher-host/mercurius/releases/tag/0.0.1) (2018-10-10)
- First Release.
