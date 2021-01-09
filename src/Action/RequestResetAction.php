<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Action;

use FOS\UserBundle\Form\Type\RequestPasswordFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RequestResetAction
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(Environment $twig, FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->twig        = $twig;
        $this->formFactory = $formFactory;
        $this->router      = $router;
    }

    public function __invoke(): Response
    {
        $form = $this->formFactory->create(RequestPasswordFormType::class, null, [
            'action' => $this->router->generate('FOS_user_resetting_send_email'),
            'method' => 'POST',
        ]);

        return new Response($this->twig->render('@FOSUser/Resetting/request.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
