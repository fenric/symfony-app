<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class ResponseListener
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Constructor of the class
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ResponseEvent $event
     *
     * @return void
     */
    public function onKernelResponse(ResponseEvent $event) : void
    {
        if ($this->entityManager->isOpen()) {
            $this->entityManager->flush();
        }
    }
}
