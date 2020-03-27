# Pubmed API for Laravel 6/7
-------
[![Latest Stable Version](https://poser.pugx.org/mikone/pubmed/v/stable)](https://packagist.org/packages/mikone/pubmed) [![Total Downloads](https://poser.pugx.org/mikone/pubmed/downloads)](https://packagist.org/packages/mikone/pubmed) [![Latest Unstable Version](https://poser.pugx.org/mikone/pubmed/v/unstable)](https://packagist.org/packages/mikone/pubmed) [![License](https://poser.pugx.org/mikone/pubmed/license)](https://packagist.org/packages/mikone/pubmed) 

##### DEMO: https://pubmed-api.herokuapp.com/

This library allows you to access the research of scientific articles published on Pubmed.
It does this in a completely transparent way, normalizing the use of the different APIs and the response objects to the Pubmed APIs

See Pubmed API Documentation for [PubmedAPI](https://www.ncbi.nlm.nih.gov/books/NBK25499/#chapter4.ESearch)

## Requirements

- php >= 5.3
- [guzzlehttp/guzzle >= 6.0](http://docs.guzzlephp.org/en/stable/overview.html)
- [laravel >= 6.x](https://laravel.com/docs/7.x)

# Installation
```
composer require mikone/pubmed
```
# Usage

Search by Term and return how many articles there are, and their PMIDs
```php
$api = new PubMed\Term();
$api->setReturnStart(10); // set first returned articles, defaults to 0, helpful in case of pagination
$api->setReturnMax(100); // set max returned articles, defaults to 10
$articles = $api->query('CFTR');
print_r($articles);
```
Search by Term with options array
```php
$api = new PubMed\Term();
$api->setReturnStart(10); // set first returned articles, defaults to 0, helpful in case of pagination
$api->setReturnMax(100); // set max returned articles, defaults to 10
$articles = $api_->query('CFTR', $params);
print_r($articles);
```
Search Arcticle by PMID
```php
$api = new PubMed\PubMedId();
$article = $api->query(15221447);
print_r($article);
```
### Options array

The option array is an associative array

| Option name | value | Description |
| ------ | ------ | ------ |
| articles | true / false / null | if true return the articles in search |
| summary | true / false / null |  if true return only the summary of articles |
| page | number / null | if is set return paginated results |

Example:
```
options['articles'] = true;

or 

$params = {'articles' => true, 'summary' => 'true', 'page' => 2};
```
## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits
The library has been forked by that of [tmpjr/pubmed] to allow the various types of bees that pubmed provides, to be performed in a completely transparent way.


## License
The MIT License (MIT). Please see [License File](https://github.com/spatie/laravel-permission/blob/master/LICENSE.md) for more information.


[tmpjr/pubmed]: <https://github.com/joemccann/dillinger>

