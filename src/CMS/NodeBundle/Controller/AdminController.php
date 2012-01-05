<?php

/*
 * This file is part of CMSNodeBundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMS\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lyra\AdminBundle\Controller\AdminController as BaseController;

class AdminController extends BaseController
{
    /**
     * Deletes a node.
     *
     * @param mixed $id node id
     */
    public function deleteAction($id)
    {
        $manager =  $this->container->get('lyra_content.node_manager');

        $node = $manager->findNode($id);
        if (!$node) {
            throw new NotFoundHttpException(sprintf('Node with id "%s" does not exist', $id));
        }

        if ($node->isRoot()) {
            throw new HttpException(403, 'Root node cannot be deleted.');
        }

        $form = $this->container->get('form.factory')
            ->createBuilder('form')
            ->getForm();

        $children = $manager->findNodeDescendants($node);
        if ('POST' === $this->container->get('request')->getMethod()) {
            $manager->removeNode($node);
            $this->setFlash('lyra_content success', 'flash.delete.success');

            return $this->getRedirectToListResponse();
        }

        $renderer = $this->getDialogRenderer();
        $renderer->setRouteParams(array('id' => $node->getId()));

        return $this->container->get('templating')
            ->renderResponse('LyraAdminBundle:Admin:delete.html.twig', array(
                'object' => $node,
                'csrf' => $this->container->get('form.csrf_provider')->generateCsrfToken('delete'),
                'renderer' => $renderer
            ));
    }

    /**
     * Moves a sub-tree (node + all its descendants) under a new parent.
     *
     * @param mixed $id node id
     */
    public function moveAction($id)
    {
        $manager =  $this->container->get('lyra_content.node_manager');

        $node = $manager->findNode($id);
        if (!$node) {
            throw new NotFoundHttpException(sprintf('Node with id "%s" does not exist', $id));
        }

        $form = $this->container->get('lyra_content.move_node.form');
        $form->setData($node);

        $request = $this->container->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid() && $manager->saveNode($node)) {
                return $this->getRedirectToListResponse();
            }
        }

        $renderer = $this->getDialogRenderer();
        $renderer->setRouteParams(array('id' => $node->getId()));

        return $this->container->get('templating')
            ->renderResponse('CMSNodeBundle:Admin:move.html.twig', array(
                'form' => $form->createView(),
                'content' => $node,
                'renderer' => $renderer
            ));
    }

    protected function executeMoveDown($id)
    {
        $this->moveNode('down', $id);
    }

    protected function executeMoveUp($id)
    {
        $this->moveNode('up', $id);
    }

    protected function moveNode($dir, $id)
    {
        $manager = $this->container->get('lyra_content.node_manager');
        $node = $manager->findNode($id);

        if (!$node) {
            throw new NotFoundHttpException(sprintf('Node with id "%s" does not exist', $id));
        }

        $dir == 'up' ? $manager->moveNodeUp($node) : $manager->moveNodeDown($node);
    }
}
