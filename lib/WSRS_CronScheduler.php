<?php

class WSRS_CronScheduler
{
    private const NEXT_EVENT_12_H = 43200;

    /**
     * @param mixed $request
     *
     * @return mixed
     */
    public function scheduleIfNotScheduled($request)
    {
        if (!$this->isCronEventScheduled()) {
            $this->scheduleEvent();

            return $request;
        }
        $this->fixCron();

        return $request;
    }

    /**
     * @return boolean
     */
    public function isCronEventScheduled()
    {
        return (false !== wp_get_schedule(WSRS_Config::WSRS_CRON_HOOK_NAME));
    }

    public function scheduleEvent()
    {
        wp_schedule_event(time() + self::NEXT_EVENT_12_H, 'twicedaily', WSRS_Config::WSRS_CRON_HOOK_NAME);
    }

    public function fixCron()
    {
        $scheduledTimestamp = wp_next_scheduled(WSRS_Config::WSRS_CRON_HOOK_NAME);
        if (false !== $scheduledTimestamp && $scheduledTimestamp < time()) {
            $this->rescheduleEvent();
        }
    }

    public function rescheduleEvent()
    {
        if (!$this->isCronEventScheduled()) {
            $this->scheduleEvent();
            return;
        }
        $scheduled = wp_get_scheduled_event(WSRS_Config::WSRS_CRON_HOOK_NAME);
        wp_unschedule_event($scheduled->timestamp, $scheduled->hook);
        $this->scheduleEvent();
    }
}
