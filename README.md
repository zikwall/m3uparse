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

use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\Channels;

use zikwall\m3uparse\parsers\{
    Free,
    FreeBestTv
};

$agg = new Aggregation();

print_r(
    $agg->merge(Channels::merge(Channels::get('free'), Channels::get('free_best_tv')), new Free(), new FreeBestTv())
);
```

### Minimal Description

- /channels - Тут находятся списки каналов, которые нужно добавить
    1. normilize.json - главный файл, для формирования плейлиста
- /epgs - Тут находятся EPG 
- /plists
    1. /uploads - Тут находятся загруженные плейлисты
