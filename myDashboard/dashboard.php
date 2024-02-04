<?php
require_once('db_connector.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sqlLab = "SELECT COUNT(*) as name  FROM laboratories";
$sqlAsset = "SELECT COUNT(*) as name  FROM transaction_table";
$sqlBroken = "SELECT COUNT(*) as broken  FROM transaction_table WHERE asset_stat = 'broken'";
$sqlSupp = "SELECT COUNT(*) as fname  FROM supplier";
$sqlAdmin = "SELECT COUNT(*) as admin  FROM admins";

$result = $connection->query($sqlLab);
$resultAsset = $connection->query($sqlAsset);
$resultBroken = $connection->query($sqlBroken);
$resultSupp = $connection->query($sqlSupp);
$resultAdmin = $connection->query($sqlAdmin);

if ($result) {
    $row = $result->fetch_assoc();
    $totalCountLab = $row['name'];
}
if ($resultBroken) {
    $row = $resultBroken->fetch_assoc();
    $totalCountBroken = $row['broken'];
}
if ($resultAsset) {
    $row = $resultAsset->fetch_assoc();
    $totalCountAsset = $row['name'];
}
if ($resultSupp) {
    $row = $resultSupp->fetch_assoc();
    $totalCountSupplier = $row['fname'];
} 
if ($resultAdmin) {
    $row = $resultAdmin->fetch_assoc();
    $totalCountAdmin = $row['admin'];
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

                <div class = "threeMainContainer">

                    <div class = "totalLaboratoryDisplay" id = "totalLaboratoryDisplay">
                        <h6>TOTAL LABORATORY</h6>
                        <div class = "countDisplayLab">
                            <h1><?php echo $totalCountLab; ?></h1>
                        </div>
                    </div>
                    <div class = "totalAssetDisplay" id = "totalAssetDisplay">
                        <h6>TOTAL OVERALL ASSET</h6>
                        <div class = "countDisplayAsset">
                            <h1><?php echo $totalCountAsset; ?></h1>
                        </div>
                    </div>
                    <div class = "totalSupplierDisplay" id = "totalSupplierDisplay">
                        <h6>TOTAL SUPPLIER</h6>
                        <div class = "countDisplaySupp">
                            <h1><?php echo $totalCountSupplier  ; ?></h1>
                        </div>
                    </div>
                    <div class = "totalBrokenDisplay" id = "totalBrokenDisplay">
                        <h6>TOTAL BROKEN ASSETS</h6>
                        <div class = "countDisplayBrok">
                            <h1><?php echo $totalCountBroken; ?></h1>
                        </div>
                    </div>
                    <div class = "totalAdminDisplay" id = "totalAdminDisplay">
                        <h6>TOTAL ADMIN</h6>
                        <div class = "countDisplayAdm">
                            <h1><?php echo $totalCountAdmin; ?></h1>
                        </div>
                    </div>
                </div>


                    <div class = "dashboardTableContainer">

                        <div class = "totalAssetTableDashboard" id = "totalAssetTableDashboard">
                        <button id = "viewAllAssetDashboard">View All</button>
                        <h4 id = "assetTotalTitleDashboard">ASSETS</h4>
                            <table class = "dashboardTables" >

                                <thead >
                                    <tr id = "dashboardColumn">
                                    <th >ID</th>
                                        <th class = "dashboardColName">DEVICE TYPE</th>
                                        <th class = "dashboardColName">BRAND</th>
                                        <th class = "dashboardColName">STATUS</th>
                                    </tr>
                                </thead>

                                <tbody  >

                                <?php
                                    require_once('db_connector.php');


                                        $sql = "SELECT transaction_table.trans_id as trans_id, transaction_table.asset_id as asset_id, transaction_table.lab_id as lab_id, transaction_table.sup_id as sup_id, transaction_table.asset_stat as asset_status, assets.asset_type as asset_type, assets.asset_quant as asset_quant, assets.asset_brand as asset_brand, assets.asset_desc as asset_desc,  CONCAT(supplier.sup_fname, ' ', supplier.sup_lname) as suplFulName,supplier.company_name as company_name, laboratories.lab_name as assign_lab FROM transaction_table INNER JOIN assets ON transaction_table.asset_id = assets.asset_id INNER JOIN laboratories ON transaction_table.lab_id = laboratories.lab_id INNER JOIN supplier ON transaction_table.sup_id = supplier.sup_id";
                                    
                                        $result = $connection->query($sql);

                                        if(!$result){
                                            die("Invalid query: ". $connection->error);
                                        }

                                        while($row = $result->fetch_assoc()){
                                            echo "
                                            <tbody>
                                                <td id = 'assetDashboardRow'>$row[trans_id]</td>
                                                <td id = 'assetDashboardRow'>$row[asset_type]</td>
                                                <td id = 'assetDashboardRow'>$row[asset_brand]</td>
                                                <td id = 'assetDashboardRow'>$row[asset_status]</td>
                                            ";
                                            echo '</tr>';
                                        }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                        
                        <!-- <button id = "viewAllAssetDashboard">VIEW ALL</button> -->
                        <div class = "totalLaboratoryTableDashboard">
                        <button id = "viewAllAssetDashboard">View All</button>
                        <h4 id = "assetTotalTitleDashboard">LABORATORY</h4>
                            <table class = "laboratoryDashboardDisplay"  id = "" >

                                <thead >
                                    <tr class = "laboratoryColumnMain" id = "dashboardColumn">
                                        <th class = "dashboardColName">ID</th>
                                        <th class = "dashboardColName">LABORATORY NAME</th>
                                        <th class = "dashboardColName">ADMIN</th>
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
                                                <tr >
                                                    <td id = 'labDashRow' >$row[lab_id]</td>
                                                    <td  id = 'labDashRow' >$row[lab_name]</td>
                                                    <td id = 'labDashRow' >  $row[full_name]</td>
                                                </tr>
                                                </tbody >
                                                "; 
                                            }
                                        ?>

                                </table>
                            </div>
                            
                    </div>
                    <div class = "secondDashboardTableContainer">
                        <div class = "totalAdminTableDashboard"> 
                            <button id = "viewAllAssetDashboard">View All</button>
                        <h4 id = "assetTotalTitleDashboard">ADMIN</h4>
                            <table class = "adminTableDashboard" >

                                <thead >
                                    <tr class = "dashboardColName"id = "dashboardColumn">
                                        <th class = "dashboardColName" id = "dashboardColName">ID</th>
                                        <th class = "dashboardColName" id = "dashboardColName">FIRST NAME</th>
                                        <th class = "dashboardColName" id = "dashboardColName">LAST NAME</th>
                                        <th class = "dashboardColName" id = "dashboardColName">EMAIL</th>
                                    </tr>
                                </thead>

                                <tbody  >

                                    <?php
                                    require_once('db_connector.php');


                                        $sql = "SELECT * From admins";
                                        $result = $connection->query($sql);

                                        if(!$result){
                                            die("Invalid query: ". $connection->error);
                                        }

                                        while($row = $result->fetch_assoc()){
                                            echo "
                                            <tbody >
                                                <td  id = 'assetDashboardRow'>$row[admin_id]</td>
                                                <td   id = 'assetDashboardRow'>$row[admin_fname]</td>
                                                <td   id = 'assetDashboardRow'>$row[admin_lname]</td>
                                                <td   id = 'assetDashboardRow'>$row[admin_email]</td>
                                            ";
                                            echo '</tr>';
                                        }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                        <div class = "totalSupplierDashboard"><button id = "viewAllAssetDashboard">View All</button>
                        <h4 id = "assetTotalTitleDashboard">SUPPLIER</h4>
                            <table class = "totalSupplierDashboardTable" >

                                <thead >
                                    <tr class = "suppColDashboard"id = "dashboardColumn">
                                        <th class = "dashboardColName" id = "suppDashCol">ID</th>
                                        <th class = "dashboardColName" id = "suppDashCol">COMPANY NAME</th>
                                        <th class = "dashboardColName" id = "suppDashCol">FIRST NAME</th>
                                        <th class = "dashboardColName" id = "suppDashCol">LAST NAME</th>
                                        <th class = "dashboardColName" id = "suppDashCol">EMAIL</th>
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
                                            <tbody >
                                                <td   id = 'assetDashboardRow'>$row[sup_id]</td>
                                                <td  id = 'assetDashboardRow'>$row[company_name]</td>
                                                <td   id = 'assetDashboardRow'>$row[sup_fname]</td>
                                                <td   id = 'assetDashboardRow'>$row[sup_lname]</td>
                                                <td  id = 'assetDashboardRow'>$row[email]</td>
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

        totalLaboratoryDisplay.addEventListener("click" , function (){
            window.location.href = "http://localhost/asset/myDashboard/laboratory.php";
        });
        totalAssetDisplay.addEventListener("click" , function (){
            window.location.href = "http://localhost/asset/myDashboard/asset.php";
        });
        totalSupplierDisplay.addEventListener("click" , function (){
            window.location.href = "http://localhost/asset/myDashboard/supplierTable.php";
        });
        totalBrokenDisplay.addEventListener("click" , function (){
            window.location.href = "http://localhost/asset/myDashboard/supplierTable.php";
        });
        totalAdminDisplay.addEventListener("click" , function (){
            window.location.href = "http://localhost/asset/myDashboard/admin.php";
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