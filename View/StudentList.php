<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
            min-width: 100%;
            overflow: hidden;
            border-radius: 5px 5px 0 0;
        }

        .table thead tr {
            color: #fff;
            background: var(--primary--color);
            text-align: left;
            font-weight: bold;
        }

        .table th, .table td{
            padding: 12px 15px;
        }
        
        .table tbody tr{
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>University</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 1; $i <= sizeof($studentList); $i++){
                echo '<tr>';
                echo '<td>'.$studentList[$i]->id.'</td>';
                echo '<td>'.$studentList[$i]->name.'</td>';
                echo '<td>'.$studentList[$i]->age.'</td>';
                echo '<td>'.$studentList[$i]->university.'</td>';
                echo '</tr>';
            }
                                               
            ?>
        </tbody>
    </table>
</body>
</html>