<?php

// global namespace, for integration with smarty templating
if( !function_exists("smarty_modifier_ago") ) {

	function smarty_modifier_ago( $stamp ) {
		$difference = time() - strtotime( $stamp );

		if( $difference === 0 ) $difference = 1;

		$range = array(
			"second" => 1,
			"minute" => 60,
			"hour" => 3600,
			"day" => 86400,
			"week" => 604800,
			"month" => 2629800, // 30.4375 days in a month
			"year" => 31557600, // 365.25 days in a year,
			"decade" => 315576000
		);

		$scale = array();

		foreach( $range as $name => $max_value ) {
			$relative_difference = $difference / $max_value;
			$coefficient = intval( $relative_difference );
			$remainder = $relative_difference - ($coefficient * $max_value);
			if( $coefficient == 0 ) continue;

			$scale[$name] = array(
				"coefficient" => $coefficient,
				"remainder" => $remainder,
				"unit" => $name
			);
		}

		$last = array_pop( $scale );
		$english = sprintf(
			"%s %s%s ",
			$last["coefficient"],
			$last["unit"],
			($last["coefficient"] === 1 ? '' : 's')
		);
		return( $english );
	}

}
