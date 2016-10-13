<?php

/**
 * Class SH_Telesign_Adminhtml_Telephone_BaseController
 */
class SH_Telesign_Adminhtml_Telephone_BaseController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Telephone Base');
        $this->_addContent($this->getLayout()->createBlock('sh_telesign/telephone_base'));
        $this->renderLayout();

    }

    public function exportCsvAction()
    {
        $fileName = 'Telephone Base_export.csv';
        $content = $this->getLayout()->createBlock('sh_telesign/telephone_base_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName = 'Telephone Base_export.xml';
        $content = $this->getLayout()->createBlock('sh_telesign/telephone_base_grid')->getExcel();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select Telephone Base(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('sh_telesign/telephone_base')->load($id);
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
        $this->_redirect('*/*/index');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sh_telesign/telephone_base');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('sh_telesign')->__('This Telephone Base no longer exists.')
                );
                $this->_redirect('*/*/');

                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_model', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('sh_telesign/telephone_base_edit'));
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
            $model = Mage::getModel('sh_telesign/telephone_base');
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->_getSession()->addError(
                        Mage::helper('sh_telesign')->__('This Telephone Base no longer exists.')
                    );
                    $this->_redirect('*/*/index');

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
                    Mage::helper('sh_telesign')->__('The Telephone Base has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('sh_telesign')->__('Unable to save the Telephone Base.'));
                $redirectBack = true;
                Mage::logException($e);
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);

                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('sh_telesign/telephone_base');
                $model->load($id);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('sh_telesign')->__('Unable to find a Telephone Base to delete.'));
                }
                $model->delete();
                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('sh_telesign')->__('The Telephone Base has been deleted.')
                );
                // go to grid
                $this->_redirect('*/*/index');

                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('sh_telesign')->__('An error occurred while deleting Telephone Base data. Please review log and try again.')
                );
                Mage::logException($e);
            }
            // redirect to edit form
            $this->_redirect('*/*/edit', ['id' => $id]);

            return;
        }
        // display error message
        $this->_getSession()->addError(
            Mage::helper('sh_telesign')->__('Unable to find a Telephone Base to delete.')
        );
        // go to grid
        $this->_redirect('*/*/index');
    }
}