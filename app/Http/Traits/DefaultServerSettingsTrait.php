<?php

namespace App\Http\Traits;

trait DefaultServerSettingsTrait
{
    protected $defaultTimeZone = 'Asia/Kolkata';

    protected $databaseDateTimeFormat = 'Y-m-d H:i:s';

    protected $databaseDateFormat = 'Y-m-d';

    protected $clientDateTimeFormat = 'D d-M-Y h:i:s';

    protected $clientDateFormat = 'D d-M-Y h:i:s';

    protected $serverQueueName = '';

    public function __construct(){
        $this->serverQueueName = str_slug(config('app.name').'-'.config('app.url').'-'.config('app.env'));
    }

    /**
     * Get the value of defaultTimeZone
     */ 
    public function getDefaultTimeZone()
    {
        return $this->defaultTimeZone;
    }

    /**
     * Get the value of databaseDateTimeFormat
     */ 
    public function getDatabaseDateTimeFormat()
    {
        return $this->databaseDateTimeFormat;
    }

    /**
     * Get the value of databaseDateFormat
     */ 
    public function getDatabaseDateFormat()
    {
        return $this->databaseDateFormat;
    }

    /**
     * Get the value of clientDateFormat
     */ 
    public function getClientDateFormat()
    {
        return $this->clientDateFormat;
    }

    /**
     * Get the value of clientDateTimeFormat
     */ 
    public function getClientDateTimeFormat()
    {
        return $this->clientDateTimeFormat;
    }

    /**
     * Get the value of serverQueueName
     */ 
    public function getServerQueueName()
    {
        return $this->serverQueueName;
    }
}

?>