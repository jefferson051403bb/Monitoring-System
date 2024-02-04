<?php

    include "templates/header.php";

?>
        <div class="content" id="content">
            <div class="topbar">
                <a href="" id="togglebtn"><ion-icon name="menu-outline"></ion-icon></a>
                <a class="logout"><ion-icon name="log-out-outline"></ion-icon></a>
            </div>
            <div class="display">
                <h2 class = "assetActivtitiesTitle">RECENT ACTIVITIES</h2>

                    <div class="historyAssetDisplay">

                        <table class = "" id = "">

                            <thead class = "assetHistoryVos">
                                <tr id = "assetHistoryCol">
                                    <th class = "rowHistory" id = "rowHistory">HISTORY NAME</th>
                                    <th class = "rowHistory">DEVICE TYPE</th>
                                    <th class = "rowHistory">STATUS</th>
                                    <th class = "rowHistory">ASSIGNED TO</th>
                                    <th class = "rowHistory">DATE</th>
                                </tr>
                            </thead>
                            <tbody  class = "bodyTableAssetHistory">
                    
                                <?php
                                require_once('db_connector.php');


                                    $sql = "SELECT transaction_table.trans_id as trans_id, transaction_table.asset_id as asset_id, transaction_table.lab_id as lab_id, transaction_table.sup_id as sup_id, transaction_table.asset_stat as asset_status,transaction_table.trans_date as trans_date, assets.asset_type as asset_type, assets.asset_quant as asset_quant, assets.asset_brand as asset_brand, assets.asset_desc as asset_desc,  CONCAT(supplier.sup_fname, ' ', supplier.sup_lname) as suplFulName,supplier.company_name as company_name, laboratories.lab_name as assign_lab FROM transaction_table INNER JOIN assets ON transaction_table.asset_id = assets.asset_id INNER JOIN laboratories ON transaction_table.lab_id = laboratories.lab_id INNER JOIN supplier ON transaction_table.sup_id = supplier.sup_id";

                                    $sqlRequest = "SELECT request_asset.req_id as req_id, request_asset.req_name as req_name, request_asset.req_status as req_status, request_asset.quantity_asset as quantity, request_asset.lab_id as lab_id, request_asset.req_date as req_date, laboratories.lab_name as labname FROM request_asset INNER JOIN laboratories ON request_asset.lab_id = laboratories.lab_id";
                                    $resultReq = $connection->query($sqlRequest);

                                   
                                    $result = $connection->query($sql);

                                    if(!$result){
                                        die("Invalid query: ". $connection->error);
                                    }

                                    while($rowReq = $resultReq->fetch_assoc()){
                                        echo "
                                        <tbody  class = 'table-row'>
                                            <td  id = 'laboratoryRow'>Request Asset</td>
                                            <td id = 'laboratoryRow' >$rowReq[req_name]</td>
                                            <td  id = 'laboratoryRow'>$rowReq[req_status]</td>
                                            <td  id = 'laboratoryRow'>$rowReq[labname]</td>
                                            <td  id = 'laboratoryRow'>$rowReq[req_date]</td>
                                        ";
                                        echo '</tr>';
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "
                                        <tbody class = 'table-row' data-company = '$row[company_name]', data-assetBrand = '$row[asset_brand]' data-status = '$row[asset_status]' data-contactSup = '$row[suplFulName]'data-description = '$row[asset_desc]' data-assetType = '$row[asset_type]'>
                                            <td  id = 'laboratoryRow'>Transfer Asset</td>
                                            <td  id = 'laboratoryRow'>$row[asset_type]</td>
                                            <td id = 'laboratoryRow' >$row[asset_status]</td>
                                            <td  id = 'laboratoryRow'>$row[assign_lab]</td>
                                            <td id = 'laboratoryRow'>$row[trans_date]</td>
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
 
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
          

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