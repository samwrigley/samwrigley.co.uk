# Personal Website

[![CI](https://github.com/samwrigley/samwrigley.co.uk/workflows/CI/badge.svg?label=tests)](https://github.com/samwrigley/samwrigley.co.uk/actions)
[![StyleCI](https://styleci.io/repos/108089774/shield)](https://styleci.io/repos/108089774)

Hello, I'm Sam Wrigley. I'm a Web-Developer and Graphic Designer.

This is the source for my personal website 👉 [samwrigley.co.uk](https://samwrigley.co.uk).

You can also find me on: 🐦 [Twitter](https://twitter.com/samwrigley) | 📷 [Instagram](https://www.instagram.com/samwrigley) | 💼 [LinkedIn](https://www.linkedin.com/in/samwrigley)

## Installation ⏳

First, clone the repository:

```sh
git clone https://github.com/samwrigley/samwrigley.co.uk.git
cd samwrigley.co.uk
```

Second, install Composer and NPM dependencies:

```sh
composer install
yarn install
```

Next, copy the example environment file and set the application key:

```sh
cp .env.example .env
php artisan key:generate
```

Finally, run the database migrations and seed the database:

```sh
php artisan migrate --seed
```

## Development 🛠

To build the JavaScript and CSS assets use:

```sh
yarn dev
```

To rebuild the JavaScript and CSS assets whenever they change use:

```sh
yarn watch
```

## Testing 🔄

To run the application tests use:

```sh
php artisan test
```
