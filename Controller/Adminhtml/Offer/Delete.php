<?php
/**
* Mickael Offers Adminhtml Offer delete Controller.
*
* @author    Mickael BAILLOT <mickael.bailot@gmail.com>
* @category  Mickael
* @package   Mickael\Offers
*/
declare(strict_types=1);

namespace Mickael\Offers\Controller\Adminhtml\Offer;

class Delete extends \Mickael\Offers\Controller\Adminhtml\Offer
{
  protected $_coreRegistry;

  /**
   * @param \Magento\Backend\App\Action\Context $context
   * @param \Magento\Framework\Registry $coreRegistry
   */
  public function __construct(
      \Magento\Backend\App\Action\Context $context,
      \Magento\Framework\Registry $coreRegistry,
      \Magento\Framework\View\Result\PageFactory $resultPageFactory
  ) {
      $this->_coreRegistry = $coreRegistry;
      parent::__construct($context, $coreRegistry);
  }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Mickael\Offers\Model\Offer::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Offer.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['offer_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Offer to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
