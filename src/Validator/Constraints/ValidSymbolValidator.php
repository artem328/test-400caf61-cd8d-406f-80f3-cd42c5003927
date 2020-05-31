<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Repository\CompanyRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ValidSymbolValidator extends ConstraintValidator
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
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value) {
            return;
        }

        if (!$constraint instanceof ValidSymbol) {
            throw new UnexpectedTypeException($constraint, ValidSymbol::class);
        }

        $company = $this->companyRepository->findBySymbol($value);

        if (null !== $company) {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->setInvalidValue($value)
            ->addViolation()
        ;
    }
}
