<?php
declare(strict_types=1);

namespace AppBundle\Document\Abstraction;

interface ReminderDeliveryTargetInterface
{
    /**
     * @return string
     */
    public function getDestination();
}
