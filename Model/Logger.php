<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Model;

use Magento\Framework\Logger\Monolog;
use Magento\Framework\Serialize\SerializerInterface;
use Miloszowi\FreshSales\Helper\Data;

class Logger
{
    /**
     * @var Monolog
     */
    private $logger;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Data
     */
    private $config;

    /**
     * Logger constructor.
     *
     * @param Monolog $logger
     * @param SerializerInterface $serializer
     * @param Data $config
     */
    public function __construct(
        Monolog $logger,
        SerializerInterface $serializer,
        Data $config
    ) {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->config = $config;
    }

    /**
     * @param string $url
     * @param string $httpMethod
     * @param array $httpHeaders
     * @param array $data
     */
    public function logRequest(
        string $url,
        string $httpMethod,
        array $httpHeaders,
        array $data
    ): void {
        if (!$this->config->isLoggingEnabled()) {
            return;
        }

        $request = [
            'type' => 'Request to Freshsales',
            'url' => $url,
            'httpMethod' => $httpMethod,
            'headers' => $httpHeaders,
            'body' => $data
        ];

        $this->logger->addInfo($this->serializer->serialize($request));
    }

    /**
     * @param int $statusCode
     * @param string $body
     */
    public function logResponse(int $statusCode, string $body): void
    {
        if (!$this->config->isLoggingEnabled()) {
            return;
        }

        $response = [
            'statusCode' => $statusCode,
            'response' => $body
        ];

        $this->logger->addInfo($this->serializer->serialize($response));
    }

    /**
     * @param string $message
     */
    public function logError(string $message): void
    {
        $this->logger->addError($message);
    }
}
