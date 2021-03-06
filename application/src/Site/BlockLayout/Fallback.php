<?php
namespace Omeka\Site\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Zend\View\Renderer\PhpRenderer;

class Fallback extends AbstractBlockLayout
{
    /**
     * @var string The name of the unknown block layout
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return sprintf('%s [%s]', 'Unknown', $this->name); // @translate
    }

    /**
     * {@inheritDoc}
     */
    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageBlockRepresentation $block = null
    ) {
        return $view->translate('This layout is invalid.');
    }

    /**
     * {@inheritDoc}
     */
    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        return '';
    }
}
