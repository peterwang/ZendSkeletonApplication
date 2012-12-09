<?php

namespace Bookmark\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Bookmark\Model\Bookmark;
use Bookmark\Form\BookmarkForm;

class BookmarkController extends AbstractActionController
{
    protected $bookmarkTable;

    public function getBookmarkTable()
    {
        if (!$this->bookmarkTable) {
            $sm = $this->getServiceLocator();
            $this->bookmarkTable = $sm->get('Bookmark\Model\BookmarkTable');
        }
        return $this->bookmarkTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
                                 'bookmarks' => $this->getBookmarkTable()->fetchAll(),
                                 ));
    }

    public function addAction()
    {
        $form = new BookmarkForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $bookmark = new Bookmark();
            $form->setInputFilter($bookmark->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $bookmark->exchangeArray($form->getData());
                $this->getBookmarkTable()->saveBookmark($bookmark);

                return $this->redirect()->toRoute('bookmark');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('bookmark', array(
                'action' => 'add'
            ));
        }
        $bookmark = $this->getBookmarkTable()->getBookmark($id);

        $form  = new BookmarkForm();
        $form->bind($bookmark);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($bookmark->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getBookmarkTable()->saveBookmark($form->getData());

                return $this->redirect()->toRoute('bookmark');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }


    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('bookmark');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getBookmarkTable()->deleteBookmark($id);
            }

            return $this->redirect()->toRoute('bookmark');
        }

        return array(
            'id'    => $id,
            'bookmark' => $this->getBookmarkTable()->getBookmark($id)
        );
    }
}