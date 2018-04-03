<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
        <link rel="stylesheet" type="text/css" href="vendors/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/nav-menu.css">
        <link rel="stylesheet" type="text/css" href="picture-container/picture-container.css">
        <link rel="stylesheet" type="text/css" href="css/queries.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet">
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        <script src="vendors/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/bootstrap/js/bootpopup.min.js"></script>

<title>registration document</title>
</head>

<body>
    <header>
        <templateHtml src="picture-container/picture-container.html"></templateHtml>
        <?php include "nav-menu/nav-menu-container.php" ?>
     </header>

<!-- kid section -->
<section id="kid-detailsUpdate">
    <form>
        <h2> Kid </h2>
        <p class="describe-info"> Please fill in your child details: </p>
        <p class="success-message2"></p>
            <div class="row kid-form1">
                 <div class="col span-1-of-3 box">
                    <div class="registration-info">
                        <label  for="name"> <span> * </span>  First name: </label> <br>
                        <input name="fname" type="name" id="name"/>
                    </div>
                </div>
                 <div class="col span-1-of-3 box">
                     <div class="registration-info">
                        <label for="id"> <span> * </span> ID: </label> <br>
                        <input name="kidId" type="text" id="kid-id">
                     </div>
                </div>
                <div class="col span-1-of-3 box">
                    <div class="registration-info">
                        <label for="data"> <span> * </span> Birth date: </label>
                        <input name="bDate" type="date" id="birth-date">
                    </div>
                </div> 
           </div>
           <div class="row kid-form2">
                   <div class="col span-1-of-1 box">
                        <div class="registration-info">
                            <label> <span> * </span> Gender: </label>
                            <select name="genders" size="1" id="gender"> 
                                <option value="boy" selected> Boy  </option>
                                <option value="Girl"> Girl </option>
                            </select>
                        </div>
                   </div>
           </div>

           <div class="row kid-form3">
                <div class="col span-1-of-4 box">
                    <div class="registration-info">
                        <label for="name"> Allergies: </label>   
                        <p> <input type="checkbox" name="celiac"> Celiac </p>
                    </div>
                </div>
                <div class="col span-1-of-4 box">
                    <div class="registration-info">
                        <p class="allergie-info"> <input type="checkbox" name="eggs"> Eggs </p>                  
                    </div>
                </div>
                <div class="col span-1-of-4 box">
                    <div class="registration-info">
                        <p class="allergie-info"> <input type="checkbox" name="fish"> Fish </p>                  
                    </div>
                </div>
                <div class="col span-1-of-4 box">
                    <div class="registration-info">
                        <p class="allergie-info"> <input type="checkbox" name="kiwis"> Kiwis </p>                  
                    </div>
                </div>
           </div>
           <div class="row kid-form3">
                <div class="col span-1-of-4 box"> 
                     <div class="registration-info"> 
                        <p> <input type="checkbox" name="lactoseintolerance"> Lactose intolerance </p>                  
                     </div>
                </div>
           <div class="col span-1-of-4 box">
                    <div class="registration-info">
                        <p> <input type="checkbox" name="nuts"> Nuts </p>
                    </div>
           </div>
           <div class="col span-1-of-4 box">
                    <div class="registration-info">   
                         <p> <input type="checkbox" name="soy"> Soy </p>                  
                    </div>
           </div>
           <div class="col span-1-of-4 box">
                    <div class="registration-info"> 
                        <p> <input type="checkbox" name="strawberries"> Strawberries </p>                  
                    </div>
           </div>
           </div>
           <div class="row kid-form3">
                <div class="col span-1-of-3 box">
                    <div class="registration-info">
                        <label for="food"> Food Preference: </label>   
                        <p> <input type="radio" name="vegan"> Vegan </p>                  
                    </div>
                </div>
                <div class="col span-1-of-3 box">
                    <div class="registration-info">
                        <label for="food"> </label>   
                        <p class="food-pref"> <input type="radio" name="vegetarian"> Vegetarian </p>                  
                    </div>
                </div>
           </div>
           <div class="row kid-form4">
                <div class="col span-1-of-2 box">
                     <div class="registration-info">
                        <label>  Comments and Special Requests </label>
                        <textarea name="comments" cols="42" rows="4" style="overflow:auto;resize:none"> </textarea>
                </div>
                </div>
            </div>

            <!-- <button type="button" class="save-2" onClick="kidDetailsUpdate()"> Save</button> -->
            <button type="button" id="New-observation"> To Insert New observation Please Click Here </button>   

     </form>  
</section>
    <script src="commons.js"></script>
    <script src="main.js"></script>
</body>

</html>