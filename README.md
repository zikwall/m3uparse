# Parser Playlists

## Installation PHP Packgist

`composer require zikwall/m3uparse`

#### Develop mode

```json
{
    "minimum-stability": "dev",
    "repositories": [
      {
    	  "type": "git",
    	  "url": "https://github.com/zikwall/m3uparse.git",
      }
    ],
    "require": {
    	"zikwall/m3uparse": "dev-develop"
    }
}
```

#### How to use?

```php
<?php

require_once './vendor/autoload.php';

require_once 'vendor/autoload.php';

use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\Configure;
use zikwall\m3uparse\parsers\{
    Free,
    FreeBestTv
};

$agg = new Aggregation(new Configure(__DIR__));

print_r(
    $agg->merge(new Free(), new FreeBestTv())
);
```