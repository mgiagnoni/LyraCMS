<?php

/*
 * This file is part of CMSPageBundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Lyra\AdminBundle\Controller\AdminController as BaseController;

class AdminController extends BaseController
{
    /**
     * Creates a new page.
     */
    public function newAction()
    {
        $page = $this->container->get('lyra_content.page_manager')
            ->createPage();

        $form = $this->getForm($page);

        if ($form->handleRequest($this->getRequest())) {
            $this->container->get('lyra_content.page_manager')->savePage($page);

            return $this->getRedirectToListResponse();
        }

        return $this->getRenderFormResponse($form);
    }

    protected function getRedirectToListResponse()
    {
        return new RedirectResponse(
            $this->container->get('router')->generate($this->getActions('node')->get('index')->getRouteName())
        );
    }
}
