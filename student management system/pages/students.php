<?php
include "pages/config/studentsdb.php";

/* ADD STUDENT */
if (isset($_POST['add_student'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $major = mysqli_real_escape_string($conn, $_POST['major']);

    mysqli_query($conn, "INSERT INTO student (name, course, major) VALUES ('$name', '$course', '$major')");
    header("Location: ?page=students&success=1");
    exit();
}

/* UPDATE STUDENT */
if (isset($_POST['update_student'])) {
    $id   = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $major = mysqli_real_escape_string($conn, $_POST['major']);

    $sql = "UPDATE student SET name = '$name', course = '$course', major = '$major' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ?page=students&updated=1");
        exit();
    } else {
        echo mysqli_error($conn);
    }
}

/* DELETE STUDENT */
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM student WHERE id='$id'");
    header("Location: ?page=students&deleted=1");
    exit();
}

/* FETCH STUDENTS */
$result = mysqli_query($conn, "SELECT * FROM student");
?>

<!--- ALERTS --->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Added successfully</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-warning">Update successfully</div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-danger">Deleted successfully</div>
<?php endif; ?>

<h4>Students</h4>
<p class="text-muted mb-4">Admin: <?= $_SESSION['username']; ?></p>

<div class="container-fluid">

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="bi bi-plus-circle"></i> Add Student
        </button>
    </div>

    <!--- TABLE --->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Major</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['course'] ?></td>
                            <td><?= $row['major'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editStudentModal<?= $row['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <a href="?page=students&delete=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this student?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No students found
                            </td>
                        </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- ADD STUDENT MODAL -->
<div class="modal fade" id="addStudentModal">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5>Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                <input type="text" name="course" class="form-control mb-2" placeholder="Course" required>
                <input type="text" name="major" class="form-control" placeholder="Major" required>
            </div>

            <div class="modal-footer">
                <button type="submit" name="add_student" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<?php
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)):
?>

<!--- EDIT STUDENT MODAL --->
<div class="modal fade" id="editStudentModal<?= $row['id'] ?>">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5>Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="text" name="name" class="form-control mb-2"
                       value="<?= $row['name'] ?>" required>
                <input type="text" name="course" class="form-control mb-2"
                       value="<?= $row['course'] ?>" required>
                <input type="text" name="major" class="form-control"
                       value="<?= $row['major'] ?>" required>
            </div>

            <div class="modal-footer">
                <button type="submit" name="update_student" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>

<?php endwhile; ?>
