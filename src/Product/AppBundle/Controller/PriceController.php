<?php

declare(strict_types=1);

namespace Product\AppBundle\Controller;

use Product\AppBundle\Form\Model\AddPriceFormModel;
use Product\AppBundle\Form\Type\AddPriceFormType;
use Product\Domain\Exception\AbstractProductDomainException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

final class PriceController extends Controller
{
    public function addAction(Request $request)
    {
        $formModel = new AddPriceFormModel();
        $form = $this->createForm(AddPriceFormType::class, $formModel);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $command = $formModel->toCommand();
            try {
                $this->get('command_bus')->handle($command);
            } catch (AbstractProductDomainException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }

            return $this->redirectToRoute('product_app_homepage');
        }

        return $this->render(
            '@ProductApp/Price/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
