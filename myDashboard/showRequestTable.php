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
                <div id="popupFormAssetReq" class="popup-formAssetReq">
                        
                        <h2 id = "titleOfFormReq">Assign Request Asset</h2><br>
                    
                    <div class = "reqFormContainer">
                                
                        <form action="" method = "post" id = "myFormAsset">

                        <input type="text" name = "postType" id = "postType">
                            <div class = "idDisplayDiv" id = "idDisplayDiv">
                                <label class = "col-sm-3 col-form-label">ID</label>
                                <div class = "col-sm-6">
                                    <input type="text" id = "assetId"  name = "IdAsset" value = "<?php echo $asset_id; ?>">
                                </div>
                            </div>
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Available Asset:</label>
                                <div class = "col-sm-6">
                                    <select name="assetNameId" id="nameOfAssetReqs">
                                        <?php
                                            if ($resultAssets->num_rows > 0) {
                                                while ($row = $resultAssets->fetch_assoc()) {
                                                    echo "
                                                    
                                                    <option value='" . $row['asset_id'] . "'>" . $row['asset_type'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No options available</option>";
                                            }
                                        ?>
                                        </select>
                                </div>
                            </div>
                           
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Quantity</label>
                                <div class = "col-sm-6">
                                    <input type = "button" id = "addQuant" value = "+">
                                    <input type="text" name = "quantity" id = "quantityField">
                                    <input type = "button"id = "minusQuant" value = "-">
                                </div>
                            </div>
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Status</label>
                                <div class = "col-sm-6">
                                <select id="optionsAssets" name = "status">
                                            <option >Done</option>
                                            <option >Pending</option>
                                    </select>
                                </div>
                            </div>

                                    <div id = "assignedLabReq" class = "assignedLabReq">
                                        <label for="options">Assign to:</label>
                                        <select name="assignedLab" id="optionLabAsset">
                                        <?php
                                            if ($resultLaboratory->num_rows > 0) {
                                                while ($row = $resultLaboratory->fetch_assoc()) {
                                                    echo "
                                                    
                                                    <option value='" . $row['lab_id'] . "'>" . $row['lab_name'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No options available</option>";
                                            }
                                        ?>
                                        </select><br><br>
                                        <div class = "supplierOptionReq"><label for="options">Select an Supplier:</label>
                                            <select name="supplierReq" id="optionsSupAssetReq" value = "<?php echo $sup_id; ?>">
                                            <?php
                                                // Check if there are results in the query
                                                if ($resultSupplier->num_rows > 0) {
                                                    // Output data of each row
                                                    while ($row = $resultSupplier->fetch_assoc()) {
                                                        echo "<option value='" . $row['sup_id'] . "'>" . $row['full_name'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No options available</option>";
                                                }
                                            ?>
                                            </select><br>

                                    </div>
                            <?php

                            if(!empty($successMessage)){
                            echo"

                                <div class = 'alert alert - warning alert-dismissible fade show ' role = 'alert'>

                                    <strong>$successMessage</strong>
                                    <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>

                                </div>

                            ";
                            }
                                

                            ?> 
                            </div>
                                        
                           
                            

                        <div class = "buttonForm">

                            <button type = "submit" id = "submitAssetBtn">Submit</button>

                            <button id = "cancelSupAsset"onclick = "cancelSup()">Cancel</button>
                            
                        </div>
                            


                        </form>
                                
                            </div>
                    </div>
                
                    <div class="assetTableDisplay">
                        
                        <table class = "stocksAssetDisplay" id = "assetTable">

                            <thead>
                                <tr>
                                    <th id = "actionEd">ID</th>
                                    <th id = "actionEd">NAME</th>
                                    <th id = "actionEd">STATUS</th>
                                    <th id = "actionEd">QUANTITY</th>
                                    <th id = "actionEd">LABORATORY NAME</th>
                                    <th id = "actionEd">REQUEST DATE</th>
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
                                            <td  id = 'laboratoryRow'>$row[req_id]</td>
                                            <td id = 'laboratoryRow' >$row[req_name]</td>
                                            <td  id = 'laboratoryRow'>
                                           
                                                <select  data-id ='$row[req_id]' class='status-dropdown' id='reqAssetStat'>
                                                   <option >$row[req_status]</option>
                                                   <option value = 'Pending'>Pending</option>
                                                   <option value = 'Processing'>Processing</option>
                                                   <option value = 'Cancelled'>Cancelled</option>
                                                </select>
                                           
                                            </td>
                                            <td  id = 'laboratoryRow'>$row[quantity]</td>
                                            <td  id = 'laboratoryRow'>$row[labname]</td>
                                            <td  id = 'laboratoryRow'>$row[req_date]</td>
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

        
        nameOfAssetReqs.addEventListener("change" , function(){
            let change = document.getElementById("nameOfAssetReqs").value;

            console.log(change + "hello");
        });


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
            
            
           
            assignButton.forEach(function(rowUpdate) {
                rowUpdate.addEventListener('click', function () {
                    let assetName = this.getAttribute('data-reqname');
                    let assetType = this.getAttribute('data-assetType');
                    let assetQuant = this.getAttribute('data-requant');
                    let assetSup = this.getAttribute('data-supId');
                    let assetStat = this.getAttribute('data-assetStat');
                    let lab_id = this.getAttribute('data-labId');
                    popupFormAssetReq.style.display = 'block';
                    nameAsset.value = assetName; 
                    nameAsset.style.cursor = "not-allowed";
                    nameAsset.style.pointerEvents = "none";
                    nameAsset.style.border = "none";
                    quantityInput.value = assetQuant;
                    laboratory.value  = lab_id;
                    laboratory.style.cursor = "not-allowed";
                    laboratory.style.pointerEvents = "none";
                    laboratory.style.border = "none";
                    operationDisplay.value = "assign";
                });
            });
            statSelect.forEach(function(statupdate) {
                statupdate.addEventListener('change', function () {
                    if (event.target.classList.contains('status-dropdown')){
                        var selectedValue = event.target.value;
                        console.log(selectedValue);
                    }
                        let idReq = this.getAttribute('data-id');
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        console.log(idReq);
                        xhr.send("status="+selectedValue+"&&reqId="+idReq);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    // console.log(xhr.responseText);
                                    location.reload();
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

       

        
        function cancelSup(){
            let operation = document.getElementById("postType");
            operation.value = "";
            popupFormAsset.style.display = "none";
        }

        
        const addButton = document.getElementById('addAsset');
        const popupForm = document.getElementById('popupFormAsset');

        addQuant.addEventListener('click', function() {
            let valueQuant = document.getElementById("quantityField").value;

            valueQuant++;

            quantityField.value = valueQuant;
            
        });
        
        minusQuant.addEventListener('click', function() {
            let valueQuant = document.getElementById("quantityField").value;

            valueQuant--;

            quantityField.value = valueQuant;
            
        });

        document.getElementById('myFormAsset').addEventListener('submit', function(event) {
        const formData = new FormData(event.target);
        for (const pair of formData.entries()) {
            console.log(`${pair[0]}: ${pair[1]}`);
        }
        // After handling form data, you can hide the form
            popupForm.style.display = 'none';
        });

    </script>
</body>
</html>