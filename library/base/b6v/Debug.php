<?php
class b6v_Debug extends b6v_Base
{
	public static function dodebug()
	{
		return (getenv('DEBUG') == 'yes');
	}
	public static function show($value)
	{
		if (! self::doDebug()) {
			return;
		}
		echo "<pre>" . print_r ( $value , true ) . "</pre><br/>";
		 
	}
}