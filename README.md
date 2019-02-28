# PHP auto indexer: the tool against directory traversal security vulnerability
**Recursively adds a `index.php` file in all given directories.**

**The tool home page and the support page: [prestashop.modulez.ru][5].**
The full description, how to use and the stable release for download are available there.

## Usage

### Run from a console
```
php index.php (--add or --remove) (The directory path for recursively adding or removing the index.php) [The template path for adding the index.php file]
```

Example #1: adding new `index.php` files without overwrite existing one.  
```
php index.php --add ../../.. ./templates/redirect-to-previous-directory.php
```
Example #2: cleaning a directory of old index.php files.
```
php index.php --remove ../../..
```

## Available templates for index.php
These are templates for popular methods to prevent directory traversal:
- The template `error-404.php` is used to show *error 404 - a page not found*.
- The template `redirect-to-previous-directory.php` is used to do the redirect to a previous directory.

## Installation
**Just download the archive and use the tool by described instruction. See homepage for the last stable release.**

You can also use this tool in your project by adding the dependency directly to your `composer.json` file:
```
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/zapalm/autoIndexer"
  }
],
"require": {
  "php": ">=5.2",
  "zapalm/autoIndexer": "dev-master"
},
```


## How to help the project grow and get updates
* **Become the [patron][2]** or support me by **[Flattr][3]** to help me work more for supporting and improving this project.
* Report an issue.
* Give me feedback or contact with me.
* Give the star to the project.
* Contribute to the code.

## Contributing to the code

### Requirements for code contributors 

Contributors **must** follow the following rules:

* **Make your Pull Request on the *dev* branch**, NOT the *master* branch.
* Do not update a version number.
* Follow [PSR coding standards][1].

### Process in details for code contributors

Contributors wishing to edit the project's files should follow the following process:

1. Create your GitHub account, if you do not have one already.
2. Fork the project to your GitHub account.
3. Clone your fork to your local machine.
4. Create a branch in your local clone of the project for your changes.
5. Change the files in your branch. Be sure to follow [the coding standards][1].
6. Push your changed branch to your fork in your GitHub account.
7. Create a pull request for your changes **on the *dev* branch** of the project.
   If you need help to make a pull request, read the [Github help page about creating pull requests][4].
8. Wait for the maintainer to apply your changes.

**Do not hesitate to create a pull request if even it's hard for you to apply the coding standards.**

[1]: https://www.php-fig.org/psr/
[2]: https://www.patreon.com/zapalm
[3]: https://flattr.com/@zapalm
[4]: https://help.github.com/articles/about-pull-requests/
[5]: https://prestashop.modulez.ru/en/tools-scripts/78-php-auto-indexer.html