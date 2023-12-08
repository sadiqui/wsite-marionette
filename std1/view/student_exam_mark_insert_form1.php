<?php
if (!isset($_SERVER['HTTP_REFERER']) || empty($_GET['grade']) || empty($_GET['exam']) || empty($_GET['std_index'])) {
    // Redirect them to your desired location
    header('location: ../index.php');
    exit;
}
?>
<div class="modal msk-fade" id="inserteMark" tabindex="-1" role="dialog" aria-labelledby="modalInsertform" aria-hidden="true">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="container msk-modal-content">
            <!--modal-content -->
            <div class="row ">
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                            <h3 class="panel-title">Add Exam Marks</h3>
                        </div>
                        <form role="form" action="../index.php" method="post" id="formExam">
                            <div class="panel-body">
                                <!-- Start of modal body -->
                                <div class="form-group" id="divExamSubject">
                                    <table id="table_student_exam" class="table">
                                        <thead>
                                            <th class="col-md-2">Subject</th>
                                            <th class="col-md-1">Marks</th>
                                        </thead>
                                        <tbody class="tBody">
                                            <?php
                                            include_once('../controller/config.php');

                                            // Validate and sanitize input parameters
                                            $grade_id = mysqli_real_escape_string($conn, $_GET['grade']);
                                            $exam_id = mysqli_real_escape_string($conn, $_GET['exam']);
                                            $std_index = mysqli_real_escape_string($conn, $_GET['std_index']);
                                            $current_year = date('Y');
                                            $count = 0;

                                            $sql = "SELECT subject.id as s_id, subject.name as s_name
                                                    FROM student_subject
                                                    INNER JOIN subject_routing ON student_subject.sr_id=subject_routing.id
                                                    INNER JOIN subject ON subject_routing.subject_id=subject.id
                                                    WHERE student_subject.index_number='$std_index'
                                                    AND student_subject.year='$current_year'
                                                    AND student_subject._status=''
                                                    AND subject_routing.grade_id='$grade_id'";

                                            $result = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $count++;
                                            ?>
                                                <tr id="tr_<?php echo $count; ?>">
                                                    <input type="hidden" name="subject_id[]" id="eSubject_id_<?php echo $count; ?>" value="<?php echo htmlspecialchars($row['s_id']); ?>">
                                                    <input type="hidden" name="grade" value="<?php echo htmlspecialchars($grade_id); ?>"/>
                                                    <input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($exam_id); ?>"/>
                                                    <td id="eSubject_td_<?php echo $count; ?>"><?php echo htmlspecialchars($row['s_name']); ?></td>
                                                    <td id="eMark_td_<?php echo $count; ?>"><input type="text" name="exam_mark[]" id="exam_mark_<?php echo $count; ?>"></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.modal body-->
                            <div class="panel-footer bg-blue-active">
                                <input type="hidden" name="std_index" value="<?php echo htmlspecialchars($std_index); ?>"/>
                                <input type="hidden" name="do" value="add_student_exam_mark1"/>
                                <button type="submit" class="btn btn-info btnS" id="btnSubmit3" style="width:100%;">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!--/.panel-->
                </div>
                <!--/.col-md-3 -->
            </div>
            <!--/.row-->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--/.modal-modalInsertform -->