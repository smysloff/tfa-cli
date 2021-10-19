# Term Frequency Analyzer (CLI версия)
Консольная программа для анализа частотности слов, использованных в текстах на сайтах.
<p align="center"><img src="https://raw.githubusercontent.com/smysloff/tfa-cli/master/files/readme.gif" width="840"></p>
<p align="center"><img src="https://raw.githubusercontent.com/smysloff/tfa-cli/master/files/readme.png" width="840"></p>


## Требования
- [PHP 8.0](https://www.php.net/downloads)
- [php-curl](https://www.php.net/manual/en/curl.installation.php)
- [php-mbstring](https://www.php.net/manual/en/mbstring.installation.php)


## Установка
Для работы программы требуется наличие языковых библиотек. Поэтому процесс установки можно разделить на два этапа:

### 1) Установка самой программы
- #### При помощи GIT
```bash
git clone git@github.com:smysloff/tfc-cli.git
```
- #### Или в ручную
Скачайте [zip-архив](https://github.com/smysloff/tfc-cli/archive/refs/heads/master.zip) и распакуйте в удобную для вас папку.

### 2) Установка языковых библиотек
Программа работает с русскими и английскими словарями, получить которые можно двумя способами:
- #### Скомпилировать из исходников с [официального сайта](https://github.com/sokirko74/aot)
- #### Скачать уже скомпилированные файлы со [стороннего сервера](https://disk.yandex.ru/d/gZBIUQyhNjYrag)
Разместить бинарные файлы словарей необходимо в директории: ```src/Libs/phpmorphy/dicts/```


## Использование
Для запуска программы необходимо открыть терминал в корне проекта и запустить при помощи PHP-интерпретатора файл ```tfa.php```,
передав в качестве аргумента командной строки адрес сайта или название файла со списком адресов. 

### Примеры

Передать на вход URL:
```bash
php tfa.php example.com
```

Передать на вход файл со списком URL
```bash
php tfa.php in/urls.txt
```

Если на вход передан URL, то можно указать в какой файл должен выводиться отчет
```bash
php tfa.php -i example.com -o test-out/output.csv
```

Если на вход передан файл, то можно передать и директорию для выходных данных,
в этом случае отчет по каждой странице будет сохранен в отдельном файле
```bash
php tfa.php in/urls.txt -o test-out
```

Для справки по работе программы, нужно передать аргумент `-h`
```bash
php tfa.php -h
```

## Лицензия
[GNU General Public License v3.0](https://github.com/smysloff/tfc-cli/blob/master/LICENSE)
