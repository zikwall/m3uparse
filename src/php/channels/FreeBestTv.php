<?php

namespace zikwall\m3uparse\channels;

use zikwall\m3uparse\Helper;

class FreeBestTv extends BaseChannel implements IChannel
{
    public function get()
    {
        return json_decode(file_get_contents(Helper::getChannelsDir() . '/free_best_tv.json'), true);
    }
}