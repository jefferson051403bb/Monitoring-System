

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styless.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link id = "myWebIcon" rel="shortcut icon" href="images/website.png" type="image/x-icon">
   
    <title>Asset Tracking</title>

    <style>
        .table-row:hover {
            background-color: lightgray;
        }
    </style> 
</head>
<body> 
    <div class="mainDashboard">
        <div class="sideBar" id="sideBar">
            <h1 id="title">ASSET <span style = "color:black; font-size: 40px; ">TRACKING</span></h1>
            <div class="sideBar_menus">
            <ul class="menu_list" id="menu_list">
                    <li>
                        <a href="http://localhost/asset/myDashboard/dashboard.php?admin=harfeil"> <i class="fa fa-envelope-open"></i>
                        <h5 id = "dashboardText" class = "textLink">Dashboard</h5></i> </a>
                    </li>
                    <li>
                        <a href="http://localhost/asset/myDashboard/supplierTable.php?admin=harfeil"><i class="fa fa-users"></i>
                        <h5 id = "supplierText" class = "textLink">Supplier</h5></i> </a>
                    </li>
                    <li>
                        <a href="http://localhost/asset/myDashboard/laboratory.php?admin=harfeil"><i class="fa fa-th-large" aria-hidden="true"></i></i><h5 id = "laboratoryText" class = "textLink">Laboratory</h5></a>
                    </li>
                    <li>
                        <a href="http://localhost/asset/myDashboard/asset.php?admin=harfeil"><i class="fa fa-object-group" aria-hidden="true"></i> <h5 id = "assetText" class = "textLink">Assets</h5></a>
                    </li>
                    <li>
                        <a href="http://localhost/asset/myDashboard/admin.php?admin=harfeil"><i class="fas fa-user"></i><h5 id = "adminText" class = "textLink">Laboratory Admin</h5></a>
                        
                    </li>
                    <li>
                        <a href="http://localhost/asset/myDashboard/assetHistoryPage.php?admin=harfeil"><i class="fas fa-history"></i><h5 id = "assetHistoryTxt" class = "textLink">Asset History</h5></a>
                        
                    </li>
                </ul>   
            </div>
        </div>
        