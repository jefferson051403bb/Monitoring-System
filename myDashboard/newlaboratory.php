<?php

// require_once('db_connector.php');

// $sql = "";
// $name = "";
// $admin = "";

// $errorMessage = "";
// $successMessage = "";

// if(isset($_GET['name']) && isset($_GET['admin'])){

//     $name = $_GET["name"];
//     $admin = $_GET["admin"];

//     do {
        
//         if(empty($name) ||  empty($admin)){
//             $errorMessage = "Fill Up All Fields";
//             break;
//         }

//         $sql = "INSERT INTO laboratories (name, admin) VALUES ('$name', '$admin')";
//         $result = $connection->query($sql);

//         if(!$result){
//             $errorMessage = 'Invalid Query: ' .$connection->error;
//             break;
//         }


        
//         $name = "";
//         $admin = "";

//         $successMessage = "Added Successfully";

//         header("location: /asset/myDashboard/newlaboratory.php");

//     } while (false);

// }
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your username
$password = "";
$dbname = "asset_tracking"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
  $tableName = $_POST['name'];

  // Predefined attributes
  $attribute1 = "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY";
  $attribute2 = "asset_name VARCHAR(30) NOT NULL";
  $attribute3 = "asset_type VARCHAR(30) NOT NULL";
  $attribute4 = "asset_status VARCHAR(30) NOT NULL";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // SQL statement to create a table
  $sql = "CREATE TABLE IF NOT EXISTS $tableName (
    $attribute1,
    $attribute2,
    $attribute3,
    $attribute4
  )";

  if ($conn->query($sql) === TRUE) {
    // echo "Table '$tableName' created successfully";
  } else {
    // echo "Error creating table: " . $conn->error;
  }

  $conn->close();
} else {
  // echo "Invalid data or method";
}



// if (isset($_POST['deleteLab'])) {

//     $id_to_delete = $_POST["deleteId"]; // ID of the div to be deleted

//     // Delete query
//     $sql = "DELETE FROM laboratories WHERE id = $id_to_delete"; // Modify according to your table schema
//     $result = $connection->query($sql);

//     if(!$result){
//         $errorMessage = 'Invalid Query: ' .$connection->error;

//     }
    
// }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newtyles.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   
    <title>Dashboard</title>

</head>
<body>
    
    <div class="mainDashboard">
        <div class="sideBar" id="sideBar">
            <h1 id="title">ASSET TRACKING</h1>
            <div class="dashboard_sidebar">
            </div>
            <div class="sideBar_menus">
                <ul class="menu_list" id="menu_list">
                    
                    <li>
                    <a href="http://localhost/asset/myDashboard/dashboard.php" class = "myLinks"><i class="fa fa-envelope-open"></i></i> <span class="text">DASHBOARD</span>
                    </a>
                    </li>
                    <li>
                        <a href="" class = "myLinks"><i class="fa fa-users" ></i> <span class= "text" >ADD SUPPLERS</span></a>
                    </li>
                   
                    <li>
                    <a href="http://localhost/asset/myDashboard/laboratory.php" class = "myLinks"><i class="fa fa-th-large" aria-hidden="true"></i></i> <span class = "text">ADD LABORATORY</span>
                    </a>
                    </li>
                    <li>
                        <a href="" class = "myLinks"><i class="fa fa-object-group" aria-hidden="true"></i> <span class="text" >ADD ASSETS</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content" id="content">
            <div class="topbar">
                <a href="" id="togglebtn"><ion-icon name="menu-outline"></ion-icon></a>
                <a class="logout"><ion-icon name="log-out-outline"></ion-icon></a>
            </div>
            <div class="display">
                
                <a href="http://localhost/myDashboard/laboratory.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <h3 id = "h1">ADD LABORATORY</h3>
                <button id = "myButton"> ADD LABORATORY</button>

                <div id = "laboratoryForm-hidden">

                    <div class = "formContainer">
                        <form  method="post" id = "myFillupForm">
                        <label >Laboratory Name:</label>
                            <!-- <input type="text" class = "form-control" name = "name" value = ""> -->
                            <input type="text" id="tableName" placeholder="Enter Laboratory name" class = "add" name = "name"  required><br><br>
                            <label >Administrator:</label>
                            <input type="text" id="adminName" placeholder="Enter Admin name" class = "add" name ="admin"   required><br><br>
                            
                            <button onclick = "createDiv() " name=  "addLaboratory" id = "addBtnLab">Create Laboratory</button>
                        </form>
                        
                    </div>
                    

                </div>
                 <div id="editLaboratoryForm-hidden">
                    <div class = "editContainer" id = "editForm">
                            <form method="post">
                                <label for="editTableName">Table Name:</label>
                                <input type="text" name="editTableName" id="editTableName" placeholder="Enter new table name" class = "add"><br><br><br>
                                <input type="submit" name="editTable" id = "editSave" value = "Save">
                            </form>
                    </div>
                </div>

                <!-- <div id="deleteLaboratory-hidden">
                    <div class = "deleteLab" id = "deleteLabor">
                
                            <form method="post">
                                <label for="laboratoryId" >Laboratory ID:</label>
                                <input type = "text"name = "deleteId" id = "laboratoryId" 
                                ><br><br>
                                <label for="editTableName">Table Name:</label>
                                <input type="text" name="editTableName" id="deleteLabName" class = "add" ><br><br><br>
                                <input type="submit" name="deleteLab" id = "editSave" value = "Confirm Delete?">
                            </form>
                    </div>
                </div>  -->

                <div class="container" id = "container">
                    
                    <br>
                </div>

                <div id="popupFormAsset" class="popup-formAsset">
                   
                   <button id = "cancelSuppBut" onclick = "cancelSupBut()">Cancel</button><br>
                   
                   <div class = "suppFormContainer">
                       
                       <h2>Add Asset Form</h2><br>
                               
                       <form action="" method = "post" id = "myFormAsset">

                           <div class = "row mb-3">
                               <label class = "col-sm-3 col-form-label">Name</label>
                               <div class = "col-sm-6">
                                   <input type="text" class = "form-control" name = "name" value = "<?php echo $name; ?>">
                               </div>
                           </div>
                           <div class = "row mb-3">
                               <label class = "col-sm-3 col-form-label">Type</label>
                               <div class = "col-sm-6">
                                   <select id="optionsAsset" name = "type">
                                       <optgroup label="Select Type">
                                           <option >External</option>
                                           <option >Internal</option>
                                       </optgroup>
                                   </select>
                               </div>
                           </div>
                           <div class = "row mb-3">
                               <label class = "col-sm-3 col-form-label">Status</label>
                               <div class = "col-sm-6">
                               <select id="optionsAsset" name = "status">
                                       <optgroup label="Select Status">
                                           <option >New</option>
                                           <option >Old</option>
                                       </optgroup>
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

                           <div class = "row mb-3">
                               <div class = "col-sm-6">
                                   <button type = "submit" class = "btn btn-primary">Submit</button>
                               </div>
                           </div>


                       </form>

            </div>
            
           
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js">
    </script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js">
    </script>
    <script>

        // Laboratory fill up form
        var labForm = document.getElementById("laboratoryForm-hidden");
        var editForm = document.getElementById("editLaboratoryForm-hidden");
        function formHide(){
            var className = document.getElementById("tableName");
            if (labForm.style.display === 'block') {
                labForm.style.display = 'none';
                editForm.style.display = 'none';
                deleteForm.style.display = 'none';
            } else {
                labForm.style.display = 'block';
                editForm.style.display = 'none';
            }
            
        }

        myButton.addEventListener('click', formHide);
        // end of laboratory fill up

        // Toggle Sidebar
        var sideBarToggle = true;

        togglebtn.addEventListener('click', (event) =>{
            event.preventDefault();

            if(sideBarToggle){
                sideBar.style.width = '5%';
                title.style.display = 'none';
                user.style.display = 'none';
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
                user.style.display = 'inline-block';
                content.style.width = '85%';
                menu_list.style.marginTop = "40px";

                menuIcons = document.getElementsByClassName('text');
                for(let i =0; i<menuIcons.length; i++){
                    menuIcons[i].style.display = 'inline-block';
                }
                sideBarToggle = true; 
            }
            
        });

        // document.getElementById('addBtnLab').addEventListener('submit', function(event) {
        //   event.preventDefault(); // Prevents form submission
        // });

        
    let divCount = 0;

    window.onload = function() {
      const savedDivs = JSON.parse(localStorage.getItem('savedDivs'));
      if (savedDivs) {
        savedDivs.forEach(div => {
          createDivFromStorage(div);
        });
        attachButtonListeners();
      }
    };

      function createDiv() {
        const divNameInput = document.getElementById('tableName');
        const divName = divNameInput.value.trim();

        if (divName !== '') {
          divCount++;

          const newDiv = document.createElement('div');
          newDiv.setAttribute('id', `div${divCount}`);
          newDiv.classList.add('newLab'); 
          newDiv.innerHTML = `
            <p class = "labName">${divName}</p>
            <button class="enterBtn">Enter Laboratory</button>
            <button class="editBtn">Edit</button>
            <button class="deleteBtn">Delete</button>
          `;

          const divContainer = document.getElementById('container');
          divContainer.appendChild(newDiv);

      
          attachButtonListeners();
          saveDivsToLocalStorage();
          divNameInput.value = '';
        } else {
          alert('Please enter a name for the div.');
        }
      }

    function createDivFromStorage(div) {
      const newDiv = document.createElement('div');
      newDiv.setAttribute('id', div.id);
      newDiv.classList.add('newLab');
      newDiv.innerHTML = `
        <p class = "labName">${div.name}</p>
        <button class="enterBtn">Enter Laboratory</button>
        <button class="editBtn">Edit</button>
        <button class="deleteBtn">Delete</button>
      `;

      const divContainer = document.getElementById('container');
      divContainer.appendChild(newDiv);
    }
      
    

    function attachButtonListeners() {
        var editForm = document.getElementById("editLaboratoryForm-hidden");
        const editButtons = document.querySelectorAll('.editBtn');
        
        const enterBtn = document.querySelectorAll('.enterBtn');
        enterBtn.forEach(button => {
        button.addEventListener('click', function() {
          const divId = this.parentNode.id;
          const divToEnter = document.getElementById(divId);
          if (divToEnter) {
            const divName = divToEnter.querySelector('p').textContent;
            alert(divName);
          }
        });
      });

      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          const divId = this.parentNode.id;
          const inputField = document.getElementById('editTableName');
          const divToEdit = document.getElementById(divId);
          if (divToEdit) {
            editForm.style.display = "block";
            const divName = divToEdit.querySelector('p').textContent;
            inputField.value = divName;
            inputField.dataset.targetDiv = divId;
          }
        });
      });

      const deleteButtons = document.querySelectorAll('.deleteBtn');
      deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
          const divId = this.parentNode.id;
          const divToDelete = document.getElementById(divId);
          if (divToDelete) {
            divToDelete.remove();
            // saveDivsToLocalStorage();
          }
        });
      });
    }

    function saveDivsToLocalStorage() {
      const divContainer = document.getElementById('container');
      const divs = divContainer.querySelectorAll('.newLab'); // Selecting by class 'newLab'
      const savedDivs = [];

       divs.forEach(div => {
        savedDivs.push({
          id: div.id,
          name: div.querySelector('p').textContent
        });
      });

      localStorage.setItem('savedDivs', JSON.stringify(savedDivs));
    }

    </script>
     
</body>
</html>