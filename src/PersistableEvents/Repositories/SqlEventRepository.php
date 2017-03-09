<?php

namespace PersistableEvents\Repositories;

use PersistableEvents\PersistableEvent;
use Illuminate\Database\Connection as DatabaseConnection;

class SqlEventRepository implements EventRepositoryInterface
{
    private $dbConnection;

    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function writeEvent(PersistableEvent $event)
    {
        $this->dbConnection->table('event_store')->insert([
            'event_name' => $event->getName(),
            'entity_id' => $event->getEntityId(),
            'actor_id' => $event->getActorId(),
            'data' => $event->getData(),
            'timestamp' => $event->getTimestamp(),
        ]);
    }
}