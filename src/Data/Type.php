<?php

namespace Silktide\SemRushApi\Data;

abstract class Type
{

    use ConstantTrait;

    const TYPE_DOMAIN_RANKS = "domain_ranks";
    const TYPE_DOMAIN_RANK = "domain_rank";
    const TYPE_DOMAIN_RANK_HISTORY = "domain_rank_history";
    const TYPE_DOMAIN_ORGANIC = "domain_organic";
    const TYPE_DOMAIN_ADWORDS = "domain_adwords";
    const TYPE_DOMAIN_ADWORDS_UNIQUE = "domain_adwords_unique";
    const TYPE_KEYWORD_OVERVIEW = 'phrase_this';
    const TYPE_BACKLINKS_OVERVIEW = "backlinks_overview";
    const TYPE_PHRASE_ORGANIC = "phrase_organic";
    const TYPE_PHRASE_ADWORDS = "phrase_adwords";
    const TYPE_URL_ADWORDS = "url_adwords";

    /**
     * Get all the possible columns
     *
     * @return string[]
     */
    public static function getTypes()
    {
        return self::getConstants();
    }
} 