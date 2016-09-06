<?php

namespace Silktide\SemRushApi\Data;

abstract class Column
{
    use ConstantTrait;

    const COLUMN_OVERVIEW_ADWORDS_BUDGET = "Ac";
    const COLUMN_OVERVIEW_ADWORDS_KEYWORDS = "Ad";
    const COLUMN_OVERVIEW_ADWORDS_TRAFFIC = "At";
    const COLUMN_OVERVIEW_DATABASE = "Db";
    const COLUMN_OVERVIEW_DOMAIN = "Dn";
    const COLUMN_OVERVIEW_ORGANIC_BUDGET = "Oc";
    const COLUMN_OVERVIEW_ORGANIC_KEYWORDS = "Or";
    const COLUMN_OVERVIEW_ORGANIC_TRAFFIC = "Ot";
    const COLUMN_OVERVIEW_SEMRUSH_RATING = "Rk";
    const COLUMN_OVERVIEW_DATE = "Dt";
    const COLUMN_DOMAIN_KEYWORD = "Ph";
    const COLUMN_DOMAIN_KEYWORD_ORGANIC_POSITION = "Po";
    const COLUMN_DOMAIN_KEYWORD_PREVIOUS_ORGANIC_POSITION = "Pp";
    const COLUMN_KEYWORD_AVERAGE_QUERIES = "Nq";
    const COLUMN_KEYWORD_AVERAGE_CLICK_PRICE = "Cp";
    const COLUMN_DOMAIN_KEYWORD_TRAFFIC_PERCENTAGE = "Tr";
    const COLUMN_KEYWORD_ESTIMATED_PRICE = "Tc";
    const COLUMN_KEYWORD_COMPETITIVE_AD_DENSITY = "Co";
    const COLUMN_KEYWORD_ORGANIC_NUMBER_OF_RESULTS = "Nr";
    const COLUMN_KEYWORD_INTEREST = "Td";
    const COLUMN_DOMAIN_KEYWORD_AD_TITLE = "Tt";
    const COLUMN_DOMAIN_KEYWORD_AD_TEXT = "Ds";
    const COLUMN_DOMAIN_KEYWORD_VISIBLE_URL = "Vu";
    const COLUMN_DOMAIN_KEYWORD_TARGET_URL = "Ur";
    const COLUMN_DOMAIN_KEYWORD_NUMBER = "Pc";
    const COLUMN_DOMAIN_KEYWORD_POSITION_DIFFERENCE = "Pd";
    const COLUMN_DOMAIN_ADWORD_POSITION = "Ab";
    const COLUMN_BACKLINKS_DOMAINS = "domains_num";
    const COLUMN_BACKLINKS_TOTAL = 'total';
    const COLUMN_BACKLINKS_FOLLOW = 'follows_num';
    const COLUMN_BACKLINKS_NOFOLLOW = 'nofollows_num';
    const COLUMN_BACKLINKS_IPS = 'ips_num';
    const COLUMN_BACKLINKS_SCORE = 'score';
    const COLUMN_BACKLINKS_TRUST = 'trust_score';

    /**
     * Get all the possible columns
     *
     * @return string[]
     */
    public static function getColumns()
    {
        return self::getConstants();
    }

    /**
     * Check if the given code is a valid column code
     *
     * @param string $code
     * @return bool
     */
    public static function isValidColumn($code)
    {
        return in_array($code, self::getColumns());
    }
} 