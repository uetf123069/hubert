<?php // Code within app\Helpers\Helper.php

   namespace App\Helpers;

    class Helper
    {
        public static function test($user_id)
        {
        	if($user_id)
        	{
        		return "sdsdffd";
        	}
        	else
        	{
        		return "false";
        	}
        }
    }