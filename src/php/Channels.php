<?php

namespace zikwall\m3uparse;

use zikwall\m3uparse\channels\IChannel;

class Channels
{
    final public static function normalize() : array
    {
        return json_decode(file_get_contents(__DIR__ . '/normalization/normalize.json'), true);
    }

    final public static function merge($channels = []) : array
    {
        $normals = self::normalize();

        foreach ($channels as $channel) {
            foreach ($channel as $name => $id) {
                if (!isset($normals[$id])) {
                    continue;
                }

                $normals[$id]['various'][] = $name;
            }
        }

        foreach ($normals as $k => $normal) {
            if ((bool) $normal['use'] == false) {
                unset($normals[$k]);
            }

            if (count($normal['various']) <= 0) {
                unset($normals[$k]);
            }
        }

        return $normals;
    }
}
