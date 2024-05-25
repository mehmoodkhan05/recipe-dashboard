<?php
include "navbar.php";
include "db/connection.php";
include "sidebar.php";

if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $sql = "SELECT * FROM `users` WHERE `user_id` = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
}
?>

<head>
    <style>
        .main-panel {
            margin-top: 100px;
        }

        .modal-body img {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-panel">
        <h2 class="text-center">Users</h2>
            <div class="row justify-content-end">
                <div class="col-10">
                    <div class="add_user-btn justify-content-end d-flex mb-3">
                        <a href="add-user.php" class="btn btn-primary">Add User</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>email</th>
                                            <th>phone</th>
                                            <th>name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `users`";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row["user_id"] ?></td>
                                                <td><?php echo $row["email"] ?></td>
                                                <td><?php echo $row["phoneNumber"] ?></td>
                                                <td><?php echo $row["name"] ?></td>
                                                <td>
                                                    <a href="#" data-id="<?php echo $row["user_id"] ?>" data-toggle="modal"
                                                        data-target="#userModal" class="view-user text-decoration-none">
                                                        <i class="fa-solid fa-eye me-2"></i>
                                                    </a>
                                                    <a href="edit.php?user_id=<?php echo $row["user_id"] ?>"
                                                        class="text-success text-decoration-none">
                                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                                    </a>
                                                    <a href="delete.php?user_id=<?php echo $row["user_id"] ?>"
                                                        class="text-danger text-decoration-none">
                                                        <i class="fa-solid fa-trash me-2"></i>
                                                    </a>
                                                    <!-- <a href="?user_id=<?php // echo $row["user_id"] ?>"
                                                        class="text-decoration-none" title="Recipes">
                                                        <i class="fa-solid fa-eye me-2"></i>
                                                    </a>
                                                    <a href="?user_id=<?php // echo $row["user_id"] ?>"
                                                        class="text-decoration-none" title="Allergies">
                                                        <i class="fa-solid fa-eye me-2"></i>
                                                    </a>
                                                    <a href="?user_id=<?php // echo $row["user_id"] ?>"
                                                        class="text-decoration-none" title="Dietary Restriction">
                                                        <i class="fa-solid fa-eye "></i>
                                                    </a> -->
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title text-center" id="userModalLabel">User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user_img text-center mb-4">
                        <img src="assets/img/user.png" alt="" class="img-fluid rounded-circle">
                        <!-- <img src="" alt="" class="img-fluid rounded-circle"> -->
                    </div>
                    <form action="" method="">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalEmail">Email</label>
                                    <input type="text" class="form-control" id="modalEmail" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalPhone">Phone</label>
                                    <input type="text" class="form-control" id="modalPhone" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalLocationLatitude">Location Latitude</label>
                                    <input type="text" class="form-control" id="modalLocationLatitude" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalLocationLongitude">Location Longitude</label>
                                    <input type="text" class="form-control" id="modalLocationLongitude" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalName">Name</label>
                                    <input type="text" class="form-control" id="modalName" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalType">Type</label>
                                    <input type="text" class="form-control" id="modalType" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalToken">Token</label>
                                    <input type="text" class="form-control" id="modalToken" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalDescriptions">Descriptions</label>
                                    <input type="text" class="form-control" id="modalDescriptions" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="modalCoins">Coins</label>
                                    <input type="text" class="form-control" id="modalCoins" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary">Allergies</a>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-user').forEach(function (element) {
                element.addEventListener('click', function (event) {
                    event.preventDefault();
                    var userId = this.getAttribute('data-id');

                    // Make an AJAX call to fetch user data
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'get-users.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            var user = JSON.parse(xhr.responseText);

                            if (!user.error) {
                                // Populate the modal fields with user data
                                document.getElementById('modalEmail').value = user.email;
                                document.getElementById('modalPhone').value = user.phoneNumber;
                                document.getElementById('modalLocationLatitude').value = user.locationLatitude || '';
                                document.getElementById('modalLocationLongitude').value = user.locationLongitude || '';
                                document.getElementById('modalName').value = user.name;
                                document.getElementById('modalType').value = user.type || '';
                                document.getElementById('modalToken').value = user.token || '';
                                document.getElementById('modalDescriptions').value = user.description || '';
                                document.getElementById('modalCoins').value = user.coins || '';
                                document.getElementById('modalImage').src = user.image || 'assets/img/user.png';
                            } else {
                                alert('User not found');
                            }
                        }
                    };
                    xhr.send('user_id=' + userId);
                });
            });
        });
    </script>
</body>