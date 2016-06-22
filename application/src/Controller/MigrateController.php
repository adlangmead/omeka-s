<?php
namespace Omeka\Controller;

use Omeka\Db\Migration\Manager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MigrateController extends AbstractActionController
{
    /**
     * @var Manager
     */
    protected $migrationManager;

    /**
     * @param Manager $migrationManager
     */
    public function __construct(Manager $migrationManager)
    {
        $this->migrationManager = $migrationManager;
    }

    public function indexAction()
    {
        if (!$this->status()->needsMigration()) {
            return $this->redirect()->toRoute('admin');
        }

        if ($this->getRequest()->isPost()) {
            // Perform migrations and update the installed version.
            $this->migrationManager->upgrade();
            $this->settings()->set('version', $this->status()->getVersion());
            $this->messenger()->addSuccess("Migration successful");
            return $this->redirect()->toRoute('admin');
        }

        $this->layout('layout/minimal');
        $view = new ViewModel;
        return $view;
    }
}
