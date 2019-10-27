<?php

namespace zikwall\m3uparse;

class Channels
{
    final public static function get(string $name) : array
    {
        return json_decode(file_get_contents(self::resolveName($name)), true);
    }

    public static function resolveName(string $name) : string
    {
        return sprintf('%s/channels/%s.json', Helper::ROOT(), $name);
    }

    final public static function norm() : array
    {
        return self::get('normilize');
    }

    final public static function merge(...$channels) : array
    {
        $normals = self::norm();

        foreach ($channels as $channel) {
            foreach ($channel as $id => $name) {

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
