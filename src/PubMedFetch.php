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

class PubMedFetch extends PubMed
{
    /**
     * Return the URL of the single PMID fetch
     * @return string URL of NCBI single article fetch
     */
    protected function getUrl()
    {
        return 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi';
    }

    /**
     * Return the type of response the single PMID fetch
     * @return string retmode of NCBI article fetch, eg, "&retmode=xml"
     */
    protected $return_mode = 'xml';

    /**
     * Specific to Single mode searches
     * @return string parameter passed in the URI, eg, "&id=23234234"
     */
    protected function getSearchName()
    {
        return 'id';
    }

    /**
     * Main function of this class, get the result xml, searching
     * by PubMedId (PMID)
     * @param  string $pmids PubMedID, list of id
     * @return object New PubMed\Article
     */
    public function query($pmids)
    {
        $content = $this->sendRequest($pmids);
        $xml = new SimpleXMLElement($content);
        
        $articles = [];
        foreach ($xml->PubmedArticle as $pubmedArticle)
        {   
            $pmdArticle = json_decode((new ArticleFetch($pubmedArticle))->toJson());
            array_push($articles, $pmdArticle);
        }
        return $articles;
    }
}
