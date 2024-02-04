<?php

require_once('db_connector.php');

$sql = "";
$fname = "";
$lname = "";
$contact_num = "";
$email = "";
$address = "";
$company = "";

$errorMessage = "";
$successMessage = "";



if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $operation = $_POST["operation"];
    do {

        if($operation == "add"){

            $company = $_POST["company"];
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $contact_num = $_POST["contact_num"];
            $email = $_POST["email"];
            $address = $_POST["address"];
        
            $sqlSupname = "SELECT * FROM supplier where sup_fname = '$fname' AND sup_lname = '$lname'";

            $resultSupName = $connection->query($sqlSupname);
    
            if ($resultSupName->num_rows == 0) {
                
                $sql = "INSERT INTO supplier (company_name, sup_fname, sup_lname,contact_num, email, address) VALUES ('$company', '$fname', '$lname', '$contact_num', '$email', '$address')";
                $result = $connection->query($sql);
                
            } else {
                echo "Full name already exists!";
            }
        }

        if($operation == "update"){

            
            $company = $_POST["companyUpdate"];
            $supId = $_POST["suppId"];
            $fname = $_POST["fnameUpdate"];
            $lname = $_POST["lnameUpdate"];
            $contact_num = $_POST["contact_numUpdate"];
            $email = $_POST["emailUpdate"];
            $address = $_POST["addressUpdate"];

            
            
            $sqlSupname = "SELECT * FROM supplier where sup_fname = '$fname' AND sup_lname = '$lname' AND company_name = '$company' AND email = '$email' AND address = '$address' AND contact_num = '$contact_num'";

            $resultSupName = $connection->query($sqlSupname);


            if ($resultSupName->num_rows == 0) {
                
                $sql = "UPDATE supplier SET company_name = '$company',sup_fname = '$fname', sup_lname = '$lname', contact_num = '$contact_num', email = '$email', address = '$address' WHERE sup_id = '$supId'";

                if ($connection->query($sql) === TRUE) {
                } else {
                    $connection->error;
                }
                
            } else {
                echo "Full name already exists!";
            }

            

           

        }

        header("location: /asset/myDashboard/supplierTable.php");

    } while (false);

   
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    echo "asd";
    
    $sql = "DELETE FROM supplier WHERE sup_id = $id";

    if ($connection->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $connection->error;
    }

    $connection->close();
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

                <div class = "suppAddTitle">
                    <h2>LIST OF SUPPLIERS</h2>
                </div>
                <button id="addButton">Add Supplier</button>

                <div id="popupForm" class="popup-form">
                    
                    <div class = "suppFormContainer">
                        
                        <h2 id = "titleForm">Add Supplier Form</h2><br>
                                
                        <form action="" method = "post" id = "myFormSup">
                                <input type="text" id = "typePost" placeholder = "type of post" name = "operation">
                                <label for="" id = "supDipId">ID</label>
                                <input type="text" id = "supIdDisplay" name = "suppId">
                                <div class = "fillFirstRow">
                                    <label >Company Name:</label><br>
                                    <input type="text"  name = "company" id = "companyName"value = "<?php echo $company; ?>"  required><br><br>
                                    <label >First Name:</label><br>
                                    <input type="text"  name = "fname" id = "supFName"value = "<?php echo $fname; ?>" required><br><br>
                                    <label >Contact Number</label><br>
                                    <input type="text" id = "supNumber"value = "<?php echo $contact_num; ?>" name = "contact_num" required>
                                </div>
                                <div class = "fillSecondRow">
                                    <label >Last Name</label>
                                    <input type="text" id = "supLName" name = "lname" value = "<?php echo $lname; ?>" required><br><br>
                                    <label >Email</label>
                                    <input type="email" id = "supEmail" value = "<?php echo $email; ?>" name = "email" required>
                                </div>
                                <div class = "addressContainer">
                                    <label for="address">Enter Supplier Address:</label><br>
                                    <textarea id="supAddress" name="address" rows="4" cols="50" value = "<?php echo $address; ?>"></textarea required>
                                </div>
                                
                            <br>
                                
                          
                        <button type = "submit" id = "submitSupplier">Submit</button>
                                    
                        <button id = "cancelSuppBut" onclick = "cancelAdd()">Cancel</button><br>

                        </form>

                    </div>
                </div>

                <div class = "suppTableDisplay">

                    <table class = "supplierTable" >

                        <thead >
                            <tr class = "supplierTableHeader">
                                <th id = "suppCol">ID</th>
                                <th id = "suppCol">COMPANY NAME</th>
                                <th id = "suppCol">FIRST NAME</th>
                                <th id = "suppCol">LAST NAME</th>
                                <th id = "suppCol">CONTACT NUMBER</th>
                                <th id = "suppCol">EMAIL</th>
                                <th id = "suppCol">ADDRESS</th>
                                <th id = "suppCol">ACTIONS</th>
                            </tr>
                        </thead>

                        <tbody  >
                
                            <?php
                               require_once('db_connector.php');


                                $sql = "SELECT * From supplier";
                                $result = $connection->query($sql);

                                if(!$result){
                                    die("Invalid query: ". $connection->error);
                                }

                                while($row = $result->fetch_assoc()){
                                    echo "
                                    <tbody class = 'table-row'>
                                        <td    id = 'supplierRow'>$row[sup_id]</td>
                                         <td id = 'supplierRow' style = 'padding-left = 400px;'>$row[company_name]</td>
                                        <td  id = 'supplierRow' style = 'padding-left = 400px;'>$row[sup_fname]</td>
                                        <td   id = 'supplierRow'>$row[sup_lname]</td>
                                        <td  id = 'supplierRow'>$row[contact_num]</td>
                                        <td id = 'supplierRow'>$row[email]</td>
                                        <td  id = 'supplierRow'>$row[address]</td>
                                        <td  id = 'supplierRow'>
                                            <button data-supId = '$row[sup_id]' data-company = '$row[company_name]' data-supFname = '$row[sup_fname]' data-supLname = '$row[sup_lname]' data-supNumber = '$row[contact_num]' data-supEmail = '$row[email]' data-supAddress = '$row[address]' class = 'suppEditBtn'  id = 'suppEditBtn'>Edit</button>
                                            <button data-supId = '$row[sup_id]' class = 'deleteBtnSup' id = 'deleteBtnSup'>Delete</button>
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js">
    </script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js">
    </script>
    <script>

        let editable = true;
        
        document.addEventListener('DOMContentLoaded', function() {
            let tableRows = document.querySelectorAll('.suppEditBtn');
            let tableRowsDelete = document.querySelectorAll('.deleteBtnSup');
            tableRows.forEach(function(row) {
                row.addEventListener('click', function() {
                    popupForm.style.display = "block";
                    let allButtons = document.querySelectorAll("#suppEditBtn, #deleteBtnSup,  #addButton");
                    let titleForm = document.getElementById("titleForm");
                    let companyInput = document.getElementById("companyName");
                    let suppFNameInput = document.getElementById("supFName");
                    let suppLNameInput = document.getElementById("supLName");
                    let suppNumInput = document.getElementById("supNumber");
                    let suppEmailInput = document.getElementById("supEmail");
                    let suppAddressInput = document.getElementById("supAddress");
                    let suppIdDisplay = document.getElementById("supIdDisplay");
                    let suppIdDip = document.getElementById("supDipId");
                    let company = this.getAttribute("data-company");
                    let supFname = this.getAttribute('data-supFname');
                    let supLname = this.getAttribute('data-supLname');
                    let supNum = this.getAttribute('data-supNumber');
                    let supEmail = this.getAttribute('data-supEmail');
                    let supAddress = this.getAttribute('data-supAddress');
                    let operator = document.getElementById("typePost");
                    let supId = this.getAttribute('data-supId');
                    suppIdDisplay.style.display = "inline-block";
                    suppIdDip.style.display = "inline-block";
                    suppIdDisplay.value = supId;
                    companyInput.value = company;
                    suppAddressInput.value = supAddress;
                    suppEmailInput.value = supEmail;
                    suppNumInput.value = supNum;
                    suppFNameInput.value = supFname;
                    suppLNameInput.value = supLname;
                        allButtons.forEach(function(button) {
                            button.disabled = true;
                        });
                        titleForm.textContent = "Update Supplier Form";
                        operator.value = "update";
                        suppFNameInput.name = "fnameUpdate";
                        companyInput.name = "companyUpdate";
                        suppLNameInput.name = "lnameUpdate";
                        suppNumInput.name = "contact_numUpdate";
                        suppEmailInput.name = "emailUpdate";
                        suppAddressInput.name = "addressUpdate";
                        editable = false;

                });
            });
            tableRowsDelete.forEach(function(row) {
                row.addEventListener('click', function() {
                    let id = this.getAttribute('data-supId');
                    var confirmation = confirm("Confirm Delete?");
                        if (confirmation) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("id=" + id);
    
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        console.log(xhr.responseText);

                                        var deletedElement = document.getElementById("item_" + id);
                                        location.reload();
                                        if (deletedElement) {
                                            deletedElement.remove();
                                        }
                                    } else {
                                        console.error('There was a problem with the request.');
                                    }
                                }
                            };
                        }
                });
            });
            
        });

        // Toggle Sidebar
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

        function cancelAdd(){
            let operator = document.getElementById("typePost");
            popupForm.style.display = "none";
            operator.value = "";
            location.reload();
        }

        const addButton = document.getElementById('addButton');
        const popupForm = document.getElementById('popupForm');

        addButton.addEventListener('click', function() {
            popupForm.style.display = 'block';
            let allButtons = document.querySelectorAll("#suppEditBtn, #deleteBtnSup,  #addButton");
            let titleForm = document.getElementById("titleForm");
            let operation = document.getElementById("typePost");
            let suppFNameInput = document.getElementById("supFName");
            let companyInput = document.getElementById("supFName");
            let suppLNameInput = document.getElementById("supLName");
            let suppNumInput = document.getElementById("supNumber");
            let suppEmailInput = document.getElementById("supEmail");
            let suppAddressInput = document.getElementById("supAddress");
            let suppIdDisplay = document.getElementById("supIdDisplay");
            let suppIdDip = document.getElementById("supDipId");
            suppIdDisplay.style.display = "none";
            suppIdDip.style.display = "none";
            operation.value  = "add";
            allButtons.forEach(function(button) {
                button.disabled = true;
            });
            if(editable === false){
                titleForm.textContent = "Add Supplier Form";
                suppFNameInput.value = "";
                suppLNameInput.value = "";
                suppNumInput.value = "";
                suppEmailInput.value = "";
                suppAddressInput.value = "";
                companyInput.value = "";
                editable = true;
            }
        });

        document.getElementById('myFormSup').addEventListener('submit', function(event) {
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