<?php

namespace Tests\Ddeboer\VatinBundle\Functional;

use Ddeboer\Vatin\Exception\ViesException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\Ddeboer\VatinBundle\Functional\app\TestKernel;

class ValidatorAnnotationTest extends WebTestCase
{
    private ?ValidatorInterface $validator = null;


    /**
     * @inheritDoc
     */
    protected static function getKernelClass () : string
    {
        return TestKernel::class;
    }


    /**
     * @inheritDoc
     */
    protected function setUp () : void
    {
        static::bootKernel();
        $container = static::$kernel->getContainer();
        $this->validator = $container->get('test.validator');
    }


    public function testValid () : void
    {
        $model = new Model();
        $errors = $this->validator->validate($model);
        $this->assertEquals(0, count($errors));

        $model->vat = 'NL123456789B01';
        $this->assertCount(0, $this->validator->validate($model));
    }


    public function testCheckExistence () : void
    {
        $model = new Model();
        $model->vatCheckExistence = '123';
        $this->assertCount(1, $this->validator->validate($model));

        $model->vatCheckExistence = 'NL123456789B01';
        try
        {
            $this->assertCount(1, $this->validator->validate($model));
        }
        catch (ValidatorException $e)
        {
            if (!$e->getPrevious() instanceof ViesException)
            {
                throw $e;
            }
            // Ignore unreachable VIES service: at least the check was triggered
        }
    }
}
