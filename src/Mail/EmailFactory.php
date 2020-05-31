<?php

declare(strict_types=1);

namespace App\Mail;

use App\Repository\CompanyRepositoryInterface;
use App\Request\HistoryRequest;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class EmailFactory implements EmailFactoryInterface
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function createHistoryEmail(HistoryRequest $request): Email
    {
        $company = $this->companyRepository->findBySymbol($request->symbol);

        if (null === $company) {
            throw new \UnexpectedValueException(\sprintf('Couldn\'t find a company for symbol %s', $request->symbol));
        }

        $email = new TemplatedEmail();
        $email->from(new Address('no-reply@localhost')); // TODO: move to config
        $email->to(new Address($request->email));
        $email->subject($company->getName());
        $email->textTemplate('mail/history.txt.twig');
        $email->context([
            'from' => $request->startDate,
            'to' => $request->endDate,
        ]);

        return $email;
    }
}
