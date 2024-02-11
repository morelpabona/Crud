
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>New Paint Job</title>
</head>

<style>
       
    </style>
<body>
    <div class="container">
        <h1>New Paint Job</h1>

        <div class="car-img">
            <p class = "displayCar" ></p> 
            <p class = "displayCar1" ></p> 
        </div>
    
        
        <form action="newpaint.php" method="POST">

            <label class="cardetails" for="carDetails">Car Details</label><br><br>

                <label for="plateNo">Plate No.</label> 
                <input type="text" class="plateno" name="plateno" placeholder="" required><br><br>

                <label for="currentcolor">Current Color</label>
                    <select id="" class="mySelect" name="current" required onchange="updateColor2()">
                        <img src="./img/default.png " alt="" class = "display-none">
                        <option value="default">default</option>
                        <option value="red">Red</option>
                        <option value="green">Green</option>
                        <option value="blue">Blue</option>
                    </select> <br><br>

                <label for="targetColor">Target Color</label>
                    <select id="" class="mySelect1"  name="target" required  onclick="updateColor1()">
                        <option value="" selected disabled>choose color</option>
                        <option value="red">Red</option>
                        <option value="green">Green</option>
                        <option value="blue">Blue</option>>
                    </select><br><br>

            <button class = "submit" type="submit">Submit</button>
        </form>

     
    </div>
  
</body>

<script src="valens.js"> </script>

</html>
