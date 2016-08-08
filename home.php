<?php
setcookie( "Remember"
    , ""
    , time() + 60*60
    , "/students"
    , "farthing.ex.ac.uk"
    , false
    , true );
if ( isset( $_COOKIE[ 'TestCookie' ] ) ) {
    echo "Welcome back!";
} else {
    echo "Hello stranger!";
}
include('connect.php');
include_once('header.php');

function display_cities()
{
    global $connection;

    try
    {
        $query = $connection->query("SELECT * FROM hl_cities");
        $cities = $query->fetchAll();
        return $cities;
    }
    catch (Exception $e)
    {
        return false;
    }
}
$cities = display_cities();


if($cities){

  //  require_once('lib/php_self.php');
  //  $callback = https_php_self();

   ?>

    <h2>Place</h2>

    <form method="post" action="<?=$_SERVER['PHP_SELF'];?>" id="city" name="city">
        <div>
            <select  name="cities" id="cities" required>
                <option value="0">Choose a city</option>
                <?php foreach($cities as $city){ ?>
                    <option value='<?php echo $city["city_id"]; ?>'><?php echo $city["city_name"]; ?></option>
                <?php } ?>
            </select>

            <select  name="rooms" id="rooms" required>
                <option value="0">Room(s)</option>

                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6+</option>

            </select>


        </div>
        <input type="submit" value="Submit" />

    </form>


<?php
}
if  (isset($_POST['cities']))
{
    function get_hotel()
    {
        global $connection;

        try
        {
            $query = $connection->query("SELECT * FROM hl_hotel
                                        WHERE hl_cities_cities_id ='" . $_POST["cities"] . "'
                                        and hotel_rooms >= '" . $_POST["rooms"] . "'");
            $hotels = $query->fetchAll();
            return $hotels;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    $hotels = get_hotel($_POST);

    echo "<h2>Place</h2>";

    foreach($hotels as $hotel){

        echo "<p>";
        echo "Hotel: <a href='booking.php?id=".$hotel["hotel_id"]."'>" .$hotel['hotel_name']."</a>";
        echo "<br/>";
        echo "Address : " .$hotel['hotel_address'];
        echo "<br/>";
        echo "Zip : " .$hotel['hotel_zip'];
        echo "<br/>";
        echo "<a href='booking.php?id=".$hotel["hotel_id"]."'>Select this hotel</a>";
        echo "</p>";
    }
}



?>


    <?php include_once('footer.php');
