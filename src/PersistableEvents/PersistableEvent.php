<?php

namespace PersistableEvents;

abstract class PersistableEvent
{
    public function getName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    public function getEntityId()
    {
        return 0;
    }

    public function getActorId()
    {
        return 0;
    }

    public function getData()
    {
        return serialize($this);
    }

    public function getTimestamp()
    {
        return date('Y-m-d H:i:s');
    }
}
