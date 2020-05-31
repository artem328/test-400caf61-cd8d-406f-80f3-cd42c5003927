<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\HistoryRequestType;
use App\History\HistoryProviderInterface;
use App\Request\HistoryRequest;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
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
        LoggerInterface $logger
    ): Response {
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

            try {
                $mailer->send($this->buildEmail($historyRequest));
            } catch (TransportExceptionInterface $e) {
                $logger->error('Failed to send a history email. {message}', [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                ]);
            }
        }

        return $this->render('history.html.twig', [
            'form' => $form->createView(),
            'history' => $history,
        ]);
    }

    private function buildEmail(HistoryRequest $request): Email
    {
        $email = new TemplatedEmail();
        $email->from(new Address('no-reply@localhost')); // TODO: move to config
        $email->to(new Address($request->email));
        $email->subject($request->symbol); // TODO: replace with the company name
        $email->textTemplate('mail/history.txt.twig');
        $email->context([
            'from' => $request->startDate,
            'to' => $request->endDate,
        ]);

        return $email;
    }
}
