<?php
namespace Omeka\Model\Entity;

/**
 * @Entity
 */
class ItemSet extends Resource
{
    /**
     * @Id
     * @Column(type="integer")
     */
    protected $id;

    public function getResourceName()
    {
        return 'item_sets';
    }

    public function getId()
    {
        return $this->id;
    }
}