<?php

namespace Silktide\SemRushApi;

use GuzzleHttp\RequestOptions;
use Silktide\SemRushApi\Cache\CacheInterface;
use Silktide\SemRushApi\Data\Type;
use Silktide\SemRushApi\Helper\ResponseParser;
use Silktide\SemRushApi\Helper\UrlBuilder;
use Silktide\SemRushApi\Model\Factory\RequestFactory;
use Silktide\SemRushApi\Model\Factory\ResultFactory;
use Silktide\SemRushApi\Model\Request;
use Silktide\SemRushApi\Model\Result as ApiResult;
use GuzzleHttp\Client as GuzzleClient;

class Client
{

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ResponseParser
     */
    protected $responseParser;

    /**
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @var GuzzleClient
     */
    protected $guzzle;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var int
     */
    protected $connectTimeout = 15;

    /**
     * @var
     */
    protected $timeout = 15;


    /**
     * Construct a client with API key
     *
     * @param string $apiKey
     * @param RequestFactory $requestFactory
     * @param ResultFactory $resultFactory
     * @param ResponseParser $responseParser
     * @param UrlBuilder $urlBuilder
     * @param GuzzleClient $guzzle
     */
    public function __construct($apiKey, RequestFactory $requestFactory, ResultFactory $resultFactory, ResponseParser $responseParser, UrlBuilder $urlBuilder, GuzzleClient $guzzle)
    {
        $this->apiKey = $apiKey;
        $this->requestFactory = $requestFactory;
        $this->resultFactory = $resultFactory;
        $this->responseParser = $responseParser;
        $this->urlBuilder = $urlBuilder;
        $this->guzzle = $guzzle;
    }

    /**
     * @return int
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * @param int $connectTimeout
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }


    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getDomainRanks($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_DOMAIN_RANKS, ['domain' => $domain] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getDomainRank($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_DOMAIN_RANK, ['domain' => $domain] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getDomainOrganic($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_DOMAIN_ORGANIC, ['domain' => $domain] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getDomainAdwords($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_DOMAIN_ADWORDS, ['domain' => $domain] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getDomainAdwordsUnique($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_DOMAIN_ADWORDS_UNIQUE, ['domain' => $domain] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getDomainRankHistory($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_DOMAIN_RANK_HISTORY, ['domain' => $domain] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getPhraseThis($keyword, $options = [])
    {
        return $this->makeRequest(Type::TYPE_KEYWORD_OVERVIEW, ['phrase' => $keyword] + $options);
    }

    /**
     * @param string $domain
     * @param array $options
     * @return ApiResult
     */
    public function getBacklinksOverview($domain, $options = [])
    {
        return $this->makeRequest(Type::TYPE_BACKLINKS_OVERVIEW, ['target' => $domain] + $options);
    }

    /**
     * Make the request
     *
     * @param string $type
     * @param array $options
     * @return ApiResult
     */
    protected function makeRequest($type, $options)
    {
        $request = $this->requestFactory->create($type, ['key' => $this->apiKey] + $options);

        // Attempt load from cache
        if (isset($this->cache)) {
            $result = $this->cache->fetch($request);
        }

        // Make request if not in cache
        if (!isset($result)) {
            $rawResponse = $this->makeHttpRequest($request);
            $formattedResponse = $this->responseParser->parseResult($request, $rawResponse);
            $result = $this->resultFactory->create($formattedResponse);
        }

        // Save to cache
        if (isset($this->cache)) {
            $this->cache->cache($request, $result);
        }

        return $result;
    }

    /**
     * Use guzzle to make request to API
     *
     * @param Request $request
     * @return string
     */
    protected function makeHttpRequest($request)
    {
        $url = $this->urlBuilder->build($request);
        $guzzleResponse = $this->guzzle->request('GET', $url, [
            RequestOptions::CONNECT_TIMEOUT => $this->connectTimeout,
            RequestOptions::TIMEOUT => $this->timeout
        ]);
        return $guzzleResponse->getBody();
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

} 