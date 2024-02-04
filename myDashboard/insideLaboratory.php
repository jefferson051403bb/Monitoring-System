<?php
require_once('db_connector.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$labId = $_GET["id"];

$sqlAsset = "SELECT COUNT(*) as total  FROM transaction_table WHERE lab_id = '$labId'";
$sqlBroken = "SELECT COUNT(asset_stat) as asset_status  FROM transaction_table WHERE asset_stat = 'broken' AND lab_id = '$labId'";

$sqlReq = "SELECT COUNT(lab_id) as req_id FROM request_asset WHERE lab_id = '$labId'";

$result = $connection->query($sqlAsset);
$resultBroken = $connection->query($sqlBroken);
$resultRequest = $connection->query($sqlReq);

if ($result) {
    $row = $result->fetch_assoc();
    $totalCountAsset = $row['total'];
} 
if ($resultBroken) {
    $row = $resultBroken->fetch_assoc();
    $totalCountBroken = $row['asset_status'];
} 
if ($resultRequest) {
    $row = $resultRequest->fetch_assoc();
    $totalCountReq = $row['req_id'];
} 

?>
<?php 

    include "templates/header.php";

?>
        <div class="content" id="content">
            <div class="topbar">
                <a href="" id="togglebtn"><ion-icon name="menu-outline"></ion-icon></a>
                <a  href="http://localhost/asset/AssetTracking/index.php" class="logout"><ion-icon name="log-out-outline"></ion-icon></a>
            </div>
            <div class="displayAss">
<!-- 
                <button id = "viewAssetInLab">VIEW ASSETS</button> -->
               
                <div class = "insideLabDisplayTotal">
                    <div class = "totalAssetInside">TOTAL ASSET
                        <h5><?php echo $totalCountAsset; ?></h5>
                    </div>
                    <div class = "totalBrokenInside">TOTAL BROKEN
                        <h5><?php echo $totalCountBroken; ?></h5>
                    </div>
                    <div class = "requestedAsset">REQUESTED ASSET
                        <h5><?php echo $totalCountReq; ?></h5>
                    </div>
                </div>

                <div class = "tableDisplay">

                    <div class = "tableAssetDisplay">
                        <h3 id = "insListOfAsset">LIST OF ASSETS</h3>
                        <table class = "displayAssetIns" >

                            <thead >
                                <tr>
                                    <th id = "insAsset">ID</th>
                                    <th id = "insAsset">DEVICE TYPE</th>
                                    <th id = "insAsset">BRAND</th>
                                    <th id = "insAsset">STATUS</th>
                                </tr>
                            </thead>

                            <tbody  >

                                <?php
                                require_once('db_connector.php');
                                $labId = $_GET["id"];

                                    $sqlTrans = "SELECT transaction_table.trans_id as trans_id, assets.asset_type as asset_type, assets.asset_brand as asset_brand, assets.asset_status as asset_status, assets.asset_desc as asset_desc FROM transaction_table INNER JOIN assets on transaction_table.asset_id = assets.asset_id WHERE transaction_table.lab_id = '$labId'";
                                    $result = $connection->query($sqlTrans);

                                    if(!$result){
                                        die("Invalid query: ". $connection->error);
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "
                                        <tbody>
                                            <td    id = 'laboratoryRowAss'>$row[trans_id]</td>
                                            <td id = 'laboratoryRowAss' style = 'padding-left = 400px;'>$row[asset_type]</td>
                                            <td  id = 'laboratoryRowAss'>$row[asset_brand]</td>
                                            <td id = 'laboratoryRowAss'>$row[asset_status]</td>
                                        ";
                                        echo '</tr>';
                                    }
                                ?>

                            </tbody>

                        </table>
                        
                    </div>
                        <button id = "viewAllBtnIns" >VIEW ALL</button>
                    <div class = "logsTable">
                        <h3 id = "recentlyTitleIns">RECENTLY ASSET ADDED</h3>
                        <table class = "displayAssetIns" >

                            <thead >
                                <tr>
                                    <th id = "insAssetd">DEVICE TYPE</th>
                                    <th id = "insAsset">BRAND</th>
                                    <th id = "insAsset">STATUS</th>
                                    <th id = "insAsset">DATE</th>
                                </tr>
                            </thead>

                            <tbody  >

                            <?php
                                require_once('db_connector.php');
                                $labId = $_GET["id"];

                                    $sqlTrans = "SELECT transaction_table.trans_id as trans_id, assets.asset_type as asset_type, assets.asset_brand as asset_brand, assets.asset_status as asset_status, assets.asset_desc as asset_desc, transaction_table.trans_date as trans_date FROM transaction_table INNER JOIN assets on transaction_table.asset_id = assets.asset_id WHERE transaction_table.lab_id = '$labId' ORDER BY trans_date DESC";
                                    $result = $connection->query($sqlTrans);

                                    if(!$result){
                                        die("Invalid query: ". $connection->error);
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "
                                        <tbody>
                                            <td    id = 'laboratoryRowAss'>$row[asset_type]</td>
                                            <td id = 'laboratoryRowAss' style = 'padding-left = 400px;'>$row[asset_brand]</td>
                                            <td  id = 'laboratoryRowAss'>$row[asset_status]</td>
                                            <td id = 'laboratoryRowAss'>$row[trans_date]</td>
                                        ";
                                        echo '</tr>';
                                    }
                                ?>

                            </tbody>

                        </table>
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
                sideBar.style.transition = '1s';
                menu_list.style.marginTop = "193px";


                menuIcons = document.getElementsByClassName('textLink');
                for(var i =0; i<menuIcons.length; i++){
                    menuIcons[i].style.display = 'none';
                }
                sideBarToggle = false;
            }else{
                sideBar.style.width = '15%';
                title.style.display = 'block';
                content.style.width = '85%';
                menu_list.style.marginTop = "40px";

                menuIcons = document.getElementsByClassName('textLink');
                for(let i =0; i<menuIcons.length; i++){
                    menuIcons[i].style.display = 'block';
                }
                sideBarToggle = true; 
            }
            
        });

        document.addEventListener('DOMContentLoaded', function() {
            var urlParams = new URLSearchParams(window.location.search);
            
            var laboratoryId = urlParams.get('id');
            var laboratoryName = urlParams.get('name');
            var adminFName = urlParams.get('adminFname');
            var adminLName = urlParams.get('adminLname');
    });

     
    function cancelSupBut(){
            popupFormAsset.style.display = "none";
        }

        const viewBtn = document.getElementById('viewAllBtnIns');
        const popupForm = document.getElementById('popupFormAsset');

        viewBtn.addEventListener('click', function() {

            <?php
                $id = $_GET["id"];
                $name = $_GET["name"];
            ?>
            window.location.href = 'http://localhost/asset/myDashboard/viewInsideLaboratory.php?id=' + <?php echo"$id" ?> ;
        });

        // document.getElementById('myForm').addEventListener('submit', function(event) {
        // const formData = new FormData(event.target);
        // for (const pair of formData.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }
        // // After handling form data, you can hide the form
        // popupForm.style.display = 'none';
        // });
    </script>
</body>
</html>