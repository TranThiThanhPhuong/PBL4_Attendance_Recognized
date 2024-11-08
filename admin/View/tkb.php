<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thời Khóa Biểu</title>
    <link rel="stylesheet" href="style.css">
    <style>
                /* style.css */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f6f9;
            color: #333;
        }

        h1 {
            margin-top: 20px;
        }

        .timetable table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        thead {
            background-color: #4CAF50;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }

        td {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Thời Khóa Biểu</h1>
    <div class="timetable">
        <table>
            <thead>
                <tr>
                    <th>Thời Gian</th>
                    <th>Thứ Hai</th>
                    <th>Thứ Ba</th>
                    <th>Thứ Tư</th>
                    <th>Thứ Năm</th>
                    <th>Thứ Sáu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>8:00 - 9:30</td>
                    <td>Toán</td>
                    <td>Văn</td>
                    <td>Lý</td>
                    <td>Hóa</td>
                    <td>Sinh</td>
                </tr>
                <tr>
                    <td>9:45 - 11:15</td>
                    <td>Tiếng Anh</td>
                    <td>Toán</td>
                    <td>Văn</td>
                    <td>Lý</td>
                    <td>Hóa</td>
                </tr>
                <tr>
                    <td>13:00 - 14:30</td>
                    <td>Sinh</td>
                    <td>Hóa</td>
                    <td>Tiếng Anh</td>
                    <td>Toán</td>
                    <td>Văn</td>
                </tr>
                <tr>
                    <td>14:45 - 16:15</td>
                    <td>Lý</td>
                    <td>Sinh</td>
                    <td>Hóa</td>
                    <td>Tiếng Anh</td>
                    <td>Toán</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
