<?php

namespace zikwall\m3uparse\channels;

use zikwall\m3uparse\Helper;

class Free extends BaseChannel implements IChannel
{
    public function get()
    {
        return json_encode(file_get_contents(Helper::getChannelsDir() . '/free.json'));
    }
}