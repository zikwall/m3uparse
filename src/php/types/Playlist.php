<?php

class Playlist extends IType
{
    public function __construct($epgId, $name, $url)
    {
        $this->epgId = $epgId;
        $this->name = $name;
        $this->url = $url;
    }
}