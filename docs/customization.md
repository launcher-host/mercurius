<p align="center">
    <a href="https://www.github.com/launcher-host/mercurius/">
        <img width="450px" src="logo-mercurius.png" title="mercurius logo">
    </a>
</p>

## Customization
You can change several parts of Mercurius, like any other Laravel package.

<br>

#### Publish Views
```bash
php artisan vendor:publish --tag=mercurius-views
```
Views are published at `/resources/views/vendor/mercurius/`.

<br>

#### Styles (SASS)
##### 1. Publish `.scss` files:
```bash
php artisan vendor:publish --tag=mercurius-sass
```
Will publish `.scss` files at `/resources/sass/vendor/mercurius/`.

##### 2. WebPack config
Open the `webpack.mix.js` and place the following:

```javascript
mix.sass('resources/sass/vendor/mercurius/mercurius.scss', 'public/vendor/mercurius/css/mercurius.css')
   .options({processCssUrls: false});
```

<br>

#### JavaScript
##### 1. Publish `.js` and `.vue` files:
```bash
php artisan vendor:publish --tag=mercurius-js
```
Will publish `JS` files at `/resources/js/vendor/mercurius/`.

##### 2. WebPack config
Open `webpack.mix.js` and place the following:

```javascript
mix.js('resources/js/vendor/mercurius/bootstrap.js', 'public/vendor/mercurius/js/mercurius.js');
```

##### 3. Add node packages

Open `package.json` file and make sure you're using the listed packages:
```javascript
    "devDependencies": {
        "axios": "^0.18",
        "babel-core": "^6.26.0",
        "babel-loader": "^7.1.2",
        "babel-polyfill": "^6.26.0",
        "babel-preset-env": "^1.6.1",
        "bootstrap": "^4.1.3",
        "bootstrap-vue": "^2.0.0-rc.11",
        "cross-env": "^5.1",
        "jquery": "^3.2",
        "laravel-echo": "^1.4.0",
        "laravel-mix": "^2.0",
        "lodash": "^4.17.5",
        "moment": "^2.19.4",
        "popper.js": "^1.12",
        "promise": "^7.1.1",
        "pusher-js": "^4.3.1",
        "sass-loader": "^6.0.6",
        "sweetalert": "^2.1.0",
        "underscore": "^1.8.3",
        "urijs": "^1.19.1",
        "vue": "^2.5.13",
        "vue-axios": "^2.0.2",
        "vuescroll": "^4.8.12",
        "webpack": "3"
    }
```

##### 4. Install node modules, by typing:
```javascript
yarn install
```


<br>


### Assets Management
For building assets for `development` and `production`, type one of the commands, respectively:
```javascript
npm run dev
npm run prod
```


<br>


### Note on WebPack config
If you are changing both `SASS` and `JS` files, the `webpack.mix.js` file should look like this:
```javascript
mix.js('resources/js/mercurius/bootstrap.js', 'public/vendor/mercurius/js/mercurius.js')
   .sass('resources/sass/mercurius/mercurius.scss', 'public/vendor/mercurius/css/mercurius.css')
   .options({processCssUrls: false});
```

<br>

## Copyright and license
Copyright 2018 [Bruno Torrinha](https://torrinha.com). Mercurius is released under the [MIT License](LICENSE.md).
