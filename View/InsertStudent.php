<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Them sinh vien</title>
    <style>
        form > div label {
            font-size: 15px;
            font-weight: 500;
        }

        form > div label::after{
            content: "*";
            color: red;
        }

        form > div input {
            width: 75%;
            padding: 10px;
            border: none;
            outline: none;
            background: transparent;
            border-bottom: 1.5px solid var(--primary--color);
            color: #000;
            font-size: 16px;
        }
    </style>
    <script>
        function checkIDNV() {
            var idnv = document.getElementById('idnv').value;
            if (idnv) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'checkID.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.responseText === 'tontai') {
                        alert('Mã Nhân Viên đã tồn tại! Vui lòng nhập mã khác.');
                        document.getElementById('idnv').value = ''; 
                    }
                };
                xhr.send('idnv=' + idnv);
            }
        }
    </script>
</head>
<body>
    <h2>Add student</h2>
    <form action="checkID.php" method="POST">
        <div>
            <label for="">ID</label>
            <input type="text" name="id" id="idhv" onblur="checkIDNV()" require>
        </div>
        <div>
            <label for="">Name</label>
            <input type="text" name="name" id="" require>
        </div>
        <div>
            <label for="">Age</label>
            <input type="text" name="age" id="" require>
        </div>
        <div>
            <label for="">University</label>
            <input type="text" name="university" id="" require>
        </div>
    </form>
</body>
</html>