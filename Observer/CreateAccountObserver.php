<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Miloszowi\FreshSales\Model\Api\Profiles\CreateAccount;
use Miloszowi\FreshSales\Model\Client;
use Miloszowi\FreshSales\Setup\InstallData as FreshSalesData;
use Psr\Log\LoggerInterface;

/**
 * Observer for customer_register_success
 * @see \Magento\Customer\Controller\Account\CreatePost
 */
class CreateAccountObserver implements ObserverInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var CreateAccount
     */
    private $profile;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CreateAccountObserver constructor.
     * @param Client $client
     * @param CreateAccount $profile
     * @param CustomerRepositoryInterface $customerRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Client $client,
        CreateAccount $profile,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->profile = $profile;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    /**
     * Send API call to FreshSales to create an account
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $response = $this->client->sendApiCall(
            $this->profile,
            $this->formData($observer->getCustomer())
        );

        if ($response) {
            try {
                $this->customerRepository->save(
                    $observer->getCustomer()
                        ->setCustomAttribute(
                            FreshSalesData::FRESHSALES_ACCOUNT_ATTRIBUTE,
                            $response['sales_account']['id']
                        )
                );
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * @param CustomerInterface $customer
     * @return array
     */
    private function formData(CustomerInterface $customer): array
    {
        return [
            'sales_account' => [
                'name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
                'updated_at' => $customer->getUpdatedAt()
            ]
        ];
    }
}
