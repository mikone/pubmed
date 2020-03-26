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

class PubMedSummary extends PubMed
{
    /**
     * Return the URL of the single PMID summary
     * @return string URL of NCBI single article summary
     */
    protected function getUrl()
    {
        return 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi';
    }

        /**
     * Return the type of response the single PMID summary
     * @return string retmode of NCBI article summary, eg, "&retmode=json"
     */
    protected $return_mode = 'json';

    /**
     * Specific to Single mode searches
     * @return string parameter passed in the URI, eg, "&id=23234234"
     */
    protected function getSearchName()
    {
        return 'id';
    }

    /**
     * Main function of this class, get the result json, searching
     * by PubMedId (PMID)
     * @param  string $pmids PubMedID, list of id
     * @return object New PubMed\Article
     */
    public function query($pmids)
    {
        $content = $this->sendRequest($pmids);
        $articles = [];

        $responseJSON = json_decode($content, true);
        $responseSummar = $responseJSON['result'];
        foreach($responseSummar['uids'] as $uid)
        {
            $pmdArticle = json_decode((new ArticleSummary($responseSummar[$uid]))->toJson());
            array_push($articles, $pmdArticle);
        }

        return $articles;
    }
}
