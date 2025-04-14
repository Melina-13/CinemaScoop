<?php
include('db.php');

//  l'heure actuelle pour la recherche des films projetés en ce moment
$current_date = date('Y-m-d H:i:s');

// les films projetés actuellement
$query = "SELECT movie_schedule.id_movie, movie_schedule.date_begin, movie.title, room.number 
          FROM movie_schedule 
          JOIN movie ON movie_schedule.id_movie = movie.id 
          JOIN room ON movie_schedule.id_room = room.id
          WHERE movie_schedule.date_begin <= '$current_date'
          AND movie_schedule.date_begin >= NOW() 
          ORDER BY movie_schedule.date_begin ASC";
$movies = mysqli_query($conn, $query);

// Rechercher les films par date
$search_date = '';
if (isset($_POST['search_date'])) {
    $search_date = $_POST['search_date'];
    $query = "SELECT movie_schedule.id_movie, movie_schedule.date_begin, movie.title, room.number 
              FROM movie_schedule 
              JOIN movie ON movie_schedule.id_movie = movie.id 
              JOIN room ON movie_schedule.id_room = room.id
              WHERE DATE(movie_schedule.date_begin) = '$search_date'
              ORDER BY movie_schedule.date_begin ASC";
    $movies = mysqli_query($conn, $query);
}
