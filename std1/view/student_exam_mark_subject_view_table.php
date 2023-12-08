<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirection
    header('location:../index.php');
    exit;
}
?>
<table id="table_student_exam" class="table">
    <thead>
        <th>Subject</th>
        <th>Marks</th>
        <th>Action</th>
    </thead>
    <tbody class="tBody">
        <?php

include_once('../controller/config.php');

// Validate and sanitize input parameters
$index_number = isset($_GET['index']) ? mysqli_real_escape_string($conn, $_GET['index']) : '';
$exam = isset($_GET['exam']) ? mysqli_real_escape_string($conn, $_GET['exam']) : '';
$current_year = date('Y');

// Validate $index_number and $exam as needed

// Query to fetch student grade information
$sql = "SELECT * FROM student_grade WHERE index_number='$index_number' AND year='$current_year'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("No matching record found for the provided parameters.");
}

$grade_id = $row['grade_id'];

// Query to fetch subject information
$sql1 = "SELECT subject.name AS s_name, student_exam.id AS ex_id, student_exam.marks AS ex_mark
         FROM student_exam 
         INNER JOIN subject ON student_exam.subject_id = subject.id
         WHERE student_exam.index_number='$index_number' AND student_exam.exam_id='$exam' AND student_exam.year='$current_year'";

$result1 = mysqli_query($conn, $sql1);

if (!$result1) {
    die("Error in query: " . mysqli_error($conn));
}

$count = 0;

while ($row1 = mysqli_fetch_assoc($result1)) {
    $count++;
?>
    <tr id="tr_<?php echo $count; ?>">
        <input type="hidden" name="subject_id[]" id="eSubject_id_<?php echo $count; ?>"
            value="<?php echo htmlspecialchars($row1['s_id']); ?>">
        <input type="hidden" name="grade" value="<?php echo htmlspecialchars($grade_id); ?>" />
        <td id="eSubject_td_<?php echo $count; ?>"><?php echo htmlspecialchars($row1['s_name']); ?></td>
        <td id="eMark_td_<?php echo $count; ?>"><?php echo htmlspecialchars($row1['ex_mark']); ?></td>
        <td id="action_<?php echo $count; ?>">
            <a href="#" id="edit_exam_mark_<?php echo $count; ?>"
                onClick="editExamMark('<?php echo htmlspecialchars($row1['ex_id']); ?>','<?php echo $count; ?>')"
                data-id="<?php echo htmlspecialchars($row['id']) . ',' . $count; ?>" class="label-warning "><span
                    class="glyphicon glyphicon-edit "></span></a><!-- MSK-00094-->
        </td>
    </tr>

<?php
}

// Close the database connection when done
mysqli_close($conn);
?>

    </tbody>
</table>