# Парсер плейлистов | Playlists Parser

Данная библиотека - это сканер открытых плейлистов для создания едной базы плейлистов. Он собирает все в одну кучу, фильтрует и сортирует.

### Источники

- [x] [Forever (Common playlist)](https://webhalpme.ru/iptv-forever-samoobnovljaemyj-plejlist/)
- [x] [vasiliy78L/myIPTV](https://github.com/vasiliy78L/myIPTV)
- [x] [Бесплатный обновляемый плейлист от Great Crabs IPTV](https://4pda.ru/forum/index.php?showtopic=394145&st=4140#entry70709596)
- [x] [Free Best TV](http://4pda.ru/pages/go/?u=http%3A%2F%2Ftopplay.do.am%2FFreeBestTV.m3u&e=84875135)
- [ ] [Огромный сборник по всему миру iptv-org/iptv](https://github.com/iptv-org/iptv)

Вы сами можете определить свой парсер.

### Roadmap

- [x] Auto directory generator & downloader
- [x] Common Aggregation Interface
    - [x] Autolink local parser channels with grouping
    - [ ] Filter available channels in target playlist
    - [x] Default parsers
    - [ ] Link to EPG services
    - [ ] Parser return Object Interface instead of array
    - [ ] Categories
    - [x] Extra Options (for apps):
        - [x] Use origin stream
        - [x] Image
        - [x] Use or not
        - [ ] Blocked
        - [ ] WebView URL
- [ ] Common EPG Aggregation Interface
- [ ] [Go3uparse](https://github.com/zikwall/go3uparse)

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

### How to use?

```php
<?php

require_once './vendor/autoload.php';

use zikwall\m3uparse\Aggregation;

// u can use default playlist sources
use zikwall\m3uparse\parsers\{
    free\Free,
    freebesttv\FreeBestTv,
    vasiliy78L\Base
};

$agg = new Aggregation(new \zikwall\m3uparse\Configuration());

// порядок имеет значение!
// первые более приоритетнее чем последующие
print_r(
    $agg->merge(new Base(), new Free(), new FreeBestTv())
);

```

### Configuration

По умолчанию плейлисты скачиваются и сканируются из директории: RootDirectory + UploadFolder + PlaylistsFolder.

**Например:**

1. RootDirectory = `/public`
2. UploadFolder = `/uploads` (default)
3. PlaylistsFolder = `/playlists` (default)

**Вывод:** `/public/uploads/playlists`

##### Set root directory

```php
<?php

// set current dir is a root
$agg = new Aggregation(new \zikwall\m3uparse\Configuration(__DIR__));

```

### Add custom Parsers

Каждый парсер должен следовать интерфейсу `IParse`

```php
<?php

interface IParse
{
    public function parse(Aggregation $aggregation);
    public function channels();
}

```

В методе `IParse::parse()` Вы можете реализовать любую логику парсинга, примеры можете посмотреть в парсерах по умолчанию.
Но любой парсер должен возвращать структуру типа:

```php

[
    ...
    [
       'name' => 'Channel Name',
       'url'  => 'Channel url to m3u',
       'from' => 'From playlist' // optional
    ]
    ...
]

```

У парсера может быть файл со списком каналов, которые нужно инициализировать, реализует данный функционал метод `IParse::channels()`.
Он должен возвращать массив, формата: Название канала -> Его ЕПГ идентификатор

```php
[
  "Odessa Int2." => 7,
  "Синергия ТВ2" => 286
]
```

Данный список добавляется к каналу из общего списка, как возможное наименование канала.
