<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Model\Api\Profiles;

use Magento\Framework\Webapi\Request;
use Miloszowi\FreshSales\Api\Data\ProfileInterface;

class GetAccount implements ProfileInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getUrlSuffix(): string
    {
        return '/api/sales_accounts/' . $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    /**
     * @param string $id
     * @return GetAccount
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
