# Term Frequency Analyzer (CLI-версия)

### [ReadMe на русском языке](#Russian)


It is a terminal application to analyse words' frequency which are used in texts on websites.
It is possible to download a page or several pages, if they are recorded in a text file.
The result of the analysis can be found in terminal or in csv file which depends on given set of preconditions.

<p align="center"><img src="https://raw.githubusercontent.com/smysloff/tfa-cli/master/files/readme.gif" width="840"></p>
<p align="center"><img src="https://raw.githubusercontent.com/smysloff/tfa-cli/master/files/readme.png" width="840"></p>


## Requirements
- [PHP 8.0](https://www.php.net/downloads)
- [php-curl](https://www.php.net/manual/en/curl.installation.php)
- [php-mbstring](https://www.php.net/manual/en/mbstring.installation.php)


## Programme installation
Programme needs language libraries, thus there are two steps in the installation process:

### 1) Programme installation
- #### using GIT
```bash
git clone git@github.com:smysloff/tfc-cli.git
```
- #### manually
Download [zip-archive](https://github.com/smysloff/tfc-cli/archive/refs/heads/master.zip), then extract files in a preferable folder.

### 2) Language libraries installation
It is possible to use Russian and English dictionaries which can be installed in two ways:
- #### Compile files using source code on [official website](https://github.com/sokirko74/aot)
- #### Download already compiled files from [third-party server](https://disk.yandex.ru/d/gZBIUQyhNjYrag)
It is obligatory to place binary files of dictionaries in the folder: ```src/Libs/phpmorphy/dicts/```


## Usage
Open the terminal in the project's root and launch the programme using file ```tfa.php``` and PHP-interpritator.
Do not forget to provide an argument - address of the website or the file name where the list of websites' addresses put.

### Examples

an address of the website as an argument:
```bash
php tfa.php example.com
```

a file with the list of websites' addresses as an argument:
```bash
php tfa.php in/urls.txt
```

If URL is provided as an argument, it is possible to specify the file where the result of analysis will be presented:
```bash
php tfa.php -i example.com -o test-out/output.csv
```

If file name is provided as an argument, it is possible to specify the folder where the result of analysis will be presented, 
in this case there will be a report for every website listed in the file:
```bash
php tfa.php in/urls.txt -o test-out
```

Use an argument `-h` to get information about programme's work 
```bash
php tfa.php -h
```

## Liсense
[GNU General Public License v3.0](https://github.com/smysloff/tfc-cli/blob/master/LICENSE)


# <a name="Russian"></a> Term Frequency Analyzer (CLI-версия):
Консольная программа для анализа частотности слов, использованных в текстах на сайтах.
Для анализа можно передавать как одну страницу, так и список страниц, записанных в текстовый файл.
Результат анализа выводится либо в терминал, либо в csv-файл, в зависимости от заданных условий.

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
Для запуска программы следует открыть терминал в корне проекта и запустить при помощи PHP-интерпретатора файл ```tfa.php```,
передав в качестве аргумента адрес страницы сайта или название файла со списком адресов. 

### Примеры

Передать на вход URL:
```bash
php tfa.php example.com
```

Передать на вход файл со списком URL
```bash
php tfa.php in/urls.txt
```

Если в качестве входного параметра указан URL, то можно указать в какой файл должен выводиться результат анализа
```bash
php tfa.php -i example.com -o test-out/output.csv
```

Если в качестве входного параметра указан файл, то можно указать директорию для выходных данных,
в этом случае отчет по каждой странице будет сохранен в отдельном файле
```bash
php tfa.php in/urls.txt -o test-out
```

Для справки по работе программы, нужно указать аргумент `-h`
```bash
php tfa.php -h
```

## Лицензия
[GNU General Public License v3.0](https://github.com/smysloff/tfc-cli/blob/master/LICENSE)
