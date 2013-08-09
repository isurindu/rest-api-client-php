<?php
namespace Smsglobal\ClassLibrary\Resource\Proxy;

use Smsglobal\ClassLibrary\Resource\MmsIncoming;
use Smsglobal\ClassLibrary\ResourceManager;

class MmsIncomingProxy extends MmsIncoming
{
    private $manager;

    public function __construct($resourceUri, ResourceManager $manager)
    {
        $this->resourceUri = $resourceUri;
        $this->manager = $manager;

        // Get the ID from the resource URI
        // /v1/resource/id/ -> id
        $this->id = substr($resourceUri, 0, -1);
        $this->id = (int) substr($this->id, strrpos('/', $this->id) + 1, -1);
    }

    private function load()
    {
        if (isset($this->manager)) {
            $options = $this->manager->get($this->getResourceName(), $this->id);
            $this->setOptions($options);

            unset($this->manager);
        }
    }

    public function getOrigin()
    {
        $this->load();
        return parent::getOrigin();
    }

    public function getDestination()
    {
        $this->load();
        return parent::getDestination();
    }

    public function getSubject()
    {
        $this->load();
        return parent::getSubject();
    }

    public function getMessage()
    {
        $this->load();
        return parent::getMessage();
    }

    public function getDateTimeReceived()
    {
        $this->load();
        return parent::getDateTimeReceived();
    }

    public function getAttachments()
    {
        $this->load();
        return parent::getAttachments();
    }

}