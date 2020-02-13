<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\ViewModel\Adminhtml;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Miloszowi\FreshSales\Model\Api\Profiles\GetAccount;
use Miloszowi\FreshSales\Model\Client;
use Miloszowi\FreshSales\Setup\InstallData as FreshSalesData;

class AccountDetails implements ArgumentInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var GetAccount
     */
    private $profile;

    /**
     * @var Client
     */
    private $client;

    /**
     * AccountDetails constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param GetAccount $profile
     * @param Client $client
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        GetAccount $profile,
        Client $client
    ) {
        $this->customerRepository = $customerRepository;
        $this->profile = $profile;
        $this->client = $client;
    }

    /**
     * @param int $customerId
     * @return array
     */
    public function getAccountDetails(int $customerId): array
    {
        try {
            $customer = $this->customerRepository->getById($customerId);
            $this->profile->setId(
                $customer->getCustomAttribute(FreshSalesData::FRESHSALES_ACCOUNT_ATTRIBUTE)->getValue()
            );
            $response = $this->client->sendApiCall(
                $this->profile,
                []
            );

            return $response['sales_account'] ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
