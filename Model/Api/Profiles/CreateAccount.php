<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Model\Api\Profiles;

use Magento\Framework\Webapi\Request;
use Miloszowi\FreshSales\Api\Data\ProfileInterface;

class CreateAccount implements ProfileInterface
{
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
        return '/api/sales_accounts';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return Request::METHOD_POST;
    }
}
