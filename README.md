# Wunderlist PHP Class

> Wunderlist is a to-do-task app with lots of possibilities. Lists can be created with tasks, sub-tasks, reminders, files and notes. Lists, tasks and sub-tasks can be re-arranged. Lists can be shared with other users and tasks can be starred.

This Wunderlist PHP Class connects to the Wunderlist API and has all functions implemented to insert/update/delete lists, tasks, reminders, files, notes, ...

This class is based on [PENDOnl/Wunderlist2-PHP-Wrapper](https://github.com/PENDOnl/Wunderlist2-PHP-Wrapper), but I've **rewritten it from the ground up** to match the latest PHP PSR-code-stylings. Works perfectly using Composer.

## Usage

### Installation

``` json
{
    "require": {
        "jeroendesloovere/wunderlist-php-api": "dev-master"
    }
}
```

> Adding this code in your `composer.json` file will get the latest version using [Composer](https://getcomposer.org) and [Packagist](https://packagist.org/packages/jeroendesloovere/wunderlist-php-api).

### Example
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

> Check [the Wunderlist class source](/src/Wunderlist.php) or [View all examples](/examples/example.php).

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