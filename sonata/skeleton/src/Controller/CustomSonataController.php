<?php


namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomSonataController extends CRUDController
{

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function cloneAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $clonedObject = clone $object;

        $clonedObject->setName($object->getName() . ' (Clone)');
        $clonedObject->setEmail($object->getEmail() . ' (Clone)');

        $this->admin->create($clonedObject);
//        $this->admin->setFilterTheme(array());
        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('clone', $this->getRouterIdParameter().'/clone');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', null, [
                'actions' => [

                    // ...

                    'clone' => [
                        'template' => '@App/CRUD/list__action_clone.html.twig',
                    ],
                ],
            ]);


    }


}