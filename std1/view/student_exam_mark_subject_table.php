<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    // Redirect them to your desired location
    header('location: ../index.php');
    exit;
}
?>
<table id="table_exam_mark" class="table">
    <thead>
        <th class="col-md-2">Subject</th>
        <th class="col-md-3">Marks</th>
    </thead>
    <tbody class="tBody">
        <?php
        include_once('../controller/config.php');

        // Validate and sanitize input parameters
        $index_number = isset($_GET['index']) ? mysqli_real_escape_string($conn, $_GET['index']) : '';
        $exam = isset($_GET['exam']) ? mysqli_real_escape_string($conn, $_GET['exam']) : '';
        $current_year = date('Y');

        // Validate $index_number and $exam as needed

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

        $sql1 = "SELECT subject.name AS s_name, subject.id AS s_id
                 FROM exam_timetable
                 INNER JOIN subject_routing ON exam_timetable.grade_id = subject_routing.grade_id AND exam_timetable.subject_id = subject_routing.subject_id
                 INNER JOIN student_subject ON student_subject.sr_id = subject_routing.id
                 INNER JOIN subject ON subject_routing.subject_id = subject.id
                 WHERE exam_timetable.grade_id='$grade_id' AND subject_routing.grade_id='$grade_id' AND student_subject.year='$current_year' AND student_subject.index_number='$index_number'";

        $result1 = mysqli_query($conn, $sql1);

        if (!$result1) {
            die("Error in query: " . mysqli_error($conn));
        }

        $count = 0;

        while ($row1 = mysqli_fetch_assoc($result1)) {
            $count++;
        ?>
            <tr id="tr_<?php echo $count; ?>">
                <input type="hidden" name="subject_id[]" id="eSubject_id_<?php echo $count; ?>" value="<?php echo htmlspecialchars($row1['s_id']); ?>">
                <input type="hidden" name="grade" value="<?php echo htmlspecialchars($grade_id); ?>"/>
                <td id="eSubject_td_<?php echo $count; ?>"><?php echo htmlspecialchars($row1['s_name']); ?></td>
                <td id="eMark_td_<?php echo $count; ?>"><input type="text" class="mark-grade form-control" id="eMark_text_<?php echo $count; ?>" name="eMark[]"  placeholder="85" autocomplete="off"/></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
