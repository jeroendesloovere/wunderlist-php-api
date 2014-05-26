# Wunderlist PHP Class

> This Wunderlist PHP Class connects to the Wunderlist API.

## Example

```
// required to load
require_once 'src/Wunderlist.php';

use JeroenDesloovere\Wunderlist\Wunderlist;

// define API
$api = new Wunderlist('$username', 'password');
```
[see all examples](/examples/example.php) or check [the class](/src/Wunderlist.php)

## Based on

This class is based on [PENDOnl/Wunderlist2-PHP-Wrapper](https://github.com/PENDOnl/Wunderlist2-PHP-Wrapper), but has been rewritten from the ground up to match the PSR-2-code-styling.

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