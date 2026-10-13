<?php
require_once "db.php";

$search = trim($_GET["search"] ?? "");
$semester = $_GET["semester"] ?? "";

$sql = "SELECT student_id, name, email, user_id, semester
        FROM students
        WHERE 1=1";

$params = [];
$types = "";

if ($search !== "") {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR user_id LIKE ?)";
    $keyword = "%" . $search . "%";

    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;

    $types .= "sss";
}

if ($semester !== "" && ctype_digit($semester)) {
    $sql .= " AND semester = ?";
    $params[] = (int)$semester;
    $types .= "i";
}

$sql .= " ORDER BY student_id DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$message = $_GET["message"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management | Practical 11</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container wide">

    <h1>Student Management</h1>
    <p class="subtitle">Manage student records efficiently.</p>

    <?php if ($message !== "") { ?>
        <p class="message">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php } ?>

    <a href="add.php" class="btn">+ Add Student</a>

    <form method="GET" action="index.php" class="search-form">

        <input
            type="text"
            name="search"
            placeholder="Search name, email or enrollment number"
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <select name="semester">
            <option value="">All Semesters</option>
            <?php for ($i = 1; $i <= 8; $i++) { ?>
                <option value="<?php echo $i; ?>"
                    <?php echo ($semester === (string)$i) ? "selected" : ""; ?>>
                    Semester <?php echo $i; ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Search / Filter</button>
        <a href="index.php" class="btn secondary">Reset</a>

    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Enrollment Number</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo (int)$row["student_id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["user_id"]); ?></td>
                        <td><?php echo (int)$row["semester"]; ?></td>
                        <td class="actions">
                            <a class="btn small"
                               href="edit.php?id=<?php echo (int)$row["student_id"]; ?>">
                                Edit
                            </a>

                            <form action="delete.php" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this student?');">
                                <input type="hidden" name="student_id"
                                       value="<?php echo (int)$row["student_id"]; ?>">
                                <button type="submit" class="btn small danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">No student records found.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <p class="record-count">
        Total matching records: <?php echo $result->num_rows; ?>
    </p>

</div>

</body>
</html>
