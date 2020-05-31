<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class ValidSymbol extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Symbol is not supported.';
}
