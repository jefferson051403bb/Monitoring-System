<?php
require_once('db_connector.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sqlLab = "SELECT COUNT(*) as name  FROM laboratories";
$sqlAsset = "SELECT COUNT(*) as name  FROM assets";
$sqlSupp = "SELECT COUNT(*) as fname  FROM supplier";

$result = $connection->query($sqlLab);
$resultAsset = $connection->query($sqlAsset);
$resultSupp = $connection->query($sqlSupp);

if ($result) {
    $row = $result->fetch_assoc();
    $totalCountLab = $row['name'];
} else {
    echo "Error: " . $sqlLab . "<br>" . $connection->error;
}
if ($resultAsset) {
    $row = $resultAsset->fetch_assoc();
    $totalCountAsset = $row['name'];
} else {
    echo "Error: " . $sqlAsset . "<br>" . $connection->error;
}
if ($resultSupp) {
    $row = $resultSupp->fetch_assoc();
    $totalCountSupplier = $row['fname'];
} else {
    echo "Error: " . $sqlSupp . "<br>" . $connection->error;
}

$connection->close();
?>

<?php 

    include "templates/header.php";

?>

        <div class="content" id="content">
            <div class="topbar">
                <a href="" id="togglebtn"><ion-icon name="menu-outline"></ion-icon></a>
                <a  href="http://localhost/asset/AssetTracking/index.php" class="logout"><ion-icon name="log-out-outline"></ion-icon></a>
            </div>
            <div class="display">

                <div class = "threeMainContainer">

                    <div class = "totalLaboratoryDisplay">
                        <h4>TOTAL LABORATORY</h4>
                        <div class = "countDisplay">
                            <h1><?php echo $totalCountLab; ?></h1>
                        </div>
                    </div>
                    <div class = "totalAssetDisplay">
                        <h4>TOTAL ASSET</h4>
                        <div class = "countDisplay">
                            <h1><?php echo $totalCountAsset; ?></h1>
                        </div>
                    </div>
                    <div class = "totalSupplierDisplay">
                        <h4>TOTAL SUPPLIER</h4>
                        <div class = "countDisplay">
                            <h1><?php echo $totalCountSupplier  ; ?></h1>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>

        var sideBarToggle = true;

        togglebtn.addEventListener('click', (event) =>{
            event.preventDefault();

            if(sideBarToggle){
                sideBar.style.width = '100px';
                title.style.display = 'none';
                content.style.width = '95%';
                sideBar.style.transition = '.5s';
                menu_list.style.marginTop = "193px";


                menuIcons = document.getElementsByClassName('text');
                for(var i =0; i<menuIcons.length; i++){
                    menuIcons[i].style.display = 'none';
                }
                sideBarToggle = false;
            }else{
                sideBar.style.width = '15%';
                title.style.display = 'block';
                content.style.width = '85%';
                menu_list.style.marginTop = "40px";

                menuIcons = document.getElementsByClassName('text');
                for(let i =0; i<menuIcons.length; i++){
                    menuIcons[i].style.display = 'inline-block';
                }
                sideBarToggle = true; 
            }
            
        });0
        const links = document.querySelectorAll("#myLinks");


        links.forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                window.location.href = link;
            });
        });
    </script>
</body>
</html>