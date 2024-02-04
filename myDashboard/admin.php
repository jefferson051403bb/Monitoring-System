<?php

require_once('db_connector.php');

$sql = "";
$admin_fname = "";
$admin_lname = "";
$admin_num = "";
$admin_email = "";

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $admin_fname = $_POST["admin_fname"];
    $admin_lname = $_POST["admin_lname"];
    $admin_num = $_POST["admin_num"];
    $admin_email = $_POST["admin_email"];

    $operation = $_POST["postType"];

    do {

        if($operation == "add"){

            $sqlAdminname = "SELECT * FROM admins where admin_fname = '$admin_fname' AND admin_lname = '$admin_lname'";

            $resultAdminName = $connection->query($sqlAdminname);

            
            if ($resultAdminName->num_rows == 0) {

                $sql = "INSERT INTO admins (admin_fname, admin_lname,admin_num, admin_email) VALUES ('$admin_fname', '$admin_lname', '$admin_num', '$admin_email')";

                $result = $connection->query($sql);


                if(!$result){
                    $errorMessage = 'Invalid Query: ' .$connection->error;
                    break;
                }
                
            } else {
                echo "Full name already exists!";
            }


        }

        if($operation == "update"){

            $adminId = $_POST["adminId"];
            $admin_fname = $_POST["admin_fnameUpdate"];
            $admin_lname = $_POST["admin_lnameUpdate"];
            $admin_num = $_POST["admin_numUpdate"];
            $admin_email = $_POST["admin_emailUpdate"];

            $sql = "UPDATE admins set admin_fname = '$admin_fname', admin_lname = '$admin_lname', admin_num = '$admin_num', admin_email = '$admin_email' WHERE admin_id = '$adminId'";

            if ($connection->query($sql) === TRUE) {
            } else {
                $connection->error;
            }
        }

        header("location: /asset/myDashboard/admin.php");

    } while (false);

}

    if(isset($_POST['deleteAdmin'])) {
        $id = $_POST['deleteAdmin'];
        
        $sql = "DELETE FROM admins WHERE admin_id = $id";

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
                    <h2>LIST OF ADMINS</h2>
                </div>

                <div id="popupForm" class="popup-formAdmin">
                    
                    
                    <div class = "adminFormContainer">
                        
                        <h2 id = "titleFormAdmin">Add Admin Form</h2><br>
                                
                        <form action="" method = "post" class = "formAdmin" id = "myFormSup">
                                <input type="text" placeholder = "typepost" id = "typePostAdmin" name = "postType">
                                <div class = "adminIdDisplayDiv" id = "adminIdDisplayDiv">
                                    <label for="">ID</label>
                                    <input type="text" id = "adminIdDisplay" name = "adminId">
                                </div>
                                <div class = "fillFirstRow">
                                    <label >First Name</label><br>
                                    <input type="text"  name = "admin_fname" id = "supFName"value = "<?php echo $admin_fname; ?>"><br><br>
                                    <label >Contact Number</label><br>
                                    <input type="text" id = "supNumber"value = "<?php echo $admin_num; ?>" name = "admin_num">
                                </div>
                                <div class = "fillSecondRow">
                                    <label >Last Name</label>
                                    <input type="text" id = "supLName" name = "admin_lname" value = "<?php echo $admin_lname; ?>"><br><br>
                                    <label >Email</label>
                                    <input type="email" id = "supEmail" value = "<?php echo $admin_email; ?>" name = "admin_email">
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
                            <br>
                                    <button type = "submit" id = "submitAdmin">Submit</button>
                                    <button id = "cancelSuppBut" onclick = "cancelAdmin()">Cancel</button><br>
                        </form>
                            
                    </div>
                </div>

                <div class="adminTableDisplay">

                    <table class = "adminMainTable" >

                        <thead class = "adminHeaderTable">
                            <tr >
                                <th id = "adminCol">ID</th>
                                <th id = "adminCol">FIRST NAME</th>
                                <th id = "adminCol">LAST NAME</th>
                                <th id = "adminCol">CONTACT NUMBER</th>
                                <th id = "adminCol">EMAIL</th>
                            </tr>
                        </thead>

                        <tbody  >
                
                            <?php
                               require_once('db_connector.php');


                                $sql = "SELECT * From admins WHERE admin_role = 'Instructor'";
                                $result = $connection->query($sql);

                                if(!$result){
                                    die("Invalid query: ". $connection->error);
                                }

                                while($row = $result->fetch_assoc()){
                                    echo "
                                    <tbody  class = 'table-row'>
                                        <td   id = 'laboratoryRow'>$row[admin_id]</td>
                                        <td   id = 'laboratoryRow' style = 'padding-left = 400px;'>$row[admin_fname]</td>
                                        <td   id = 'laboratoryRow'>$row[admin_lname]</td>
                                        <td   id = 'laboratoryRow'>$row[admin_num]</td>
                                        <td id = 'laboratoryRow'>$row[admin_email]</td>
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
            var editAdminBtn = document.querySelectorAll('.editAdminBtn');
            var deleteAdminBtn = document.querySelectorAll('.deleleteAdminBtn');
            let allButtons = document.querySelectorAll("#editAdminBtn, #deleleteAdminBtn,  #addButton");
            let titleOfForm = document.getElementById("titleFormAdmin");
            let AdminFNameInput = document.getElementById("supFName");
            let AdminLNameInput = document.getElementById("supLName");
            let contact_numInput = document.getElementById("supNumber");
            let emailInput = document.getElementById("supEmail");
            let idInput = document.getElementById("adminIdDisplay");
            let idDisplayDiv = document.getElementById("adminIdDisplayDiv");
            let typePost = document.getElementById("typePostAdmin");
            editAdminBtn.forEach(function(row) {
                row.addEventListener('click', function() {
                    popupForm.style.display = "block";
                    let adminFname = this.getAttribute('data-adminFname');
                    let adminLname = this.getAttribute('data-adminLname');
                    let contact_num = this.getAttribute('data-adminNumber');
                    let email = this.getAttribute('data-adminEmail');
                    let adminId = this.getAttribute('data-adminId');
                    AdminFNameInput.value = adminFname;
                    AdminLNameInput.value = adminLname;
                    contact_numInput.value = contact_num;
                    emailInput.value = email;
                    idInput.value = adminId;
                    idDisplayDiv.style.display = "block";
                    if(editable === true){
                        allButtons.forEach(function(button) {
                            button.disabled = true;
                        });
                        titleOfForm.textContent = "Update Admin Form";
                        AdminFNameInput.name = "admin_fnameUpdate";
                        AdminLNameInput.name = "admin_lnameUpdate";
                        contact_numInput.name = "admin_numUpdate";
                        emailInput.name = "admin_emailUpdate";
                        typePost.value = "update";
                        editable = false;
                    }
                });
            });
            deleteAdminBtn.forEach(function(row) {
                row.addEventListener('click', function() {
                    let id = this.getAttribute('data-adminId');
                    
                var confirmation = confirm("Confirm Delete?");
                    if (confirmation) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("deleteAdmin=" + id);

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

        function cancelAdmin(){
            let operation = document.getElementById("typePostAdmin");
            operation.value = "";
            popupForm.style.display = "none";
        }

        const addButton = document.getElementById('addButton');
        const popupForm = document.getElementById('popupForm');

        addButton.addEventListener('click', function() {
            popupForm.style.display = 'block';
            let allButtons = document.querySelectorAll("#editAdminBtn, #deleleteAdminBtn,  #addButton");
            let titleOfForm = document.getElementById("titleFormAdmin");
            let AdminFNameInput = document.getElementById("supFName");
            let AdminLNameInput = document.getElementById("supLName");
            let contact_numInput = document.getElementById("supNumber");
            let emailInput = document.getElementById("supEmail");
            let idInput = document.getElementById("adminIdDisplay");
            let idDisplayDiv = document.getElementById("adminIdDisplayDiv");
            let typePost = document.getElementById("typePostAdmin");
            AdminFNameInput.value = "";
            AdminLNameInput.value = "";
            contact_numInput.value = "";
            emailInput.value = "";
            idDisplayDiv.style.display = "none";
            allButtons.forEach(function(button) {
                button.disabled = true;
            });
            titleOfForm.textContent = "Add Admin Form";
            AdminFNameInput.name = "admin_fname";
            AdminLNameInput.name = "admin_lname";
            contact_numInput.name = "admin_num";
            emailInput.name = "admin_email";
            typePost.value = "add";
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