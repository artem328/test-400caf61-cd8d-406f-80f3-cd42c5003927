<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\HistoryRequestType;
use App\History\HistoryProviderInterface;
use App\Request\HistoryRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HistoryController extends AbstractController
{
    /**
     * @Route("/", name="history", methods={"GET", "POST"})
     */
    public function list(Request $request, HistoryProviderInterface $historyProvider): Response
    {
        $historyRequest = new HistoryRequest();
        $form = $this->createForm(HistoryRequestType::class, $historyRequest);

        $form->handleRequest($request);

        $history = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $history = $historyProvider->getInRange(
                $historyRequest->symbol,
                $historyRequest->startDate,
                $historyRequest->endDate
            );
        }

        return $this->render('history.html.twig', [
            'form' => $form->createView(),
            'history' => $history,
        ]);
    }
}
