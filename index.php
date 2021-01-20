<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movie</title>
    
    <meta charset="UTF-8">
    <meta name="description" content="Movie Recommendation System">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <!-- Nav1 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0v6h8V1H4zm8 8H4v6h8V9zM1 1v2h2V1H1zm2 3H1v2h2V4zM1 7v2h2V7H1zm2 3H1v2h2v-2zm-2 3v2h2v-2H1zM15 1h-2v2h2V1zm-2 3v2h2V4h-2zm2 3h-2v2h2V7zm-2 3v2h2v-2h-2zm2 3h-2v2h2v-2z"/>
            </svg>
            <span style="margin-left:5px;">MRS</span>
        </a>
    </nav>

    <!-- Nav2 + Search Bar-->
    <div class="container-fluid">
	    <!-- Nav2 -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">HOME<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FILMS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">TV-SHOWS</a>
                </li>
                </ul>
            </div>
        </nav>
        <br/>
    
        <!-- Search Bar  -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form action="movie.php" method="post" class="card card-sm">
                    <div class="card-body row no-gutters align-items-center">
                        <div class="col">
                            <input class="form-control form-control-lg form-control-borderless" type="text" name="search" placeholder="Search topics or keywords">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-lg btn-success" type="submit" name="submit" onclick="myFunction()"><i class="fas fa-search"></i>Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Slider  -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="container">
                <!-- Full-width images with number text -->
                   
                    <?php

                    if(isset($_SESSION['yourData'])){
                        
                        echo "<div class="."'"."alert alert-success"."'"."role="."'"."alert"."'".">" . "Résultats pour votre recherche: " . "<i><u>". "'" . $_SESSION['yourSearch'] . "'" ."</u></i>"  . "</div>";

                        $x = 0;
                        foreach($_SESSION['yourData'] as $k => $v){
                            // Box slider
                            $x++;

                            echo "<div class="."mySlides".">";
                            echo "<div class="."numbertext".">" . $x . "/10"."</div>";
                            echo "<div class="."flex-container".">";
                            echo "<div class="."fcol".">";
                            echo "<div class="."innerflex".">";
                            echo "<div class="."inner-01".">";
                            echo "<img src=". "'" . "img/".$v["pair_id"].".jpg". "'" .">";
                            echo "</div>";
                            echo "<div class="."inner-02".">";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class="."scol".">";
                            echo "<div class="."innerflex".">";
                            echo "<div class="."inner-desc-01".">";
                            echo "<h4>". $v["title"] . " " . $v["year"] . "</h4>";
                            echo "<p class=". "desc" .">". $v["certificate"] . " | " . $v["runtime"] . " | " . $v["genre"] . "</p>";
                            echo "</div>";
                            echo "<hr class=" . "style" . ">";
                            echo "<div class="."inner-desc-02".">";
                            echo "<p class=" . "rating" . ">" . "<b> IMDB Rating:</b> " . "<span><i>" .$v["rating"] . "</i></span>" . "/10" . " - " . "<b>Metascore:</b> " . "<span><i>" .$v["metascore"] . "</i></span>" . "/100" . "</p>";
                            echo "</div>";
                            echo "<div class="."inner-desc-03".">";
                            echo "<p><b>Summary:</b> </p>";
                            echo "<p class=" . "plot" .">" . $v["plot"] . "<a> Read more</a>" ."</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            session_destroy();
                        }

                        echo "<a class=" . "'" . "prev" . "'" .  "onclick=" . "'" . "plusSlides(-1)" . "'" . ">&#10094;</a>";
                        echo " <a class=" . "'" . "next" . "'" . "onclick=" . "'" . "plusSlides(1)" . "'" . ">&#10095;</a>";  

                        echo "<div class=" . "caption-container" . ">";    
                        echo "<p id=" . "caption" . "></p>";
                        echo "</div>";
                            
                        echo "<div class=" . "row_container" . ">";
                        $y = 0;

                        foreach($_SESSION['yourData'] as $k => $v){

                            echo "<div class="."row".">";
                            echo "<div class="."column".">";
                            $y++;
                            echo "<img class=" . "'" . "demo" . "'" . "src=" . "'" . "img/" . $v["pair_id"] . ".jpg" .
                            "'" . "style=" . "'" . "width:100%" . "'" . "onclick=" . "'" .
                            "currentSlide(" . $y . ")" . "'" .  "alt=" . "'" . ($v["value"] * 100) . "'" .">";
                            echo "</div>";
                            echo "</div>";

                            session_destroy();
                        }
                        echo "</div>";

                        
                    }
                    else{
                        echo "<div class="."'"."alert alert-primary"."'"."role="."'"."alert"."'"."> Vous ne savez pas par où commencer? Saisissez le nom du film, par exemple: " . "'" . "<i>tenet</i>" . "'" . "</div>";
                        session_destroy();
                    }
                    ?>
                    <div id="loader"></div>
                </div>           
            </div>
        </div>
    </div>
</div>

<footer>
         <div class="row my-5 justify-content-center py-5">
             <div class="col-11">
                 <div class="row ">
                     <div class="col-xl-8 col-md-4 col-sm-4 col-12 my-auto mx-auto a">
                         <h3 class="text-muted mb-md-0 mb-5 bold-text">MRS.</h3>
                         <p>Movie Recommendation System</p>
                     </div>
                     <div class="col-xl-2 col-md-4 col-sm-4 col-12">
                         <h6 class="mb-3 mb-lg-4 text-muted bold-text mt-sm-0 mt-5 "><b>MENU</b></h6>
                         <ul class="list-unstyled">
                             <li>HOME</li>
                             <li>FILMS</li>
                             <li>TV-SHOWs</li>
                         </ul>
                     </div>
                     <div class="col-xl-2 col-md-4 col-sm-4 col-12">
                         <h6 class="mb-3 mb-lg-4 text-muted bold-text mt-sm-0 mt-5"><b>ADDRESS</b></h6>
                         <p class="mb-1"><b>UNIVERSITÉ DE LILLE</b></p>
                         <p>Cité Scientifique, 59650 Villeneuve-d'Ascq</p>
                     </div>
                 </div>
                 <div class="row ">
                     <div class="col-xl-8 col-md-4 col-sm-4 col-auto my-md-0 mt-5 order-sm-1 order-3 align-self-end">
                        <p class="social text-muted mb-0 pb-0 bold-text">
                            <span class="mx-2">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </span>
                            <span class="mx-2">
                                <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                            </span>
                            <span class="mx-2">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </span>
                            <span class="mx-2">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </span>
                        </p><small class="rights"><span>&#174;</span> MRS All Rights Reserved.</small>
                     </div>
                     <div class="col-xl-4 col-md-6 col-sm-6 col-auto order-1 align-self-end ">
                         <h6 class="mt-55 mt-2 text-muted bold-text"><b>Manh Hung DOAN</b></h6><small> <span><i class="fa fa-envelope" aria-hidden="true"></i></span> manhhung.doan.etu@univ-lille.fr</small>
                     </div>
                 </div>
             </div>
         </div>
     </footer>

<!-- <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
    showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
    showSlides(slideIndex = n);
    }

    function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var caps = document.getElementById("caption");

    // var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
        // caps[i].style.display = "none";
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    caps.innerHTML = dots[slideIndex-1].alt;
    }
</script> -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="javascript/javascript.js"></script>
</body>
</html>

    



