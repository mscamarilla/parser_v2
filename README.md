# parser

Обязательное требование для задания:
- реализация на plain PHP;
- использование composer;
- OOP, SOLID, DRY;
- реализация должна быть размещена в публичном репозитории (bitbucket, github).

Запрещается в задание (если в задание не указано обратное):
- использовать фреймворки и их компоненты;
- использовать чужие библиотеки (даже Guzzle).
Разрешается в задание (если в задание не указано обратное):
- использовать свои библиотеки (при условии подключения их через composer);
- использовать любой удобный способ хранения данных.
***************************************************************************************************

Задание (ориентировочное время выполнения 6-8 часов):

Реализовать CLI приложение-парсер сайта по заданному url со следующим функционалом:
1. Команда parse - запускает парсер, принимает обязательный параметр url (как с протоколом, так и без).
1.1. При переходе по переданному url, приложение должно найти все картинки, расположенные на странице, и сохранить их полные пути и страницу источник.
1.2. На анализируемой странице должны быть найдены все ссылки, ведущие на другие страницы данного домена, для каждой из этих страниц должен быть выполнен пункт 1.1. и 1.2.
1.3. В конце выполнения команда должна выдать ссылку на CSV файл с результатами анализа.
2. Команда report - выводит в консоль результаты анализа для домена, принимает обязательный параметр domain (как с протоколом, так и без).
3. Команда help - выводит список команд с пояснениями.

Дополнительные требования к заданию:
- архитектура должна быть легко расширяема.
Например, если нужно дополнительно сохранять все внешние ссылки или все заголовки на странице (реализовывать это не надо).

Installation:
1. copy files to server
2. run composer install

Usage:
1. curl -X POST localhost --data "report&url=https://bash.im/&limit=4" - shows data from bash.im with fourth level of nesting in console
2. curl -X POST localhost --data "parse&url=https://bash.im/&limit=4" - saves data from bash.im with fourth level of nesting to csv file in root folder
3. curl -X POST localhost --data "help" - shows help

Took 10 hours.
