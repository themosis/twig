# Twig

This package adds the [Twig](https://twig.symfony.com/) template engine support for Themosis.

## Installation

Run the following command from your terminal in order to install the package:

```bash
composer require themosis/twig
```

## Configuration

The package comes with a `twig.php` configuration file. If it's not automatically installed in your application, you can run the following command from your terminal:

```bash
php artisan vendor:publish --provider="Themosis\Twig\TwigServiceProvider"
```

## Usage

This package provides the Twig engine to the View API coming with Laravel. Basically you can now create views using the `.twig` file extension instead of the `.php` or `.blade.php` extensions.

Twig views are located like any other views. All views directories, defined under the `config/view.php` configuration file `paths` property, can store Twig templates.

In order to control the Twig engine, you can modify its configuration under the `config/twig.php` file.

### Create a Twig view

```php
/**
 * From a controller method, return a Twig view:
 * This line is rendering the following view file `resources/views/welcome.twig`.
 */
return view('welcome');

/**
 * You can also render nested Twig views using the "." syntax.
 * This example is rendering the following view file `resources/views/pages/contact.twig`.
 */
return view('pages.contact');
```

### Pass data

Just like any Blade views, you can pass data to a Twig view using the [same parameters](https://laravel.com/docs/views#passing-data-to-views) defined in the Laravel documentation:

```php
/**
 * Passing data using the array parameter of the view function. 
 */
return view('person', [
    'name' => 'Carla'
]);
```

Here is the `person.twig` file in action:

```twig
<div>
    <p>{{ name }}</p>
</div>
```

> You can also use the view [with()](https://laravel.com/docs/views#passing-data-to-views) method to pass data to your Twig template.

### Twig WordPress extension

The package comes with a Twig `WordPressExtension`. Please refer to the [extension file](./src/Extensions/WordPressExtension.php) for details on available functions and filters provided by this extension in your Twig templates.

> Note the use of the `fn` global object that can help you call any PHP functions. For example: `fn.ucfirst('twig')`.

## Notes

In order to learn the Twig template engine syntax, please refer to the official Twig documentation:
- [https://twig.symfony.com/](https://twig.symfony.com/)

## Credits

- [Julien Lambé](https://github.com/jlambe)
- [All Contributors](https://github.com/themosis/twig/contributors)
