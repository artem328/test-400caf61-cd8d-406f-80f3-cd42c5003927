<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\HistoryRequestType;
use App\History\HistoryProviderInterface;
use App\Mail\EmailFactoryInterface;
use App\Request\HistoryRequest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

final class HistoryController extends AbstractController
{
    /**
     * @Route("/", name="history", methods={"GET", "POST"})
     */
    public function list(
        Request $request,
        HistoryProviderInterface $historyProvider,
        MailerInterface $mailer,
        EmailFactoryInterface $emailFactory,
        LoggerInterface $logger
    ): Response {
        $historyRequest = new HistoryRequest();
        $form = $this->createForm(HistoryRequestType::class, $historyRequest);

        $form->handleRequest($request);

        $history = null;
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $history = $historyProvider->getInRange(
                    $historyRequest->symbol,
                    $historyRequest->startDate,
                    $historyRequest->endDate
                );
            } catch (\Throwable $e) {
                $error = \sprintf('Error occurred during fetching a history: %s', $e->getMessage());
            }

            try {
                $mailer->send($emailFactory->createHistoryEmail($historyRequest));
            } catch (\Throwable $e) {
                $logger->error('Failed to send a history email. {message}', [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                ]);
            }
        }

        return $this->render('history.html.twig', [
            'form' => $form->createView(),
            'history' => $history,
            'error' => $error,
        ]);
    }
}
