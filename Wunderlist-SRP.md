# Wunderlist

src/
    Wunderlist.php


## Wunderlist.php

``` php
<?php

class Wunderlist
{
    protected $lists;
    //protected $tasks;

    public function __construct($apiKey, $apiSecret)
    {
        // define service
        $service = new Service($apiKey, $apiSecret);

        // define classes
        $this->lists = new Lists($service);
        //$this->tasks = new Tasks($service);

        return $this;
    }
}
```

``` php
<?php

class Service
{
    public function __construct($apiKey, $apiSecret)
    {
        
    }
}
```

``` php
<?php

class Base
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
```

``` php
<?php

class Authentication extends Base
{
}

``` php
<?php

class List extends Base
{
    public function delete($listId)
    {
        $this->service->doCall();
    }

    public function insert($title)
    {
        $this->service->doCall();
    }
}
```

## Usage

### Example

``` php
// define wunderlist
$api = new Wunderlist($apiKey, $apiSecret);

// execute functions
$api->lists->delete('list-id');
$api->lists->insert('title');
```