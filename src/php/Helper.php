<?php

namespace zikwall\m3uparse;

class Helper
{
   public static function ROOT() : string
   {
       return dirname(dirname(__DIR__));
   }
}
