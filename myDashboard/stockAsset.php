<?php

require_once('db_connector.php');

$sql = "";
$type = "";
$status = "";
$quant = "";
$description = "";
$brand = "";
$operation = "";

$errorMessage = "";
$successMessage = "";
$supFullName = "";
$asset_id = "";


try {

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        
        do {


            $operation = $_POST["postType"];
            if($operation == "add"){
                
            $type = $_POST["type"];
            $brand = $_POST["brand"];
            $status = $_POST["status"];
            $quant = $_POST["quantity"];
            $sup_id = $_POST["supplier"];
            $description = $_POST["description"];
            $assign_lab = $_POST["assigned"];

                $sql = "INSERT INTO assets (asset_type, asset_brand, asset_status, asset_desc, asset_quant , sup_id) VALUES ('$type', '$brand', '$status', '$description', '$quant', '$sup_id')";
                $result = $connection->query($sql);
    
                if(!$result){
                    $errorMessage = 'Invalid Query: ' .$connection->error;
                    break;
                }

                $operation = "";
                $name = "";
                $type = "";
                $brand = "";
                $status = "";
                $quant = "";
                $sup_id = "";
                $description = "";
                $assign_lab = "";
                $successMessage = "Added Successfully";
    
                // header("location: /asset/myDashboard/asset.php");
            }

            if($operation == "Update"){

                $asset_id = $_POST["IdAsset"];
                $brand = $_POST["brandUpdate"];
                $typeUpdate = $_POST["typeUpdate"];
                $statusUpdate = $_POST["statusUpdate"];
                $quantUpdate = $_POST["quantityUpdate"];
                $sup_id = $_POST["supplierUpdate"];
                $description = $_POST["descriptionUpdate"];
                
                $sqlUpdateAsset = "UPDATE assets SET asset_type = '$typeUpdate', asset_brand = '$brand', asset_status = '$statusUpdate', asset_desc = '$description', asset_quant = '$quantUpdate', sup_id = '$sup_id' WHERE asset_id = '$asset_id'";

                if ($connection->query($sqlUpdateAsset) === TRUE) {
                } else {
                    $connection->error;
                }

            }

            if($operation == "assign"){
                
                $numberOfAsset = $_POST["quantity"];
                $asset_id = $_POST["IdAsset"];
                $lab_id = $_POST["assigned"];
                $sup_id = $_POST["supplier"];
                $asset_stat = $_POST["status"];
                $currentDateTime = date("M-d-Y");
                
                $sqlLab = "SELECT lab_name  FROM laboratories WHERE lab_id = '$lab_id'";

                $resultLab = $connection->query($sqlLab);
                
                if ($resultLab) {
                    $row = $resultLab->fetch_assoc();
                    $nameLaboratory = $row['lab_name'];
                }

                for ($i = 0; $i < $numberOfAsset; $i++) {


                    $sql = "INSERT INTO transaction_table (asset_id, lab_id, sup_id, asset_stat, trans_date) VALUES ('$asset_id', '$lab_id', '$sup_id', '$asset_stat', '$currentDateTime')";
                    $result = $connection->query($sql);

                }

                
                    $sqlUpdateLab = "UPDATE assets SET asset_quant = '$numberOfAsset' WHERE asset_id = '$asset_id'";

                    if ($connection->query($sqlUpdateLab) === TRUE) {
                    } else {
                        $connection->error;
                    }

            }

        } while (false);


    }

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
    
        $connection->close();
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
                <h2>STOCKS OF ASSET</h2>
                <button id = "addAsset" >ADD ASSET</button>
                <button id = "requestAssetBtn" >SHOW REQUESTED ASSET</button>
                <div id="popupFormAsset" class="popup-formAsset">
                    
                    <div class = "suppFormContainer">
                        
                        <h2 id = "titleOfForm">Add Asset Form</h2><br>
                                
                        <form action="" method = "post" id = "myFormAsset">

                        <input type="text" name = "postType" id = "postType">
                            <div class = "idDisplayDiv" id = "idDisplayDiv">
                                <label class = "col-sm-3 col-form-label">ID</label>
                                <div class = "col-sm-6">
                                    <input type="text" id = "assetId"  name = "IdAsset" value = "<?php echo $asset_id; ?>">
                                </div>
                            </div>  
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Device Type:</label>
                                <div class = "col-sm-6">
                                    <select id="optionsType" name = "type" value = "<?php echo $type; ?>">
                                        <optgroup label="Select Type">
                                            <option >Desktop Computer</option>
                                            <option >Laptop</option>
                                            <option >Tablet</option>
                                            <option >Monitor</option>
                                            <option >Printer</option>
                                            <option >Projector</option>
                                            <option >Scanner</option>
                                            <option >Network Switch</option>
                                            <option >Router</option>
                                            <option >Camera</option>
                                            <option >Microphone</option>
                                            <option >Speakers</option>
                                            <option >Headset</option>
                                            <option >Keyboard</option>
                                            <option >Mouse</option>
                                            <option >Others</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Brand:</label>
                                <div class = "col-sm-6">
                                    <input type="text" id = "brandOfAsset"  name = "brand" value = "<?php echo $brand; ?>">
                                </div>
                            </div>
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Quantity:</label>
                                <div class = "col-sm-6">
                                    <input type = "button" id = "addQuant" value = "+">
                                    <input type="text" name = "quantity" id = "quantityField" value = "<?php echo $quant; ?>">
                                    <input type = "button"id = "minusQuant" value = "-">
                                </div>
                            </div>
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label">Status:</label>
                                <div class = "col-sm-6">
                                <select id="optionsAssets" name = "status" value = "<?php echo $status; ?>">
                                            <option  value = "New">New</option>
                                            <option  value = "Old">Old</option>
                                            <option value = "Broken" id = "brokenOpt" >Broken</option>
                                    </select>
                                </div>
                            </div>
                            <div class = "row mb-3">
                                <label class = "col-sm-3 col-form-label" >Asset Description:</label>
                                <div class = "col-sm-6">
                                    <input type="text" id = "description"  name = "description" value = "<?php echo $description; ?>">
                                </div>
                            </div>

                            <label for="options">Select an Supplier:</label>
                                    <select name="supplier" id="optionsSupAsset" value = "<?php echo $sup_id; ?>">
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
                                    <a href="" id = "addSuppLink">+Add Supplier</a><br><br>

                                    <div id = "assignedLabOpt" class = "assignedLabOpt">
                                        <label for="options">Assign to:</label>
                                        <select name="assigned" id="optionLabAsset" value = "<?php echo $assign_lab; ?>">
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

                                    </div>

                        <div class = "buttonForm">

                            <button type = "submit">Submit</button>

                            <button id = "cancelAsset"onclick = "cancelSup()">Cancel</button>
                            
                        </div>
                            


                        </form>
                                
                            </div>
                    </div>

                  
                
                    <div class="stocksAssetTableDisplay">
                        <table class = "stocksTableDisplay" id = "">
                            <thead>
                                <tr class = "assetStocksHeader">
                                    <th id = "stocksCol">ID</th>
                                    <th id = "stocksCol">DEVICE TYPE</th>
                                    <th id = "stocksCol">BRAND</th>
                                    <th id = "stocksCol">STATUS</th>
                                    <th id = "stocksCol">STOCKS</th>
                                    <th id = "stocksCol">SUPPLIER NAME</th>
                                    <th id = "stocksCol">ACTIONS</th>
                                    <!-- <th id = "actionEd">ACTIONS</th> -->
                                </tr>
                            </thead>

                            <tbody  >
                    
                                <?php
                                require_once('db_connector.php');


                                    $sql = "SELECT assets.sup_id as sup_id, assets.asset_id as asset_id, assets.asset_type as asset_type, assets.asset_status as asset_status, assets.asset_quant as asset_quant,assets.asset_brand as asset_brand, assets.asset_desc as asset_desc, CONCAT(supplier.sup_fname, ' ', supplier.sup_lname) as full_name FROM assets INNER JOIN supplier ON assets.sup_id = supplier.sup_id ORDER BY asset_id ASC";
                                   
                                    $result = $connection->query($sql);

                                    if(!$result){
                                        die("Invalid query: ". $connection->error);
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "
                                        <tbody data-assetAydi = '$row[asset_id]' data-assetBrand = '$row[asset_brand]' data-assetDesc = '$row[asset_desc]'  data-assetType = '$row[asset_type]' data-assetQuant = '$row[asset_quant]' data-assetStat = '$row[asset_status]'  data-supId = '$row[sup_id]'  class = 'table-row'>
                                            <td id = 'stocksRow'>$row[asset_id]</td>
                                            <td  id = 'stocksRow'>$row[asset_type]</td>
                                            <td id = 'stocksRow' >$row[asset_brand]</td>
                                            <td id = 'stocksRow'>$row[asset_status]</td>
                                            <td  id = 'stocksRow'>$row[asset_quant]</td>
                                            <td  id = 'stocksRow'>$row[full_name]</td>
                                            <td  style='border: none;' id = 'stocksRow' class = 'actionStockBtn'>
                                                <button data-desc = '$row[asset_desc]' data-brand = '$row[asset_brand]' data-assetAydi = '$row[asset_id]'  data-assetDesc = '$row[asset_desc]'  data-assetType = '$row[asset_type]' data-assetQuant = '$row[asset_quant]' data-assetStat = '$row[asset_status]'  data-supId = '$row[sup_id]'  id = 'assignButtonLab' class = 'assignButtonLab'>Assign To</button>
                                                <button  data-assetType = '$row[asset_type]' data-assetQuant = '$row[asset_quant]' data-assetStat = '$row[asset_status]' data-assetAydi = '$row[asset_id]' data-assetSup = '$row[full_name]' data-assetBrand = '$row[asset_brand]' data-assetDesc = '$row[asset_desc]' data-supId = '$row[sup_id]' class = 'editButtonAsset' id = 'editAssetButton'  >Edit Asset</button>
                                                <input data-asset = '$row[asset_id]' name = 'deleteAsset' class = 'deleteButton'  id = 'deleteButton' type = 'submit' value = 'Delete Asset'>
                                            </td> 
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

       

        requestAssetBtn.addEventListener("click", function(){
            window.location.href = "http://localhost/asset/myDashboard/assetTableRequest.php";
        });

        document.addEventListener('DOMContentLoaded', function() {
            var editbTn = document.querySelectorAll('.editButtonAsset');
            var tableRowsDelete = document.querySelectorAll('.deleteButton');
            let tableRowsAssign = document.querySelectorAll('.assignButtonLab');
            let allButtons = document.querySelectorAll("#editAssetButton, #deleteButton, #assignButtonLab, #addAsset");
            let operationDisplay = document.getElementById('postType');
            let table = document.getElementById('assetTable');
            let assetQuantity = document.getElementById("quantityField");
            let assetBrand = document.getElementById("brandOfAsset");
            let assetTypeOption = document.getElementById("optionsType");
            let assetStatus = document.getElementById("optionsAssets");
            let idDisplay = document.getElementById("idDisplayDiv");
            let idDisplayAsset = document.getElementById("assetId");
            let supplier = document.getElementById("optionsSupAsset");
            let laboratory = document.getElementById("optionLabAsset");
            let assetDsp = document.getElementById("description");
            editbTn.forEach(function(rowUpdate) {
                rowUpdate.addEventListener('click', function() {
                    popupFormAsset.style.display = 'block';
                    let assetType = this.getAttribute('data-assetType');
                    let assetQuant = this.getAttribute('data-assetQuant');
                    let assetStat = this.getAttribute('data-assetStat');
                    let assetbrand = this.getAttribute('data-assetBrand');
                    let assetSupplier = this.getAttribute('data-assetSup');
                    let assetDesc = this.getAttribute('data-assetDesc');
                    let assetId = this.getAttribute('data-assetAydi');
                    let supId = this.getAttribute('data-supId');
                    let h2Content = document.getElementById
                    ("titleOfForm");
                    assetDsp.value = assetDesc;
                    assetBrand.value = assetbrand;
                    idDisplayAsset.value = assetId;
                    supplier.value = supId;
                    assetTypeOption.value = assetType;
                    assetQuantity.value = assetQuant;
                    assetStatus.value = assetStat;
                    allButtons.forEach(function(button) {
                        button.disabled = true;
                    });
                    h2Content.textContent = "Update Asset Form";
                    laboratory.name = "assignedUpdate";
                    supplier.name = "supplierUpdate";
                    operationDisplay.value = "Update";
                    description.name = "descriptionUpdate";
                    idDisplayAsset.name = "IdAsset";
                    idDisplay.style.display = "flex";
                    idDisplay.style.marginBottom = "20px";
                    assetTypeOption.name = "typeUpdate";
                    assetBrand.name = "brandUpdate";
                    assetStatus.name = "statusUpdate";
                    assetQuantity.name = "quantityUpdate";
                    brokenOpt.style.display = "block";
                });
            });
            
            tableRowsAssign.forEach(function(row) {
                row.addEventListener('click', function() {
                    allButtons.forEach(function(button) {
                        button.disabled = true;
                    });
                    let h2Content = document.getElementById
                    ("titleOfForm");
                    let typeAsset = document.getElementById("optionsType");
                    let quantAsset = document.getElementById("quantityField");
                    let statAsset = document.getElementById("optionsAssets");
                    let brandAsset = document.getElementById("brandOfAsset");
                    let descBrand = document.getElementById("description");
                    let supAsset = document.getElementById("optionsSup");
                    let assetType = this.getAttribute('data-assetType');
                    let assetQuant = this.getAttribute('data-assetQuant');
                    let assetSup = this.getAttribute('data-supId');
                    let assetStat = this.getAttribute('data-assetStat');
                    let assetId = this.getAttribute('data-assetAydi');
                    let brand = this.getAttribute('data-brand');
                    let description = this.getAttribute('data-desc');
                    h2Content.textContent = "Assign Asset Form";
                    popupForm.style.display = 'block';
                    let assignedLab = document.getElementById("assignedLabOpt");
                    brandAsset.value = brand;
                    descBrand.value = description;
                    idDisplayAsset.value = assetId;
                    assignedLab.style.display = "block";
                    typeAsset.value = assetType;
                    typeAsset.style.pointerEvents = "none";
                    typeAsset.style.border = "none";
                    typeAsset.style.cursor = "not-allowed";
                    quantAsset.value = assetQuant;
                    statAsset.value = assetStat;
                    statAsset.style.pointerEvents = "none";
                    statAsset.style.border = "none";
                    statAsset.style.cursor = "not-allowed";
                    supplier.value = assetSup;
                    supplier.style.pointerEvents = "none";
                    supplier.style.border = "none";
                    supplier.style.cursor = "not-allowed";
                    descBrand.style.pointerEvents = "none";
                    descBrand.style.border = "none";
                    descBrand.style.cursor = "not-allowed";
                    brandAsset.style.pointerEvents = "none";
                    brandAsset.style.border = "none";
                    brandAsset.style.cursor = "not-allowed";
                    operationDisplay.value = "assign";
                    idDisplayAsset.name = "IdAsset";
                    idDisplay.style.display = "flex";
                    idDisplay.style.marginBottom = "20px";
                    addSuppLink.style.display = "none";
                });
            });
            tableRowsDelete.forEach(function(row) {
                row.addEventListener('click', function() {
                let id = this.getAttribute('data-asset');
                    
                var confirmation = confirm("Confirm Delete?");
                    if (confirmation) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("delete=" + id);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                     console.log(xhr.responseText);
                                    var deletedElement = document.getElementById("item_" + id);
                                    location.reload();
                                } else {
                                    console.error('There was a problem with the request.');
                                }
                            }
                        };
                    }
                   
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

        addButton.addEventListener('click', function() {
            let allButtons = document.querySelectorAll("#editAssetButton, #deleteButton, #assignButtonLab, #addAsset");
            let h2Content = document.getElementById
            ("titleOfForm");
            popupForm.style.display = 'block';
            let laboratory = document.getElementById("optionLab");
            let operation = document.getElementById("postType");
            let idDisplay = document.getElementById("idDisplayDiv");
            let assetQuantity = document.getElementById("quantityField");
            let assetTypeOption = document.getElementById("optionsType");
            let assetStatus = document.getElementById("optionsAssets");
            let assetSupp = document.getElementById("optionsSup");
            quantityField.value = "0";
            operation.value = "add";
            allButtons.forEach(function(button) {
                button.disabled = true;
            });
            h2Content.textContent = "Add Asset Form";
            laboratory.name = "assigned";
            assetQuantity.value = "0";
            assetTypeOption.value = "External";
            assetStatus.value = "New";
            idDisplay.style.display = "none";
            assetTypeOption.name = "type";
            assetStatus.name = "status";
            assetSupp.name = "supplier";
            assetQuantity.name = "quantity";
            brokenOpt.style.display = "none";
        });

        // document.getElementById('myFormAsset').addEventListener('submit', function(event) {
        // const formData = new FormData(event.target);
        // for (const pair of formData.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }
        // // After handling form data, you can hide the form
        //     popupForm.style.display = 'none';
        // });

    </script>
</body>
</html>