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
	$movieList = file_get_contents( 'data/movies.json' );
	$encodedMovielist = json_decode($movieList, true);
	return $encodedMovielist;
}


// api_debug(json_decode(get_all_movies(),true));

function moviedata(){
	$movieFields = array();
		foreach(get_all_movies() as $key => $value) {
		 array_push($movieFields, $value);
		}
		return $movieFields;
}

//api_debug(recodeHal());

function get_url_query() {

	if (isset($_GET['title'])) {
		$query = $_GET['title'];
		return $query;
	}
}

//echo get_url_query();


function get_movies() {

	$query = get_url_query();

	$movieLists = get_all_movies() ;

	if(!empty($query)) {

	var_dump($query);

		foreach ($movieLists as $movie) {
			echo $movie['Title'];
		}


	} else {

		return $movieLists;

	}
}


function recodeHal() {
	$halFields = array();
	$halFields['_links'] = array(
		"self" => array(
			"href" => "/"
		),
		"next" => array(
			"href" => "/?page=2"
		)
	);
	$halFields['_embedded'] = array(
		"movies" => moviedata()
	);
	return $halFields;
}


print_r(get_movies());

