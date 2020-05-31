<?php

declare(strict_types=1);

namespace App\Mail;

use App\Request\HistoryRequest;
use Symfony\Component\Mime\Email;

interface EmailFactoryInterface
{
    public function createHistoryEmail(HistoryRequest $request): Email;
}
