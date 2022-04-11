<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class UnprocessableEntityException extends Exception
{

    /**
     * @var ConstraintViolationListInterface
     */
    private ConstraintViolationListInterface $constraintViolationList;

    /**
     * Constructor of the class
     *
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList() : ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
