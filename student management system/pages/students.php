<?php
include "pages/config/studentsdb.php";

/* ================= SEARCH STUDENT ================= */
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM student";

if ($search !== '') {
    $search = mysqli_real_escape_string($conn, $search);
    $sql .= " WHERE 
            id = '$search'
            OR CONCAT('NISU-', LPAD(id, 4, '0')) LIKE '%$search%'
            OR name LIKE '%$search%'
            OR course LIKE '%$search%'
            OR major LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);

/* ================= ADD STUDENT ================= */
if (isset($_POST['add_student'])) {
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $major  = mysqli_real_escape_string($conn, $_POST['major']);

    mysqli_query(
        $conn,
        "INSERT INTO student (name, course, major) 
         VALUES ('$name', '$course', '$major')"
    );
    header("Location: ?page=students&success=1");
    exit();
}

/* ================= UPDATE STUDENT ================= */
if (isset($_POST['update_student'])) {
    $id     = mysqli_real_escape_string($conn, $_POST['id']);
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $major  = mysqli_real_escape_string($conn, $_POST['major']);

    mysqli_query(
        $conn,
        "UPDATE student 
         SET name='$name', course='$course', major='$major'
         WHERE id='$id'"
    );

    header("Location: ?page=students&updated=1");
    exit();
}

/* ================= DELETE STUDENT ================= */
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM student WHERE id='$id'");
    header("Location: ?page=students&deleted=1");
    exit();
}

/* SQL SELECT QUERY FROM STUDENTS */
$allStudents = mysqli_query($conn, "SELECT * FROM student");
?>

<!-- ================= ALERTS ================= -->
<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">Added successfully</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
<div class="alert alert-warning">Updated successfully</div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-danger">Deleted successfully</div>
<?php endif; ?>

<h4>Students</h4>
<p class="text-muted mb-4">Admin: <?= $_SESSION['username']; ?></p>

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex w-50" method="GET">
            <input type="hidden" name="page" value="students">
            <input class="form-control me-2" type="search" name="search"
                   value="<?= htmlspecialchars($search) ?>"
                   placeholder="Search ID, Name, Course, Major">
            <button class="btn btn-outline-primary">Search</button>
        </form>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="bi bi-plus-circle"></i> Add Student
        </button>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
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
                        <td class="text-center">
                            NISU-<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['course']) ?></td>
                        <td><?= htmlspecialchars($row['major']) ?></td>
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
                        <td colspan="5" class="text-center text-muted">
                            No students found
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD STUDENT MODAL ================= -->
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

<!-- ================= EDIT MODALS ================= -->
<?php while ($row = mysqli_fetch_assoc($allStudents)): ?>
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
                       value="<?= htmlspecialchars($row['name']) ?>" required>
                <input type="text" name="course" class="form-control mb-2"
                       value="<?= htmlspecialchars($row['course']) ?>" required>
                <input type="text" name="major" class="form-control"
                       value="<?= htmlspecialchars($row['major']) ?>" required>
            </div>

            <div class="modal-footer">
                <button type="submit" name="update_student" class="btn btn-warning">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
<?php endwhile; ?>
