# Парсер плейлистов

### Особенности

- [x] Хорошие источники и парсеры по умолчанию.
- [x] Гибкая конфигурация: Вы сами решаете какие сохранять, а какаие нет.
- [x] Различные наименования каналов можно группировать и считать как один.
- [ ] Парсер должен возвращать объект Channel.
- [ ] Приоритеты на уровне каналов для различных источников, сейчас приоритеты на уровне плейлиста
- [ ] Парсер ЕПГ.
- [x] Автогенерация директорий из коробочки.
- [ ] Автоматическая проверка валидности плейлиста и каналов в нем.
- [x] Реализация парсера на Golang (нужно актуализировать под новое API)

### Как использовать?

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

### Конфигурация

По умолчанию плейлисты скачиваются и сканируются из директории: RootDirectory + UploadFolder + PlaylistsFolder.

**Например:**

1. RootDirectory = `/public`
2. UploadFolder = `/uploads` (default)
3. PlaylistsFolder = `/playlists` (default)

**Вывод:** `/public/uploads/playlists`

##### Установка корневой директории

```php
<?php

// set current dir is a root
$agg = new Aggregation(new \zikwall\m3uparse\Configuration(__DIR__));

```

### Добавление своих парсеров

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
