# Yii2 - Background Translation I18n

[![Open Source Love](https://badges.frapsoft.com/os/v3/open-source.svg?v=103)](https://github.com/weikaiiii/background-translation-i18n)[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)[![GitHub stars](https://img.shields.io/github/stars/Kay-Wei/background-translation-i18n.svg?style=social&label=Star&maxAge=2592000)](https://github.com/weikaiiii/background-translation-i18n)[![saythanks](https://img.shields.io/badge/say-thanks-ff69b4.svg)](https://saythanks.io/to/kennethreitz)


:alien: Based on the YII2 module to translate JSON formatted translation files on the web

## Introduction:sweat_drops:

This project is suitable for client-side international translation. It supports importing JSON files to web pages, and operation and maintenance or translators export the translated JSON files after translation on the web

## Installation:green_heart:

Via [Composer](http://getcomposer.org/download/)

```
composer require weikaiiii/background-translation-i18n
```

### Migration:purple_heart:

Run the following command in Terminal for database migration:

```
yii migrate/up --migrationPath=@vendor/weikaiiii/background-translation-i18n/migrations
```

### Config:heartbeat:

Turning on the translate Module:

Simple example:

```
'modules' => [
    'translate' => [
        'class'=>'weikaiiii\backgroundTranslationI18n\Module'
    ],
],
```

A more complex example including database table with multilingual support is below:

```
    'modules' => [
        'translate'=>[
            'class'=>'weikaiiii\backgroundTranslationI18n\Module',
            'allowedIPs'=>['127.0.0.1'], // IP addresses from which the translation interface is accessible.
            'source_lang'=>'en-US', //Translate according to source language encoding.

        ]
    ],
```



## Usage:no_mouth:
### Point
Every time a JSON file is uploaded, it will be judged based on the existing data and will not cause data duplication.

### Json File Format Example
```
{
   "library":{
      "hello":"Hello from library"
   },
   "documents":{
      "hello":"Hello from documents"
   }
}
```
### URLs

URLs for the translating tool:

```
/translate/translate-json/export         // Export the translated JSON file.
/translate/translate-json/index?language_id={xx-XX}      // Translate specific language pages.
/translate/translate-json/list         // Language code list page.
/translate/translate-json/create    // Import JSON source language files.
```



## Screenshots:chicken:

### List of languages

![1599540101194](https://s1.ax1x.com/2020/09/08/wMc1hD.md.png)

### Translate on the admin interface

![1599540236622](https://s1.ax1x.com/2020/09/08/wMcNnI.md.png)

## Statement:love_letter:

The project view part and language list part are borrowed from the "lajax/yii2-translate-manager" project. Thanks lajax for the great work.

- YII2 Translate Manager : https://github.com/lajax/yii2-translate-manager

