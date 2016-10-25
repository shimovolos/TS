<?php

/**
 * Class SH_Telesign_Adminhtml_Telephone_Transactions
 */
class SH_Telesign_Adminhtml_Telephone_TransactionsController extends Mage_Adminhtml_Controller_Action
{
    public function _isAllowed()
    {
        return true;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Telesign Transactions');
        $this->_addContent($this->getLayout()->createBlock('sh_telesign/telephone_transactions'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('sh_telesign/telephone_transactions')
                ->setUseAjax(true)
                ->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName = 'Telesign Transactions_export.csv';
        $content = $this->getLayout()->createBlock('sh_telesign/telephone_transactions_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName = 'Telesign Transactions_export.xml';
        $content = $this->getLayout()->createBlock('sh_telesign/telephone_transactions_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select Telesign Transactions(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('sh_telesign/transactions')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('sh_telesign')->__('An error occurred while mass deleting items. Please review log and try again.')
                );
                Mage::logException($e);

                return;
            }
        }
        $this->_redirect('*/*/grid');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sh_telesign/transactions');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('sh_telesign')->__('This Telesign Transactions no longer exists.')
                );
                $this->_redirect('*/*/');

                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('entity_id', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('sh_telesign/telephone_transactions_edit'));
        $this->getLayout()->getBlock('head')->setTitle('Edit Telesign Transactions');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('sh_telesign/transactions');
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->_getSession()->addError(
                        Mage::helper('sh_telesign')->__('This Telesign Transactions no longer exists.')
                    );
                    $this->_redirect('*/*/grid');

                    return;
                }
            }

            // save model
            try {
                $model->addData($data);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('sh_telesign')->__('The Telesign Transactions has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('sh_telesign')->__('Unable to save the Telesign Transactions.'));
                $redirectBack = true;
                Mage::logException($e);
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);

                return;
            }
        }
        $this->_redirect('*/*/grid');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('sh_telesign/transactions');
                $model->load($id);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('sh_telesign')->__('Unable to find a Telesign Transactions to delete.'));
                }
                $model->delete();
                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('sh_telesign')->__('The Telesign Transactions has been deleted.')
                );
                // go to grid
                $this->_redirect('*/*/grid');

                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('sh_telesign')->__('An error occurred while deleting Telesign Transactions data. Please review log and try again.')
                );
                Mage::logException($e);
            }
            // redirect to edit form
            $this->_redirect('*/*/edit', ['id' => $id]);

            return;
        }
        // display error message
        $this->_getSession()->addError(
            Mage::helper('sh_telesign')->__('Unable to find a Telesign Transactions to delete.')
        );
        // go to grid
        $this->_redirect('*/*/grid');
    }
}