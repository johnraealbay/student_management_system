
<h4>Admin Profile</h4>
<p class="text-muted">Admin: <?= $_SESSION['username']; ?></p>

<div class="row mt-4">

    <!-- PROFILE CARD -->
    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <img src="img/profile.jpg" class="rounded-circle mb-3" width="120" alt="Admin">

                <h5><?= $_SESSION['username']; ?></h5>
                <p class="text-muted mb-1">Administrator</p>
                <p class="text-muted">admin@email.com</p>

                <button class="btn btn-primary">Change Photo</button>
            </div>
        </div>
    </div>

    <!-- PROFILE DETAILS -->
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">

                <h5 class="mb-3">Profile Information</h5>

                <form method="POST">

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text"
                               class="form-control"
                               value="<?= $_SESSION['username']; ?>"
                               disabled>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email"
                               class="form-control"
                               placeholder="admin@email.com">
                    </div>

                    <hr>

                    <h6>Change Password</h6>

                    <div class="mb-3">
                        <input type="password"
                               class="form-control"
                               placeholder="Current Password">
                    </div>

                    <div class="mb-3">
                        <input type="password"
                               class="form-control"
                               placeholder="New Password">
                    </div>

                    <div class="mb-3">
                        <input type="password"
                               class="form-control"
                               placeholder="Confirm New Password">
                    </div>

                    <button class="btn btn-primary">
                        Update Profile
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>