<?php
/**
 * @copyright Copyright (c) Miłosz Guglas <https://github.com/miloszowi>
 */

declare(strict_types=1);

namespace Miloszowi\FreshSales\Block\Adminhtml\CustomerEdit\Tab;

use Magento\Backend\Block\Template;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

class View extends Template implements TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'tab/fresh_sales.phtml';

    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * View constructor.
     *
     * @param Template\Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->_coreRegistry->registry(\Magento\Customer\Controller\RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * @return Phrase
     */
    public function getTabLabel(): Phrase
    {
        return __('Customer View in Fresh Sales');
    }

    /**
     * @return Phrase
     */
    public function getTabTitle(): Phrase
    {
        return __('Customer View in Fresh Sales');
    }

    /**
     * @return bool
     */
    public function canShowTab(): bool
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        if ($this->getCustomerId()) {
            return false;
        }
        return true;
    }

    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass(): string
    {
        return '';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl(): string
    {
        return '';
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded(): bool
    {
        return false;
    }
}
