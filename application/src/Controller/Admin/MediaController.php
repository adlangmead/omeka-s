<?php
namespace Omeka\Controller\Admin;

use Omeka\Form\ConfirmForm;
use Omeka\Form\ResourceForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class MediaController extends AbstractActionController
{
    public function searchAction()
    {
        $view = new ViewModel;
        $view->setVariable('query', $this->params()->fromQuery());
        return $view;
    }

    public function browseAction()
    {
        $this->setBrowseDefaults('created');
        $response = $this->api()->search('media', $this->params()->fromQuery());
        $this->paginator($response->getTotalResults(), $this->params()->fromQuery('page'));

        $view = new ViewModel;
        $medias = $response->getContent();
        $view->setVariable('medias', $medias);
        $view->setVariable('resources', $medias);
        return $view;
    }

    public function editAction()
    {
        $form = $this->getForm(ResourceForm::class);
        $id = $this->params('id');
        $response = $this->api()->read('media', $id);
        $media = $response->getContent();

        $view = new ViewModel;
        $view->setVariable('form', $form);
        $view->setVariable('media', $media);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $response = $this->api()->update('media', $id, $data);
                if ($response->isError()) {
                    $view->setVariable('errors', $response->getErrors());
                    $form->setMessages($response->getErrors());
                } else {
                    $this->messenger()->addSuccess('Media Updated.');
                    return $this->redirect()->toUrl($response->getContent()->url());
                }
            } else {
                $this->messenger()->addError('There was an error during validation');
            }
        }
        return $view;
    }

    public function showAction()
    {
        $response = $this->api()->read('media', $this->params('id'));

        $view = new ViewModel;
        $media = $response->getContent();
        $view->setVariable('media', $media);
        $view->setVariable('resource', $media);
        return $view;
    }

    public function showDetailsAction()
    {
        $linkTitle = (bool) $this->params()->fromQuery('link-title', true);
        $response = $this->api()->read('media', $this->params('id'));
        $media = $response->getContent();
        $values = $media->valueRepresentation();

        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setVariable('linkTitle', $linkTitle);
        $view->setVariable('resource', $media);
        $view->setVariable('values', json_encode($values));
        return $view;
    }

    public function deleteConfirmAction()
    {
        $linkTitle = (bool) $this->params()->fromQuery('link-title', true);
        $response = $this->api()->read('media', $this->params('id'));
        $media = $response->getContent();
        $values = $media->valueRepresentation();

        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setTemplate('common/delete-confirm-details');
        $view->setVariable('resource', $media);
        $view->setVariable('resourceLabel', 'media');
        $view->setVariable('partialPath', 'omeka/admin/media/show-details');
        $view->setVariable('linkTitle', $linkTitle);
        $view->setVariable('values', json_encode($values));
        return $view;
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = $this->getForm(ConfirmForm::class);
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $response = $this->api()->delete('media', $this->params('id'));
                if ($response->isError()) {
                    $this->messenger()->addError('Media could not be deleted');
                } else {
                    $this->messenger()->addSuccess('Media successfully deleted');
                }
            } else {
                $this->messenger()->addError('Media could not be deleted');
            }
        }
        return $this->redirect()->toRoute(
            'admin/default',
            ['action' => 'browse'],
            true
        );
    }
}
