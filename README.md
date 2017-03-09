# Persistable Laravel Events
This package provides a quick and easy way to store Laravel Framework events to use for later debugging, monitoring, or analysis.


## Quickstart: 4-Step Installation
It's easy to get started storing events.  With no configuration, the package will store the class name, serialized event object, and timestamp for any desired events.


### Step 1: Install Composer Package
Install the composer package by running the following:

```
composer require ninjasimon/laravel-persistable-events
```


### Step 2: Add the service provider to config/app.php
As with most Laravel packages, you'll need to add the service provider to your app.php configuration file.  Simply add the following line to the 'providers' array:

```php
// config/app.php

'providers' => [
        // ...

        PersistableEvents\PersistableEventServiceProvider::class,

 ],
```


### Step 3: Create event database table
Run migrations to create a database table to store events.  Out of the box, the package will use the database connection you have distinguished as the 'default' connection in your config/database.php file.  This can be changed through the package configuration.

```
php artisan migrate
```


### Step 4: Extend the PersistableEvent class
To add persistence to any event, simply extend the PersistableEvents\PersistableEvent abstract class as shown below.  By default, when an event fires which extends this class, the event's class name, timestamp, and serialized object will be written to the database.  These values can be changed, and/or additional values can be added by overriding getter methods.

```php
<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;
use PersistableEvents\PersistableEvent;

class OrderShipped extends PersistableEvent
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
```