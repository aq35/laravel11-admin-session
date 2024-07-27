<?php

namespace YourVendor\AdminSession\Extensions;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class DatabaseAdminSessionHandler extends BaseDatabaseSessionHandler
{
    protected function getQuery()
    {
        return parent::getQuery()->from(config('adminsession.table', 'admin_sessions'));
    }

    /**
     * Add the user information to the session payload.
     *
     * @param  array  $payload
     * @return $this
     */
    protected function addUserInformation(&$payload)
    {
        if ($this->container->bound(Guard::class)) {
            $payload['admin_id'] = $this->userId();
        }

        return $this;
    }
}