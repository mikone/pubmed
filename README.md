### API wrapper library to interface with NCBI's PubMed Efetch Server

Getting started
---------------
```
composer require mikone/pubmed
```
Basic Usage
-----------

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
Get Articles with Paginated Results
```php
$api = new PubMed\Term();
$api->setCurrentSearch($search); // pass the previous search, to be able to calculate the page number directly
articles = $api->queryPage($page);
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
| page | Under development | if is set return paginated results based on the passed search object |
Example:
```
options['articles'] = true;

or 

$params = {'articles' => true, 'summary' => 'true'};
```

## Credits
The library has been forked by that of [tmpjr/pubmed] to allow the various types of bees that pubmed provides, to be performed in a completely transparent way.


## License
The MIT License (MIT). Please see [License File](https://github.com/spatie/laravel-permission/blob/master/LICENSE.md) for more information.


[tmpjr/pubmed]: <https://github.com/joemccann/dillinger>

