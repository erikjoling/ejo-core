<?php 
/**
 * TO PREVENT CODE-DEPENDANCIES AMONG PLUGINS AND/OR THEMES:
 * ONLY USE WHEN ABSOLUTELY SURE EJO-BASE IS INSTALLED
 * (and then still I don't know if it's okay...)
 *
 * Better get these in my code library and include functions if necessary
 */

/**
 * Delete the first array-record based on value
 */
function array_unset_by_value( $value, $array )
{
	$key = array_search($value, $array);

	if( $key !== false)
		unset($array[$key]);

	return $array;
}