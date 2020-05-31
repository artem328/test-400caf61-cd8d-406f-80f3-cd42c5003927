<?php

declare(strict_types=1);

namespace App\Request;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class HistoryRequest
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @AppAssert\ValidSymbol
     */
    public $symbol;

    /**
     * @var \DateTimeImmutable
     *
     * @Assert\NotBlank
     * @Assert\LessThanOrEqual("today")
     */
    public $startDate;

    /**
     * @var \DateTimeImmutable
     *
     * @Assert\NotBlank
     * @Assert\Expression(
     *     "null !== this.startDate && this.startDate < value",
     *     message="End date must be greater than start date"
     * )
     */
    public $endDate;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $email;
}
