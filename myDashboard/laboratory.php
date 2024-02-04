<?php

require_once('db_connector.php');

$sql = "";
$name = "";
$adminId = "";
$date = "";

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

   
    $operation = $_POST["typePostLab"];

    do {

        if($operation == "add"){

            $name = $_POST["laboratoryName"];
            $LabNoSpacename = $_POST["labNameNoSpace"];
            $adminId = $_POST["admin"];
            $date = $_POST["mydates"];

            $sqlLabname = "SELECT * FROM laboratories where lab_name = '$name'";

            $resultLabNames = $connection->query($sqlLabname);
            
            if ($resultLabNames->num_rows == 0) {

                $sql = "INSERT INTO laboratories (lab_name, lab_date, admin_id) VALUES ('$name', '$date', '$adminId')";

                $result = $connection->query($sql);
                
            } else {
                echo "Full name already exists!";
            }

        }else if($operation == "Update"){

            $labId = $_POST["labId"];
            $name = $_POST["labNameUpdate"];
            $adminId = $_POST["adminUpdate"];
            $date = $_POST["dateUpdate"];


            $sqlUpdateLab = "UPDATE laboratories SET lab_name = '$name', lab_date = '$date', admin_id = '$adminId' WHERE lab_id = '$labId'";

            if ($connection->query($sqlUpdateLab) === TRUE) {
            } else {
                $connection->error;
            }
                
    
        }
        
    $name = "";
    $type = "";
    $status = "";
    

    $successMessage = "Added Successfully";

        header("location: /asset/myDashboard/laboratory.php");

    } while (false);

    if(isset($_POST['delete'])) {
        $id = $_POST['delete'];
        
        $sql = "DELETE FROM laboratories WHERE lab_id = '$id'";
    
        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }
    
        $connection->close();
    }

}



$sqlAdmin = "SELECT admin_id, CONCAT(admin_fname, ' ', admin_lname) as full_name FROM admins WHERE admin_role = 'Instructor'";
$resultAdmin = $connection->query($sqlAdmin);
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
                
                <h2>LIST OF LABORATORY</h2>
                <button id = "addLabButton">Add Laboratory</button>

                <div id="popupFormLab" class="popup-formLab">
                    
                    <div class = "suppFormContainer">
                        
                        <h2 id = "titleLabForm">Add Laboratory Form</h2><br>
                                
                        <form action="" method = "post" id = "myFormLab">

                                    <div class = "idDisplay" id = "idDisplay">
                                        <label for="">ID</label>
                                        <input type="text" id = "labIdDisplay" name = "labId" ><br><br>
                                    </div>
                                    <input type="text" name = "oldName" id = "oldNameDisplay">
                                    <input type="text" placeholder = "typepost" name = "typePostLab" id = "typePostLab">
                                    <label >Laboratory Name:</label>
                                    <input type="text" id = "laboratoryAddName" name = "laboratoryName" value = "<?php echo $name; ?>" required><br><br>
                                    <input type="text" id = "withoutSpace" name = "labNameNoSpace">
                                    <label for="options">Select an Admin:</label>
                                    <select name="admin" id="optionsAdmin" required>
                                    <?php
                                        if ($resultAdmin->num_rows > 0) {
                                            while ($row = $resultAdmin->fetch_assoc()) {
                                                echo "<option value='" . $row['admin_id'] . "'>" . $row['full_name'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No options available</option>";
                                        }
                                    ?>
                                    </select><br>
                                    <a href="http://localhost/asset/myDashboard/admin.php" id = "addAdminBtn">+Add Admin</a><br>
                                    <label >Date Created:</label>
                                    <input type="date" id = "dateLabCreate" name = "mydates" value = "<?php echo $date; ?>" required><br><br>
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
                            <br>
                            <div id  ="labBtnContainer">
                                <input type = "submit" name = "createLabTable" value = "Create Laboratory"id = "addLabTable">
                                
                                <button id = "cancelSuppBut" onclick = "cancelAdd()">Cancel</button><br>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="labTableContainer">

                    <table  class = "myLaboratoryTable" >

                        <thead >
                            <tr class = "laboratoryRowTable">
                                <th id = "laboratoryCol">ID</th>
                                <th id = "laboratoryCol">LABORATORY NAME</th>
                                <th id = "laboratoryCol">ADMIN</th>
                                <th id = "laboratoryCol">DATE CREATED</th>
                                <th id = "laboratoryCol" class = "laboratoryCol">ACTIONS</th>
                            </tr>
                        </thead>

                
                                <?php
                                require_once('db_connector.php');


                                    // $sql = "SELECT * From laboratories";
                                    $sql = "SELECT laboratories.lab_id as lab_id, laboratories.lab_name as lab_name, CONCAT(admins.admin_fname, ' ', admins.admin_lname) as full_name, admins.admin_fname as fname, admins.admin_lname as lname, laboratories.lab_date as lab_date, admins.admin_id as admin_id  FROM laboratories INNER JOIN admins ON laboratories.admin_id = admins.admin_id";
                                    $result = $connection->query($sql);

                                    if(!$result){
                                        die("Invalid query: ". $connection->error);
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "
                                        <tbody >
                                        <tr class = 'table-row'>
                                            <td class='laboratoryRow' data-adminFName = '$row[fname]' data-adminLName = '$row[lname]' data-labid='$row[lab_id]' data-labname='$row[lab_name]'data-adminId='$row[admin_id]' id = 'laboratoryRow' >$row[lab_id]</td>
                                            <td  class='laboratoryRow'  data-adminFName = '$row[fname]' data-adminLName = '$row[lname]' data-labid='$row[lab_id]' data-labname='$row[lab_name]'data-adminId='$row[admin_id]' id = 'laboratoryRow' style = 'padding-left = 400px;' >$row[lab_name]</td>
                                            <td class='laboratoryRow'   id = 'laboratoryRow'  data-adminFName = '$row[fname]' data-adminLName = '$row[lname]' >  $row[full_name]</td>
                                            <td  class='laboratoryRow'  data-labid='$row[lab_id]' data-labname='$row[lab_name]'data-adminId='$row[admin_id]' id = 'laboratoryRow' >$row[lab_date]</td>
                                            <td class = 'buttons' id = 'laboratoryRow'>
                                               <button data-labId='$row[lab_id]' data-labname='$row[lab_name]' data-labadmin='$row[full_name]' data-labadminId='$row[admin_id]'data-labdate='$row[lab_date]' class = 'editLabButton' id = 'editLabButton'>Edit</button>
                                               <button data-labId = '$row[lab_id]' id = 'deleteLabBtn' data-labname='$row[lab_name]' class = 'deleteLabBtn'>Delete</button>
                                            </td>
                                        </tr>
                                        </tbody >
                                        "; 
                                    }
                                ?>

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
            let tableRows = document.querySelectorAll('.laboratoryRow');
            let editLabButton = document.querySelectorAll('.editLabButton');
            let deleteLabButton = document.querySelectorAll('.deleteLabBtn');

            deleteLabButton.forEach(function(row) {
                row.addEventListener('click', function() {
                let id = this.getAttribute('data-labId');
                    
                var confirmation = confirm("Confirm Delete?");
                    if (confirmation) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("delete=" + id);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    //  console.log(xhr.responseText);
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

            tableRows.forEach(function(row) {
                row.addEventListener('click', function() {
                    let labId = this.getAttribute('data-labid');
                    let labName = this.getAttribute('data-labname');
                    let adminFname = this.getAttribute('data-adminFName');
                    let adminLname = this.getAttribute('data-adminLName');
                    window.location.href = 'http://localhost/asset/myDashboard/insideLaboratory.php?id=' + labId + '&name=' + labName + '&adminFname=' + adminFname + '&adminLname='+adminLname;
                });
            });

            editLabButton.forEach(function(row) {
                row.addEventListener('click', function() {
                    let allButtons = document.querySelectorAll("#editLabButton, #deleteLabBtn, #addLabButton");
                    let labId = this.getAttribute('data-labId');
                    let typePost = document.getElementById("typePostLab");
                    let labIdInput = document.getElementById("labIdDisplay");
                    let labOldNameInput = document.getElementById("oldNameDisplay");
                    let labNameInput = document.getElementById("laboratoryAddName");
                    let labAdminInput = document.getElementById("optionsAdmin");
                    let labDateInput = document.getElementById("dateLabCreate");
                    let labName = this.getAttribute('data-labname');
                    let labAdmin = this.getAttribute('data-labadminId');
                    let labDate = this.getAttribute('data-labdate');
                    allButtons.forEach(function(button) {
                        button.disabled = true;
                    });
                    typePost.value = "Update";
                    titleLabForm.textContent = "Update Laboratory Form";
                    labNameInput.name = "labNameUpdate";
                    labAdminInput.name = "adminUpdate";
                    labDateInput.name = "dateUpdate";
                    addLabTable.value = "Update Laboratory";
                    labOldNameInput.value = labName;
                    labNameInput.value = labName;
                    labIdInput.value = labId;
                    labAdminInput.value = labAdmin;
                    labDateInput.value = labDate;
                    popupFormLab.style.display = "block";
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
            popupForm.style.display = "none";
            location.reload();
            let typePost = document.getElementById("typePostLab");
            typePost.value = "";
        }

        const addButton = document.getElementById('addLabButton');
        const popupForm = document.getElementById('popupFormLab');

        addButton.addEventListener('click', function() {
            let allButtons = document.querySelectorAll("#editLabButton, #deleteLabBtn, #addLabButton");
            popupForm.style.display = 'block';
            let typePost = document.getElementById("typePostLab");
            let labIdInput = document.getElementById("labIdDisplay");
            let labNameInput = document.getElementById("laboratoryAddName");
            let labAdminInput = document.getElementById("optionsAdmin");
            let labDateInput = document.getElementById("dateLabCreate");
            allButtons.forEach(function(button) {
                button.disabled = true;
            });
            typePost.value = "add";
            titleLabForm.textContent = "Add Laboratory Form";
            addLabTable.value = "Create Laboratory";
            idDisplay.style.display = "none";
        });

        document.getElementById('myFormLab').addEventListener('submit', function(event) {
        const formData = new FormData(event.target);
        for (const pair of formData.entries()) {
            console.log(`${pair[0]}: ${pair[1]}`);
        }   
        popupForm.style.display = 'none';
        });


       
      

    </script>
     
</body>
</html>