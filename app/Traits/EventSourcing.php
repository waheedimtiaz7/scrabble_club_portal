<?php

namespace App\Traits;

use App\Models\Event;

trait EventSourcing
{
    public function recordEvent($eventType, $payload = [], $old_payload = [])
    {
        Event::create([
            'event_type' => $eventType,
            'aggregate_id' => $this->id,
            'payload' => $payload,
            'old_payload' => $old_payload
        ]);
    }

    public function getEvents()
    {
        return Event::where('aggregate_id', $this->id)->get();
    }
}
