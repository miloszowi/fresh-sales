<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const XML_PATH_FRESH_SALES_HOSTNAME = 'miloszowi_freshsales_api/general/hostname';
    const XML_PATH_FRESH_SALES_API_KEY = 'miloszowi_freshsales_api/general/api_key';
    const XML_PATH_FRESH_SALES_LOGGING = 'miloszowi_freshsales_api/general/logging';

    /**
     * @return string|null
     */
    public function getHostname(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FRESH_SALES_HOSTNAME);
    }

    /**
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FRESH_SALES_API_KEY);
    }

    /**
     * @return bool
     */
    public function isLoggingEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_FRESH_SALES_LOGGING);
    }
}
