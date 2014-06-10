# Wunderlist PHP Class

> Wunderlist is a to-do-task app with lots of possibilities. Lists can be created with tasks, sub-tasks, reminders, files and notes. Lists, tasks and sub-tasks can be re-arranged. Lists can be shared with other users and tasks can be starred.

This Wunderlist PHP Class connects to the Wunderlist API and has all functions implemented to insert/update/delete lists, tasks, reminders, files, notes, ...

## Based on

This class is based on [PENDOnl/Wunderlist2-PHP-Wrapper](https://github.com/PENDOnl/Wunderlist2-PHP-Wrapper), but has been **rewritten from the ground up** to match the latest PHP PSR-code-stylings. Works perfectly using Composer.

## Installing

### Using Composer

When using [Composer](https://getcomposer.org) you can always load in the latest version.
Add the :package_name package to your `composer.json` file.

``` json
{
    "require": {
        "jeroendesloovere/wunderlist-php-api": "dev-master"
    }
}
```
Check [in Packagist](https://packagist.org/packages/jeroendesloovere/wunderlist-php-api).

### Usage example
```
// required to load (only when not using an autoloader)
require_once __DIR__ . '/src/Wunderlist.php';

// define API
$api = new \JeroenDesloovere\Wunderlist\Wunderlist('username', 'password');

// get profile
$profile = $api->getProfile();

// get lists
$lists = $api->getLists();

// get tasks
$tasks = $api->getTasks();

// ...
```
Check [the Wunderlist class source](/src/Wunderlist.php) or [view all examples](/examples/example.php).

## Documentation

The class is well documented inline. If you use a decent IDE you'll see that each method is documented with PHPDoc.

## Contributing

It would be great if you could help us improve this class. GitHub does a great job in managing collaboration by providing different tools, the only thing you need is a [GitHub](http://github.com) login.

* Use **Pull requests** to add or update code
* **Issues** for bug reporting or code discussions
* Or regarding documentation and how-to's, check out **Wiki**
More info on how to work with GitHub on help.github.com.

## License

The module is licensed under [MIT](./LICENSE.md). In short, this license allows you to do everything as long as the copyright statement stays present.