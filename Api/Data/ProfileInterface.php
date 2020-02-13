<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Api\Data;

interface ProfileInterface
{
    /**
     * Provide an array with headers
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Provide url suffix for an API
     *
     * @return mixed
     */
    public function getUrlSuffix(): string;

    /**
     * Provide http method
     *
     * @return string
     */
    public function getMethod(): string;
}
