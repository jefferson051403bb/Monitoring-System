<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Apply a fixed height to the table container */
        .table-container {
            max-height: 900px; /* Adjust the height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        /* Optional: Style for the table */
        table {
            width: 100%;
            border-collapse: collapse; /* Optional: Collapse table borders */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <!-- Table Container with Vertical Scroll -->
    <div class="table-container">
        <!-- Your Table -->
        <table id="myTable">
            <thead>
                <tr>
                    <th>Header 1</th>
                    <th>Header 2</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Table Rows with Data -->
                <tr>
                    <td>Data 1</td>
                    <td>Data 2</td>
                    <!-- Add more data cells as needed -->
                </tr>
                <!-- Add more rows with data as needed -->
            </tbody>
        </table>
    </div>

    <!-- JavaScript to add new rows -->
    <script>
        function addRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = "New Data 1";
            cell2.innerHTML = "New Data 2";
            
            // Update the table container height
            var tableContainer = document.querySelector(".table-container");
            tableContainer.scrollTop = tableContainer.scrollHeight; // Scroll to the bottom
        }
    </script>

    <!-- Button to add a new row -->
    <button onclick="addRow()">Add Row</button>

</body>
</html>