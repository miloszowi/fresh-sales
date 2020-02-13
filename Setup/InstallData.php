<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    const FRESHSALES_ACCOUNT_ATTRIBUTE = 'fresh_sales_account_identifier';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $installer]);
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            self::FRESHSALES_ACCOUNT_ATTRIBUTE,
            [
                'type'         => 'varchar',
                'length'       => 100,
                'label'        => 'Fresh Sales Account ID',
                'input'        => 'text',
                'required'     => false,
                'visible'      => false,
                'is_user_defined' => true,
                'used_in_forms' => false,
                'position'     => 999,
                'system'       => 0,
            ]
        );

        $setup->endSetup();

        $installer->endSetup();
    }
}
