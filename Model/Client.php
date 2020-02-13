<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Model;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Webapi\Response;
use Miloszowi\FreshSales\Api\ClientInterface;
use Miloszowi\FreshSales\Api\Data\ProfileInterface;
use Miloszowi\FreshSales\Helper\Data;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    /**
     * @var Data
     */
    private $config;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Monolog
     */
    private $logger;

    /**
     * Client constructor.
     * @param Data $config
     * @param HttpClient $httpClient
     * @param SerializerInterface $serializer
     * @param Logger $logger
     */
    public function __construct(
        Data $config,
        HttpClient $httpClient,
        SerializerInterface $serializer,
        Logger $logger
    ) {
        $this->config = $config;
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function sendApiCall(ProfileInterface $profile, array $data): ?array
    {
        return $this->call(
            $this->prepareUri($profile->getUrlSuffix()),
            $profile->getMethod(),
            $this->prepareHeaders($profile->getHeaders()),
            $data
        );
    }

    /**
     * @param string $url
     * @param string $httpMethod
     * @param array $httpHeaders
     * @param array $requestData
     * @return ResponseInterface|null
     * @throws GuzzleException
     */
    private function call(
        string $url,
        string $httpMethod,
        array $httpHeaders,
        array $requestData
    ): ?array {
        try {
            $this->logger->logRequest($url, $httpMethod, $httpHeaders, $requestData);

            $response = $this->httpClient->request(
                $httpMethod,
                $url,
                [
                    'json' => $requestData,
                    'headers' => $httpHeaders
                ]
            );
            $responseBody = $response->getBody()->getContents();

            $this->logger->logResponse($response->getStatusCode(), $responseBody);

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $this->serializer->unserialize($responseBody);
            }

            return null;
        } catch (\Exception $e) {
            $this->logger->logError('Something went wrong during creating HTTP Request: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * @param string $uri
     * @return string
     */
    private function prepareUri(string $uri): string
    {
        return $this->config->getHostname() . $uri;
    }

    /**
     * Attach profile headers
     *
     * @param array $profileHeaders
     * @return array
     */
    private function prepareHeaders(array $profileHeaders): array
    {
        $headers = ['Content-Type' => 'application/json'];
        $headers['Authorization'] = sprintf('Token token=%s', $this->config->getApiKey());
        $headers = array_merge($headers, $profileHeaders);

        return $headers;
    }
}
