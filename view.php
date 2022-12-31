<html>
<head>
    <title>Nhóm 3</title>
    <meta http-equiv="refresh" content="1"> 
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            height: 100%;
            margin: 0;

        }
        .row{
            height: 100%;
        }
        .badge-dark {
            color: #fff;
            background-color: #343a40;
            width: 100%;
            font-size: 30px;
        }
        i.fa-temperature-high{
            font-size:45px;
        }
        img{
            width:100%;
            height:470px;
        }
        td{
            font-size:20px;
            font-weight:bold;
        }
       
  </style>
</head>
<body>
    <div class="container">
    <?php
        $host = "localhost";  // host = localhost because database hosted on the same server where PHP files are hosted
        $dbname = "demo";  // Database name
        $username = "root";  // Database username
        $password = ""; // Database password
        // Establish connection to MySQL database
        $conn = new mysqli($host, $username, $password, $dbname);
        // Check if connection established successfully
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Query the single latest entry from the database. -> SELECT * FROM table_name ORDER BY col_name DESC LIMIT 1
        $sql = "SELECT * FROM logs ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //Will come handy if we later want to fetch multiple rows from the table
            while($row = $result->fetch_assoc()) { //fetch_assoc fetches a row from the result of our query iteratively for every row in our result.
                //Returning HTML from the server to show on the webpage.
                echo '<div class="alert alert-info text-center" role="alert">
                    Nhóm 3: Phạm Bảo Việt, Trần Tuấn Thanh, Ngô Đăng Thành
                    <br> GVHD: Nguyễn Hữu Khương
                </div>';
               
                    echo  '<span class="badge badge-dark ">';

                    try {
                        date_default_timezone_set("Asia/Bangkok");
                        $date = new DateTime();
                        echo  $date->format('d-m-Y H:i:s'); // Change format as needed

                        
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        exit(1);
                    }
                    echo '</span>';
                echo '
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col"><span class="badge badge-secondary">Temperature</span></th>
                            <th scope="col"><span class="badge badge-secondary">Humidity</span></th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>'.(($row["NhietDo"]>30)?'<i class="fa-solid fa-temperature-high"></i>':'<i class="fa-solid fa-temperature-low"></i>').''.$row["NhietDo"].' &#8451 </td>
                            <td><i class="fa-solid fa-temperature-high"></i> '.$row["DoAm"].' <i class="fa-solid fa-percent"></i> </td>
                        
                            </tr>
                            <tr>    
                        </tbody>
                    </table>

                ';
                echo '<img src="https://i.pinimg.com/originals/0e/f3/bb/0ef3bb66d9216fffcea9022628f7bb26.gif" alt="Girl in a jacket" width="500" height="600">';

                    
              
            }
        } else {
            echo "0 results";

        }
    ?>
</div>
    </div>

</body>
</html"