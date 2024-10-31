<div class="user">
    <div class="user-div">
        <img src="../image/logostudent.png">
        <div class="user-div1">
            <?php
                $query = 'SELECT username FROM admin';
                $connection = $conn->query($query);
                if ($connection) {
                    $result = $connection->fetch_assoc();
                    if ($result) {
                        echo '<p>' . htmlspecialchars($result['username']) . '</p>';
                    } else {
                        echo '<p>No results found.</p>';
                    }
                } else {
                    echo '<p>Error in query: ' . htmlspecialchars($conn->error) . '</p>';
                }
            ?>
            <small>Admin</small>
        </div>
    </div>
    <button>Profile</button>
</div>