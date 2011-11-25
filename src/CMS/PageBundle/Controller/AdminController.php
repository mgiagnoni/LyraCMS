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

        $form = $this->getFormRenderer()->getForm($page);

        $request = $this->container->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $this->container->get('lyra_content.page_manager')->savePage($page)) {
                return $this->getRedirectToListResponse();
            }
        }

        return $this->getRenderFormResponse($form);
    }

    protected function getRedirectToListResponse()
    {
        $renderer = $this->getListRenderer('node');

        return new RedirectResponse(
            $this->container->get('router')->generate($renderer->getRoutePrefix().'_index')
        );
    }
}
