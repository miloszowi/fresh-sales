<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Api;

use Miloszowi\FreshSales\Api\Data\ProfileInterface;

interface ClientInterface
{
    /**
     * @param ProfileInterface $profile
     * @param array $data
     * @return array|null
     */
    public function sendApiCall(ProfileInterface $profile, array $data): ?array;
}
