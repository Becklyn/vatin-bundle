<?php declare(strict_types=1);

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Ddeboer\Vatin\Exception\ViesException;
use Ddeboer\Vatin\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Validate a VAT identification number using the ddeboer/vatin library
 */
class VatinValidator extends ConstraintValidator
{
    /**
     * VATIN validator
     */
    private Validator $validator;


    public function __construct (Validator $validator)
    {
        $this->validator = $validator;
    }


    /**
     * {@inheritdoc}
     */
    public function validate ($value, Constraint $constraint) : void
    {
        if (!$constraint instanceof Vatin)
        {
            throw new UnexpectedTypeException($constraint, Vatin::class);
        }

        if (null === $value || '' === $value)
        {
            return;
        }

        if ($this->isValidVatin($value, $constraint->checkExistence))
        {
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }


    /**
     * Is the value a valid VAT identification number?
     *
     * @param string $value          Value
     * @param bool   $checkExistence Also check whether the VAT number exists
     */
    private function isValidVatin (string $value, bool $checkExistence) : bool
    {
        try
        {
            return $this->validator->isValid($value, $checkExistence);
        }
        catch (ViesException $e)
        {
            throw new ValidatorException('VIES service unreachable', 0, $e);
        }
    }
}
