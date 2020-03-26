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

class Term extends PubMed
{

  /**
   * Return the URL of the search URL for searching by term
   * @return string URL of NCBI single article fetch
   */
  protected function getUrl()
  {
    return 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';
  }

  protected $return_mode = 'json';

  /**
   * Specific to term searches
   * @return string parameter passed in the URI, eg, "&term=CFTR"
   */
  protected function getSearchName()
  {
    return 'term';
  }

  /**
   * last research
   */
  protected $_current_search = [];
  public function getCurrentSearch()
  {
    return $this->_current_search;
  }
  public function setCurrentSearch($oldSearch)
  {
    $this->_current_search = $oldSearch;
  }

  public function queryPage($page)
  {
      if (isset($page) && is_numeric($page) && $page > 0)
      {
        $this->returnMax = $this->_current_search['retmax'];
        $this->returnStart = ($this->returnMax * ($page-1))+1 > $this->_current_search['count'] ? 0 : ($this->returnMax * ($page-1))+1;
        $this->query($this->_current_search['term'], (array) $this->_current_search['options']);

        return $this->_current_search;
      }
  }

  /**
   * Get Articles by options
   * @param Array $options
   * 'summary' if you want the summary of articles
   * if $option is empty we fetch all articles with all property including the abstracts
   * @return Array with current search
   */
  public function getArticles($options)
  {
    $articles = [];

    if (isset($this->_current_search['idlist']))
    {
      if (isset($this->_current_search['articles']))
        return $this->_current_search['articles'];

    if (isset($options['summary']) && $options['summary'] == true)
        $api = new PubMedSummary();
      else
        $api = new PubMedFetch();

      $articles = $api->query(implode(",", $this->_current_search['idlist']));

      $this->_current_search['articles'] = $articles;
    }

    return $articles;
  }

  /**
   * Main function of this class, get the result xml
   * @param  string $term What are we searching?
   * @param Array $options
   * 'articles' if you want to get info of articles
   * if $option is empty we only take the ids of the articles
   * @return array array of  New PubMed\Article objects
   */
  public function query($term, $options = array())
  {
    $content = $this->sendRequest($term);
    $responseJSON = json_decode($content, true);

    $pubmedSearch = $responseJSON['esearchresult'];

    $pubmedSearch['term'] = $term;
    $pubmedSearch['retmax'] > 0 ? $pubmedSearch['paging']['num_of_pages'] = (string) ceil($pubmedSearch['count']/$pubmedSearch['retmax']) : $pubmedSearch['paging']['num_of_pages'] = (string) 0;
    $pubmedSearch['retmax'] > 0 ? $pubmedSearch['paging']['current_page'] = (string) (floor($pubmedSearch['retstart']/$pubmedSearch['retmax']) + 1) : $pubmedSearch['paging']['current_page'] = (string) 0;
    $pubmedSearch['paging']['start_from'] = $pubmedSearch['retstart'];
    $pubmedSearch['paging']['results_for_page'] = $pubmedSearch['retmax'];
    $pubmedSearch['paging']['current_page']+1 <= $pubmedSearch['paging']['num_of_pages'] ? $pubmedSearch['paging']['next_page'] = (string) $pubmedSearch['paging']['current_page']+1 : $pubmedSearch['paging']['next_page'] = (string) 0;
    $pubmedSearch['paging']['current_page']-1 < 0 ? $pubmedSearch['paging']['prev_page'] = (string) 0 : $pubmedSearch['paging']['prev_page'] = (string) $pubmedSearch['paging']['current_page']-1;

    $this->_current_search = $pubmedSearch;
    $this->_current_search['options'] = (array) $options;

    if ($pubmedSearch['count'] > 0) {

        if (isset($options['articles']) && $options['articles'] == true)
        $this->getArticles($options);
    } else


    $this->_current_search = $pubmedSearch;
    $this->_current_search['options'] = (array) $options;

    return $this->_current_search;

  }
}
