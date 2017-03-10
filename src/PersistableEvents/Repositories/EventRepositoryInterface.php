<?php

namespace PersistableEvents\Repositories;

use PersistableEvents\PersistableEvent;

interface EventRepositoryInterface {

    public function writeEvent(PersistableEvent $event);

    public function deleteAllEvents();

    public function deleteEventById($eventId);

}
