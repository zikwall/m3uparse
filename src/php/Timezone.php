<?php


namespace zikwall\m3uparse;


class Timezone
{
    public static function GMToffsetHours(int $offsetTime) : int
    {
        return $offsetTime / 3600;
    }
}
