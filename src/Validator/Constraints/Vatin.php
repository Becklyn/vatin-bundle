<?php declare(strict_types=1);

namespace Ddeboer\VatinBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * VAT identification number constraint
 *
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Vatin extends Constraint
{
    public string $message = 'This is not a valid VAT identification number';
    public bool $checkExistence = false;


    /**
     * Vatin constructor.
     *
     * @param null $payload
     */
    public function __construct (
        ?array $options = null,
        ?string $message = null,
        ?bool $checkExistence = null,
        ?array $groups = null,
        $payload = null
    )
    {
        if ($message)
        {
            $options['message'] = $message;
        }

        if ($checkExistence)
        {
            $options['checkExistence'] = $checkExistence;
        }

        parent::__construct($options ?? [], $groups, $payload);
    }


    /**
     * @inheritDoc
     */
    public function validatedBy () : string
    {
        return 'ddeboer_vatin.validator';
    }
}
