<?php

namespace Ekyna\BackendBundle\Pagination;

use Pagerfanta\View\DefaultView;

class TwitterBootstrap3View extends DefaultView
{
    protected function createDefaultTemplate()
    {
        return new TwitterBootstrap3Template();
    }

    protected function getDefaultProximity()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap3';
    }
}