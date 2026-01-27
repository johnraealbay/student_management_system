<?php
include "pages/config/coursedb.php";

/* ADD COURSE */
if (isset($_POST['add_course'])) {
    $code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $name = mysqli_real_escape_string($conn, $_POST['course_name']);

    mysqli_query($conn, "INSERT INTO courses (course_code, course_name) VALUES ('$code', '$name')");
    header("Location: ?page=course&success=1");
    exit();
}

/* UPDATE COURSE */
if (isset($_POST['update_course'])) {
    $id   = mysqli_real_escape_string($conn, $_POST['id']);
    $code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $name = mysqli_real_escape_string($conn, $_POST['course_name']);

    $sql = "UPDATE courses SET course_code = '$code', course_name = '$name' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ?page=course&updated=1");
        exit();
    } else {
        echo mysqli_error($conn);
    }
}

/* DELETE COURSE */
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM courses WHERE id='$id'");
    header("Location: ?page=course&deleted=1");
    exit();
}

/* FETCH COURSES */
$result = mysqli_query($conn, "SELECT * FROM courses");
?>

<!-- ALERTS -->
<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">Added successfully</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
<div class="alert alert-warning">Updated successfully</div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-danger">Deleted successfully</div>
<?php endif; ?>

<h4>Courses</h4>
<p class="text-muted">Admin: <?= $_SESSION['username']; ?></p>

<div class="container-fluid">

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"><i class="bi bi-plus-circle"></i> Add Course</button>
    </div>

    <!--- TABLE --->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['course_code'] ?></td>
                            <td><?= $row['course_name'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCourseModal<?= $row['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <a href="?page=course&delete=<?= $row['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this course?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No courses found
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD COURSE MODAL -->
<div class="modal fade" id="addCourseModal">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5>Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" name="course_code" class="form-control mb-2" placeholder="Course Code" required>
                <input type="text" name="course_name" class="form-control" placeholder="Course Name" required>
            </div>

            <div class="modal-footer">
                <button type="submit" name="add_course" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<?php
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)):
?>

<!-- EDIT COURSE MODAL -->
<div class="modal fade" id="editCourseModal<?= $row['id'] ?>">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5>Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="text" name="course_code" class="form-control mb-2"
                       value="<?= $row['course_code'] ?>" required>
                <input type="text" name="course_name" class="form-control"
                       value="<?= $row['course_name'] ?>" required>
            </div>

            <div class="modal-footer">
                <button type="submit" name="update_course" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>

<?php endwhile; ?>
