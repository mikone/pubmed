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
use SimpleXMLElement;

abstract class Article
{
  /**
   * SimpleXMLElement class will work on
   * @var object
   */
  protected $xml;

  /**
   * PubMed ID
   * @var integer
   */
  protected $pmid;

  /**
   * Constructor, init
   * @param SimpleXMLElement $xml The main xml object to work on
   */
  public function __construct()
  {

  }

  /**
   * Magic Method 
   * @return string return object print_r for debugging
   */
  public function __toString()
  {
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
   * Run all getters on the xml object
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
      'JournalAbbr'  => $this->getJournalAbbr(),
      'Pagination'   => $this->getPagination(),
      'ArticleTitle' => $this->getArticleTitle(),
      'AbstractText' => $this->getAbstractText(),
      'Affiliation'  => $this->getAffiliation(),
      'Authors'      => $this->getAuthors(),
      'Doid'         => $this->getDoid(),
      'Pii'          => $this->getPii()
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
  }
  
  /**
   * @return string
   */
  public function getPubMedId()
  {
    return $this->pmid;
  }

    /**
   * Get link of article on pubmed site
   * @return string
   */
  public function getLink()
  {
    return "https://www.ncbi.nlm.nih.gov/pubmed/".$this->pmid;
  }

  /**
   * @return string
   */
  public function getDoid()
  {
  }

  /**
   * @return string
   */
  public function getPii()
  {
  }

  /**
   * Get the volume from the SimpleXMLElement
   * @return string Journal Volume Number
   */
  public function getVolume()
  {
  }

  /**
   * Get the JournalIssue from the SimpleXMLElement
   * @return string JournalIssue
   */
  public function getIssue()
  {
  }

  /**
   * Get the PubYear from the SimpleXMLElement
   * @return string PubYear
   */
  public function getPubYear()
  {
  }

  /**
   * Get the PubMonth from the SimpleXMLElement
   * @return string PubMonth
   */
  public function getPubMonth()
  {
  }

  /**
   * Get the PubDay from the SimpleXMLElement
   * @return string PubDay
   */
  public function getPubDay()
  {
  }

  /**
   * Get the ISSN from the SimpleXMLElement
   * @return string Journal ISSN
   */
  public function getISSN()
  {
  }

  /**
   * Get the Journal Title from the SimpleXMLElement
   * @return string Journal Title
   */
  public function getJournalTitle()
  {
  }

  /**
   * Get the ISOAbbreviation from the SimpleXMLElement
   * @return string ISOAbbreviation
   */
  public function getJournalAbbr()
  {
  }

  /**
   * Get the Pagination from the SimpleXMLElement
   * @return string Pagination
   */
  public function getPagination()
  {
  }

  /**
   * Get the ArticleTitle from the SimpleXMLElement
   * @return string ArticleTitle
   */
  public function getArticleTitle()
  {
  }

  /**
   * Get the AbstractText from the SimpleXMLElement
   * @return string AbstractText
   */
  public function getAbstractText()
  {
  }

  /**
   * Get the Affiliation from the SimpleXMLElement
   * @return string Affiliation
   */
  public function getAffiliation()
  {
  }
}
