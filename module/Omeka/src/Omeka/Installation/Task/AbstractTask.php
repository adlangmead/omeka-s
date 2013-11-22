<?php
namespace Omeka\Installation\Task;

use Omeka\Installation\Result;
use Omeka\Stdlib\ErrorStore;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract installation task.
 */
abstract class AbstractTask implements TaskInterface, ServiceLocatorAwareInterface
{
    /**
     * @var Result
     */
    protected $result;

    /**
     * @var ServiceLocatorInterface
     */
    protected $services;

    /**
     * Construct the task.
     *
     * @param Result $result
     */
    public function __construct(Result $result)
    {
        $result->setCurrentTask(get_class($this), $this->getName());
        $this->result = $result;
    }

    /**
     * Add an error message.
     *
     * @param string $message
     */
    public function addError($message)
    {
        $this->result->addMessage($message, Result::MESSAGE_TYPE_ERROR);
    }

    /**
     * Add errors derived from an ErrorStore.
     *
     * @param ErrorStore $errorStore
     */
    public function addErrorStore(ErrorStore $errorStore)
    {
        foreach ($errorStore->getErrors() as $error) {
            foreach ($error as $message) {
                $this->addError($message);
            }
        }
    }

    /**
     * Add a warning message.
     *
     * @param string $message
     */
    public function addWarning($message)
    {
        $this->result->addMessage($message, Result::MESSAGE_TYPE_WARNING);
    }

    /**
     * Add an info message.
     *
     * @param string $message
     */
    public function addInfo($message)
    {
        $this->result->addMessage($message, Result::MESSAGE_TYPE_INFO);
    }

    /**
     * Get the result object.
     *
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceLocator()
    {
        return $this->services;
    }
}