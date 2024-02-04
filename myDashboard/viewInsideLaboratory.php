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
$asset_id = "";

try {

    
$operation = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        
        $operation = $_POST["postTypeView"];

            if($operation == "Add"){
                $name = $_POST["nameReq"];
                $quant = $_POST["quantity"];
                $currentDateTime = date("M-d-Y");
                $lab_id = $_GET["id"];
                $status = "Pending";

                $sql = "INSERT INTO request_asset (req_name, req_status, quantity_asset, lab_id, req_date) VALUES ('$name' , '$status','$quant', '$lab_id ', '$currentDateTime')";
                $result = $connection->query($sql);
            }

            if($operation == "update"){

                $asset_stat = $_POST["status"];
                $trans_id = $_POST["IdAssetView"];
               
                $sqlUpdateAsset = "UPDATE transaction_table SET asset_stat = '$asset_stat' WHERE trans_id = '$trans_id'";

                if ($connection->query($sqlUpdateAsset) === TRUE) {
                } else {
                    $connection->error;
                }

            }
        }

        

        $name = "";
        $quant = "";
        $currentDateTime = "";
        $lab_id = "";
        $operation = "";


} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$sqlAsset = "SELECT asset_id, asset_type FROM assets";
$resultAsset = $connection->query($sqlAsset);
        
if(isset($_POST['status']) && isset($_POST['reqId'])) {
    $status = $_POST['status'];
    $id =  $_POST['reqId'];


    
    $sql = "UPDATE transaction_table SET asset_stat = '$status' WHERE trans_id = '$id'";

    if ($connection->query($sql) === TRUE) {
    } else {
        $connection->error;
    }
}

if(isset($_POST['statusReq']) && isset($_POST['reqId'])) {
    $status = $_POST['statusReq'];
    $id =  $_POST['reqId'];


    
    $sql = "UPDATE request_asset SET req_status = '$status' WHERE req_id = '$id'";

    if ($connection->query($sql) === TRUE) {
    } else {
        $connection->error;
    }
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
            <div class="display">
                <div class = "laboratoryName">
                    <h1 id = "insidelaboratoryName"></h1>
                    
                    <h3>LIST OF ASSET</h3>
                </div><br><br>
                <button id = "requestBtn">REQUEST ASSETS</button>
                <button id = "requestBtnAssView">SHOW ASSET REQUEST</button>
               
                <div class="insideLabTable">

                <div id="popupFormViewLab" class="popup-formViewLab">
                    
                    <div class = "suppFormContainer">
                        
                        <h2 id = "titleOfFormReq">Request Asset Form</h2><br>
                                
                        <form method = "post" id = "myFormAssetView">

                        <input type="text" name = "postTypeView" id = "postTypeView" value = "<?php echo $operation; ?>">
                            <div class = "idDisplayDivView" id = "idDisplayDivView">
                                <label class = "col-sm-3 col-form-label">ID</label>
                                <div class = "col-sm-6">
                                    <input type="text" id = "assetIdView"  name = "IdAssetView">
                                </div>
                            </div>
                            <div class = "row mb-3" id = "quantityReq">
                                <label class = "col-sm-3 col-form-label">Asset Name: </label>
                                <div class = "col-sm-6">
                                   <input type="text" id = "nameReq" name = "nameReq">
                                </div>
                            </div>
                            <div class = "row mb-3" id = "quantityReq">
                                <label class = "col-sm-3 col-form-label">Quantity: </label>
                                <div class = "col-sm-6">
                                    <input type = "button" id = "addQuantView" value = "+">
                                    <input type="text" name = "quantity" id = "quantityFieldView">
                                    <input type = "button"id = "minusQuantView" value = "-">
                                </div>
                            </div>
                            <div class = "row mb-3" id = "typeReq">
                                <label class = "col-sm-3 col-form-label">Type</label>
                                <div class = "col-sm-6">
                                    <select id="optionsTypeView" name = "type">
                                        <optgroup label="Select Type">
                                            <option >External</option>
                                            <option >Internal</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            
                            <div class = "row mb-3" id = "statusReq">
                                <label class = "col-sm-3 col-form-label">Status</label>
                                <div class = "col-sm-6">
                                <select id="optionsAssetsView" name = "status">
                                            <option >New</option>
                                            <option >Old</option>
                                            <option id = "brokenOptView" >Broken</option>
                                    </select>
                                </div>
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

                        <div class = "buttonFormView">

                            <button type = "submit" id = "submitAssetBtn">Submit</button>
                            
                        </div>
                            


                        </form>

                            <button id = "cancelSupAsset"onclick = "">Cancel</button>
                                
                            </div>
                    </div>
                    
                    <div class = "viewAssetInsideLab">

                        <table class = "">

                            <thead >
                                <tr class = "viewInsideTableHeader">
                                    <th id = "viewInsideCol">ID</th>
                                    <th id = "viewInsideCol">TYPE</th>
                                    <th id = "viewInsideCol">BRAND</th>
                                    <th id = "viewInsideCol">STATUS</th>
                                    <th id = "viewInsideCol">DESCRIPTION</th>
                                </tr>
                            </thead>

                            <tbody  >
                    
                                <?php
                                require_once('db_connector.php');

                                    $name = $_GET['id'];

                                    $sql = "SELECT transaction_table.trans_id as trans_id, assets.asset_id as asset_id, assets.asset_brand as asset_brand, assets.asset_type as asset_type, assets.asset_desc as asset_desc, transaction_table.asset_stat as asset_stat, laboratories.lab_name as lab_name  FROM transaction_table INNER JOIN assets ON transaction_table.asset_id = assets.asset_id INNER JOIN laboratories ON transaction_table.lab_id = laboratories.lab_id WHERE transaction_table.lab_id = '$name'";
                                   
                                    $result = $connection->query($sql);

                                    if(!$result){
                                        die("Invalid query: ". $connection->error);
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "
                                        <tbody  class = 'table-row'>
                                            <tr class = 'myTableRow'>
                                            <td  id = 'viewInsideRow' >$row[trans_id]</td>
                                            <td id = 'viewInsideRow'>$row[asset_type]</td>
                                            <td  id = 'viewInsideRow'>$row[asset_brand]</td>
                                            <td  id = 'viewInsideRow'>

                                                <select  data-id ='$row[trans_id]' id = 'selectStatusAssetIns' class = 'statusAssetSelect'>
                                                    <option >$row[asset_stat]</option>
                                                    <option value = 'New'>New</option>
                                                    <option value = 'Maintenance'>Maintenance</option>
                                                    <option value = 'Broken'>Broken</option>

                                                
                                                </select>
                                            
                                            </td>
                                            <td id = 'viewInsideRow'>$row[asset_desc]</td>
                                            </tr> 
                                        ";
                                    }
                                ?>
                    
                            </tbody>

                        </table>
                </div>

                <div id="popupFormViewLabReqTable" class="popup-formViewReqTable">
                    <button id = "cancelBtnShowReqTbl">Cancel</button>
                    <h4>REQUESTED ASSET</h4>
                    <table class = "tableReqAssetLab" id = "">

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
                                    $labId = $_GET["id"];

                                    $sql = "SELECT request_asset.req_id as req_id, request_asset.req_name as req_name, request_asset.req_status as req_status, request_asset.quantity_asset as quantity, request_asset.lab_id as lab_id, request_asset.req_date as req_date, laboratories.lab_name as labname FROM request_asset INNER JOIN laboratories ON request_asset.lab_id = laboratories.lab_id WHERE laboratories.lab_id = '$labId'";
                                   
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
                                           
                                                <select id = 'statusReqInsideSelect' data-id ='$row[req_id]' class='requestAssetStatus' id='reqAssetStat'>
                                                   <option id = 'displayStats' >$row[req_status]</option>
                                                   <option id = 'pendingStat' value = 'Pending'>Pending</option>
                                                   <option id = 'receiveStat'value = 'Received'>Received</option>
                                                   <option id = 'cancelStat' value = 'Cancelled'>Cancelled</option>
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

        cancelBtnShowReqTbl.addEventListener("click", function(){
            popupFormViewLabReqTable.style.display = "none";
        });

        cancelSupAsset.addEventListener("click", function(){
            popupFormViewLab.style.display = "none";
            let postype = document.getElementById("postTypeView");
            postyle.value = "";
        });

        requestBtnAssView.addEventListener("click", function(){
            popupFormViewLabReqTable.style.display = "block";
        });

        addQuantView.addEventListener("click", function (){
            let quantDisplay = document.getElementById("quantityFieldView").value;

            quantDisplay++;

            quantityFieldView.value = quantDisplay;
        });

        minusQuantView.addEventListener("click", function (){
            let quantDisplay = document.getElementById("quantityFieldView").value;

            quantDisplay--;

            quantityFieldView.value = quantDisplay;
        });

        requestBtn.addEventListener("click", function(){
            let postype = document.getElementById("postTypeView"); 
            postype.value = "Add";
            popupFormViewLab.style.display ="block";
            typeReq.style.display = "none";
            statusReq.style.display = "none";
            idDisplayDivView.style.display = "none";
            quantityFieldView.value = "0";
            myFormAssetView.style.paddingTop = "115px";
        });

        document.addEventListener('DOMContentLoaded', function() {
            
            let statusSelect = document.querySelectorAll('.statusAssetSelect');
            let statusSelectReq = document.querySelectorAll('.requestAssetStatus');
            let editLabButton = document.querySelectorAll('.editAssetInsideLab');

            editLabButton.forEach(function(row) {
                row.addEventListener('click', function() {
                    let idInput = document.getElementById("assetIdView");
                    let typeInput = document.getElementById("optionsTypeView");
                    let statusInput = document.getElementById("optionsAssetsView");
                    let assetName = this.getAttribute('data-assetName');
                    let postype = document.getElementById("postTypeView");
                    let id = this.getAttribute("data-transId");
                    let type = this.getAttribute("data-assetType");
                    let status = this.getAttribute("data-assetStat");
                    let allButtons = document.querySelectorAll("#editAssetInsideLab, #deleteAssetInsideLab, #requestBtn");
                    let labDate = this.getAttribute('data-labdate');
                    popupFormViewLab.style.display = "block";
                    idInput.value = id;
                    typeInput.value = type;
                    statusInput.value = status;
                    postype.value = "update";
                    quantityReq.style.display = "none";
                    titleOfFormReq.textContent = "Edit Asset Form";
                    allButtons.forEach(function(button) {
                        button.disabled = true;
                    });
                });
            });
            statusSelect.forEach(function(statupdate) {
                statupdate.addEventListener('change', function() {
                    if (event.target.classList.contains('statusAssetSelect')){
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
                                    // location.reload();
                                } else {
                                    console.error('There was a problem with the request.');
                                }
                            }
                        };
                });
            });
            statusSelectReq.forEach(function(statupdate) {
                statupdate.addEventListener('change', function() {
                    if (event.target.classList.contains('requestAssetStatus')){
                        var selectedValue = event.target.value;
                        console.log(selectedValue);
                    }
                        let idReq = this.getAttribute('data-id');
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        console.log(idReq);
                        xhr.send("statusReq="+selectedValue+"&&reqId="+idReq);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
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

    </script>
</body>
</html>