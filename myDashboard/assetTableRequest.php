<?php

require_once('db_connector.php');

$sql = "";
$name = "";
$type = "";
$status = "";
$quant = "";

$errorMessage = "";
$successMessage = "";
$supFullName = "";


try {

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        
        do {

            $operation = $_POST["postType"];

            if($operation = "assign"){
                
                $numberOfAsset = $_POST["quantity"];
                $lab_id = $_POST["assignedLab"];
                $asset_id = $_POST["assetNameId"];
                $status = $_POST["status"];
                $sup_id = $_POST["supplierReq"];
                
                for ($i = 0; $i < $numberOfAsset; $i++) {


                    $sql = "INSERT INTO transaction_table (asset_id, lab_id, sup_id, asset_stat) VALUES ('$asset_id', '$lab_id', '$sup_id', 'New')";
                    $result = $connection->query($sql);

                }

            }



        } while (false);

    }

    $sqlAsset = "SELECT DISTINCT asset_type FROM assets";
    $resultAssets = $connection->query($sqlAsset);

    $sqlSupplier = "SELECT sup_id, CONCAT(sup_fname, ' ', sup_lname) as full_name FROM supplier";
    $resultSupplier = $connection->query($sqlSupplier);

    $sqlLaboratory = "SELECT lab_id, lab_name FROM laboratories";
    $resultLaboratory = $connection->query($sqlLaboratory);

    if(isset($_POST['delete'])) {
        $id = $_POST['delete'];
        
        $sql = "DELETE FROM assets WHERE asset_id = $id";
    
        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }
    
    }

    if(isset($_POST['status']) && isset($_POST['reqId'])) {
        $status = $_POST['status'];
        $id =  $_POST['reqId'];


        
        $sql = "UPDATE request_asset SET req_status = '$status' WHERE req_id = '$id'";

        if ($connection->query($sql) === TRUE) {
        } else {
            $connection->error;
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>


<?php

    include "templates/header.php";


?>

        <div class="content" id="content">
            <div class="topbar">
                <a href="" id="togglebtn"><ion-icon name="menu-outline"></ion-icon></a>
                <a class="logout"><ion-icon name="log-out-outline"></ion-icon></a>
            </div>
            <div class="display">
                <h2>REQUEST ASSETS</h2>
                
                    <div class="assetTableRequestDisplay">

                            <table class = "assetTableRequest" id = "assetTable">

                                <thead>
                                    <tr class = "requestAssetDisplayHeader">
                                        <th id = "reqAssetCol">ID</th>
                                        <th id = "reqAssetCol">NAME</th>
                                        <th id = "reqAssetCol">STATUS</th>
                                        <th id = "reqAssetCol">QUANTITY</th>
                                        <th id = "reqAssetCol">LABORATORY NAME</th>
                                        <th id = "reqAssetCol">REQUEST DATE</th>
                                        <!-- <th id = "actionEd">ACTIONS</th> -->
                                    </tr>
                                </thead>

                                <tbody  >

                            
                        
                                    <?php
                                    require_once('db_connector.php');


                                        $sql = "SELECT request_asset.req_id as req_id, request_asset.req_name as req_name, request_asset.req_status as req_status, request_asset.quantity_asset as quantity, request_asset.lab_id as lab_id, request_asset.req_date as req_date, laboratories.lab_name as labname FROM request_asset INNER JOIN laboratories ON request_asset.lab_id = laboratories.lab_id";
                                    
                                        $result = $connection->query($sql);

                                        if(!$result){
                                            die("Invalid query: ". $connection->error);
                                        }

                                        while($row = $result->fetch_assoc()){
                                            echo "
                                            <tbody  class = 'table-row'>
                                                <td class = 'reqTableRow' >$row[req_id]</td>
                                                <td class = 'reqTableRow' >$row[req_name]</td>
                                                <td class = 'reqTableRow'  class = 'reqTableRow' id = 'statusReqTable' >
                                                    <select data-id ='$row[req_id]' class='status-dropdown' id = 'statusReq'>
                                                        <option id = 'statusData' >$row[req_status]</option>
                                                        <option id = 'pendingStat' value = 'Pending'>Pending</option>
                                                        <option id = 'processingOption' value = 'Processing'>Processing</option>
                                                        <option id = 'cancelStat' value = 'Cancelled'>Cancelled</option>
                                                    </select>
                                                </td>
                                                <td class = 'reqTableRow' id = ''>$row[quantity]</td>
                                                <td class = 'reqTableRow' id = ''>$row[labname]</td>
                                                <td class = 'reqTableRow' id = ''>$row[req_date]</td>
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>

        let statusDs = document.getElementById("statusReq");
        let statusDisp = document.getElementById("statusData");
        let processDisp = document.getElementById("processingOption");
        let cancelDisp = document.getElementById("cancelStat");
        let pendingDisp = document.getElementById("pendingStat");

        

        document.addEventListener('DOMContentLoaded', function() {
            var tableRows = document.querySelectorAll('.editButtonAsset');
            var statSelect = document.querySelectorAll('.status-dropdown');
            var assignButton = document.querySelectorAll('.assignReq');
            let tableRowsAssign = document.querySelectorAll('.assignButtonLab');
            let allButtons = document.querySelectorAll("#editAssetButton, #deleteButton, #assignButtonLab, #addAsset");
            let operationDisplay = document.getElementById('postType');
            let nameAsset = document.getElementById("nameOfAssetReq");
            let quantityInput = document.getElementById("quantityField");
            let laboratory = document.getElementById("optionLabAsset");
            
            statSelect.forEach(function(statupdate) {
                statupdate.addEventListener('change', function () {
                    let reqStatus = document.getElementById("reqAssetStat");
                    
                    if (event.target.classList.contains('status-dropdown')){
                        var selectedValue = event.target.value;
                        // console.log(selectedValue);
                    }
                    
                        // console.log(selectedValue);
                    
                        let idReq = this.getAttribute('data-id');
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        // console.log(idReq);
                        xhr.send("status="+selectedValue+"&&reqId="+idReq);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    // console.log(xhr.responseText);
                                    // location.reload();
                                } else {
                                    console.error('There was a problem with the request.');
                                }
                            }
                        };
                });
            });
        });

        var sideBarToggle = true;

        togglebtn.addEventListener('click', (event) =>{
            event.preventDefault();

            if(sideBarToggle){
                sideBar.style.width = '8%';
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
    </script>
</body>
</html>