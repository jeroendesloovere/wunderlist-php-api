# Wunderlist PHP Class
[![Latest Stable Version](http://img.shields.io/packagist/v/jeroendesloovere/wunderlist-php-api.svg)](https://packagist.org/packages/jeroendesloovere/wunderlist-php-api)
[![License](http://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/jeroendesloovere/wunderlist-php-api/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/jeroendesloovere/wunderlist-php-api.svg?branch=master)](https://travis-ci.org/jeroendesloovere/wunderlist-php-api)

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

> Add the above in your `composer.json` file when using [Composer](https://getcomposer.org).

### Example
``` php
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

> [View all examples](/examples/example.php) or check [the Wunderlist class](/src/Wunderlist.php).

## Documentation

The class is well documented inline. If you use a decent IDE you'll see that each method is documented with PHPDoc.

## Contributing

Contributions are **welcome** and will be fully **credited**.

### Pull Requests

> To add or update code

- **Coding Syntax** - Please keep the code syntax consistent with the rest of the package.
- **Add unit tests!** - Your patch won't be accepted if it doesn't have tests.
- **Document any change in behavior** - Make sure the README and any other relevant documentation are kept up-to-date.
- **Consider our release cycle** - We try to follow [semver](http://semver.org/). Randomly breaking public APIs is not an option.
- **Create topic branches** - Don't ask us to pull from your master branch.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.

### Issues

> For bug reporting or code discussions.

More info on how to work with GitHub on help.github.com.

## Credits

- [Jeroen Desloovere](https://github.com/jeroendesloovere)
- [All Contributors](https://github.com/jeroendesloovere/wunderlist-php-api/contributors)

## License

The module is licensed under [MIT](./LICENSE.md). In short, this license allows you to do everything as long as the copyright statement stays present.