<?php

/**
 * PHP wrapper for NCBI PubMed
 *   Extend Pubmed for term specific searching
 *
 * @author  Tom Ploskina <tploskina@ambrygen.com>
 * @copyright Copyright (c) 2013 Ambry Genetics http://www.ambrygen.com
 * @license MIT http://opensource.org/licenses/MIT
 * @version 1.0
 */

namespace PubMed;

class ArticleSummary extends Article
{
  /**
   * json object will work on
   * @var object
   */
  protected $json;

  /**
   * PubMed ID
   * @var integer
   */
  protected $pmid;

  /**
   * Constructor, init
   * @param JSON $json The main json object to work on
   */
  public function __construct($PubmedArticle)
  {
    $this->json = $PubmedArticle;
    $this->pmid = (string) $PubmedArticle['uid'];
  }

  /**
   * Magic Method
   * @return string return object print_r for debugging
   */
  public function __toString()
  {
    return print_r($this->json, true);
  }

  /**
   * Get JSON result of all items
   * @return string JSON encoded string of results
   */
  public function toJson()
  {
    return json_encode($this->toArray());
  }

  /**
   * Run all getters on the json object
   * @return array array of all getters
   */
  protected function toArray()
  {
    return array(
      'PMID'         => $this->getPubMedId(),
      'Volume'       => $this->getVolume(),
      'Issue'        => $this->getIssue(),
      'PubYear'      => $this->getPubYear(),
      'PubMonth'     => $this->getPubMonth(),
      'PubDay'       => $this->getPubDay(),
      'ISSN'         => $this->getISSN(),
      'JournalTitle' => $this->getJournalTitle(),
      'ArticleTitle' => $this->getArticleTitle(),
      'AbstractText' => $this->getAbstractText(),
      'Authors'      => $this->getAuthors(),
      'Doid'         => $this->getDoid(),
      'Pii'          => $this->getPii(),
      'link'         => $this->getLink()
    );
  }

  /**
   * Return array of all results
   * @return array array of results
   */
  public function getResult()
  {
    return $this->toArray();
  }

  /**
   * Loop through authors, return Lastname First Initial
   * @return array The list of authors
   */
  public function getAuthors()
  {
    $authors = "";
    if (isset($this->json['authors'])) {
      foreach ($this->json['authors'] as $author)
          $authors .= ",". $author['name'];

      if (strlen($authors) > 0)
        $authors = substr($authors, 1);
    }

    return $authors;
  }


  /**
   * @return string
   */
  public function getDoid()
  {
    if (isset($this->json['articleids']))
    foreach ($this->json['articleids'] as $articlesID)
      if ($articlesID['idtype'] == 'doi')
        return (string) $articlesID['value'];

      return "";
  }

  /**
   * @return string
   */
  public function getPii()
  {
    if (isset($this->json['articleids']))
    foreach ($this->json['articleids'] as $articlesID)
      if ($articlesID['idtype'] == 'pii')
        return (string) $articlesID['value'];

      return "";
  }

  /**
   * Get the volume from the JSON object
   * @return string Journal Volume Number
   */
  public function getVolume()
  {
    return isset($this->json['volume']) ? (string) $this->json['volume'] : '';
  }

  /**
   * Get the JournalIssue from the JSON object
   * @return string JournalIssue
   */
  public function getIssue()
  {
    return isset($this->json['issue']) ? (string) $this->json['issue'] : '';
  }

  /**
   * Get the PubYear from the JSON object
   * @return string PubYear
   */
  public function getPubYear()
  {
    return isset($this->json['pubdate']) ? substr($this->json['pubdate'], 0, 4) : '';
  }

  /**
   * Get the PubMonth from the JSON object
   * @return string PubMonth
   */
  public function getPubMonth()
  {
    return isset($this->json['pubdate']) ? substr($this->json['pubdate'], 5, 3) : '';
  }

  /**
   * Get the PubDay from the JSON object
   * @return string PubDay
   */
  public function getPubDay()
  {
    return isset($this->json['pubdate']) ? substr($this->json['pubdate'], 9) : '';
  }

  /**
   * Get the ISSN from the JSON object
   * @return string Journal ISSN
   */
  public function getISSN()
  {
    return isset($this->json['issn']) ? (string) $this->json['issn'] : '';
  }

  /**
   * Get the Journal Title from the JSON object
   * @return string Journal Title
   */
  public function getJournalTitle()
  {
    return isset($this->json['jurnaltitle']) ? (string) $this->json['jurnaltitle'] : '';
  }

  /**
   * Get the ArticleTitle from the JSON object
   * @return string ArticleTitle
   */
  public function getArticleTitle()
  {
    return isset($this->json['title']) ? (string) $this->json['title'] : '';
  }

}
