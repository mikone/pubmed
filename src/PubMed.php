<?php

/**
 * PHP wrapper for NCBI PubMed
 *   Extend Pubmed for term specific searching
 *
 * @author  Tom Ploskina <tploskinajr@gmail.com>
 * @copyright Copyright (c) 2013 http://tmpjr.me
 * @license MIT http://opensource.org/licenses/MIT
 * @version 1.0
 */

namespace PubMed;

use GuzzleHttp;

abstract class PubMed
{
  /**
   * Guzzle resource handle
   * @var resource
   */
  protected $gclient;

  /**
   * The number of seconds to wait while trying to connect.
   * @var integer
   */
  protected $connectionTimeout = 10;

  /**
   * The maximum number of seconds to allow cURL functions to execute.
   * @var integer
   */
  protected $timeout = 10;

  /**
   * Which database from NCBI to pull from
   * @var string
   */
  protected $db = 'pubmed';

  /**
   * The maximum number of articles to receive
   * @var integer
   */
  protected $returnMax = 10;

  /**
   * Which article to start at
   * @var integer
   */
  protected $returnStart = 0;

  /**
   * NCBI URL, should be set in child class
   * @var string
   */
  protected $url;

  /**
   * NCBI search URI name, should be set in child class
   * @var string
   */
  protected $searchTermName;

  /**
   * Amount of articles found
   * @var integer
   */
  protected $articleCount = 0;

  /**
   * Return mode from NCBI's API
   */
  protected $return_mode = 'xml';

  /**
   *  Initiate the cURL connection
   */
  public function __construct()
  {
    $this->gclient = new GuzzleHttp\Client();
  }

  /**
   * Get the URL, specific to child classes
   * -- do not implement here
   * @return string url
   */
  protected function getUrl() {}

  /**
   * Get the URI variable name, specific to child classes
   * @return string eg, "term"
   */
  protected function getSearchName() {}

  /**
   * Return the article count
   * @return integer number of results
   */
  public function getArticleCount()
  {
    return intval($this->articleCount);
  }

  /**
   * Set the maximum returned articles
   * @param integer $value maximum return articles
   */
  public function setReturnMax($max)
  {
    return $this->returnMax = intval($max);
  }

  /**
   * At which article number to start?
   * @param integer $value The starting article index number
   */
  public function setReturnStart($start)
  {
    return $this->returnStart = intval($start);
  }

   /**
   * Send the request to NCBI, return the raw result,
   * throw \Ambry\Pubmed exception on error
   * @param  string $searchTerm What are we searching for?
   * @return string JSON string
   */
  protected function sendRequest($searchTerm)
  {
    $url  = $this->getUrl();
    $url .= "?db=" . $this->db;
    $url .= "&retmax=" . intval($this->returnMax);
    $url .= "&retmode=" . $this->return_mode;
    $url .= "&retstart=" . intval($this->returnStart);
    $url .= "&" . $this->getSearchName() . "=" . urlencode($searchTerm);

    try {
      $requestSearch = $this->gclient->get($url);
      $rs = $requestSearch->getBody();
    } catch (\GuzzleHttp\Exception\RequestException $e)
    {
      if ($e->hasResponse())
        throw new Exception(GuzzleHttp\Psr7\str($e->getResponse()));
      else
        throw new Exception(GuzzleHttp\Psr7\str($e->getRequest()));
    }

    return $rs;
  }
}
