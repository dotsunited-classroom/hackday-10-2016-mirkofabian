<?php
/**
 * Created by PhpStorm.
 * User: fabian
 * Date: 04.10.16
 * Time: 10:36
 */

function api_debug( $args ) {
	echo '<pre>';
	print_r($args);
	echo '</pre>';
}


function get_all_movies() {
	$movieList = file_get_contents(__DIR__. '/data/movies.json' );
	$encodedMovielist = json_decode($movieList, true);
	return $encodedMovielist;
}

function movieData(array $filter = []){
	$movieFields = array();

	foreach(get_all_movies() as $key => $value) {
		if (
			isset($filter['title']) &&
		    is_string($filter['title']) &&
		    '' !== $filter['title'] &&
			$filter['title'] !== $value['Title']
		) {
			continue;
		}

	    array_push($movieFields, $value);
	}
	return $movieFields;
}

function recodeHal(array $filter = []) {
	$halFields = array();
	$halFields['_links'] = array(
		"self" => array(
			"href" => "/"
		),
		"next" => array(
			"href" => "/"
		)
	);
	$halFields['_embedded'] = array(
		"movies" => movieData($filter)
	);
	return $halFields;
}

api_debug(recodeHal($_GET),true);

