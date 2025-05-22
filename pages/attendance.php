<div class="page-title mb-3">Manage Attendance</div>
<hr>
<style>
    .page-title {
        color: #007BFF;
        font-size: 24px;
        text-align: center;
        font-family: Arial, sans-serif;
        margin: 20px 0;
        text-transform: uppercase;
        background: linear-gradient(to right, #007BFF, #00BFFF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    hr {
        border: 1px solid #000;
    }
</style>

<?php 
$classList = $actionClass->list_class();
$class_id = $_GET['class_id'] ?? "";
$class_date = $_GET['class_date'] ?? "";
$studentList = $actionClass->attendanceStudents($class_id, $class_date);
?>

<form action="" id="manage-attendance">
    <div style="margin: 10px 0;">
        <form id="import-form" enctype="multipart/form-data">
            <input type="file" name="attendance_file" accept=".xls,.xlsx" class="form-control" required>
            <button type="button" id="import-attendance" class="btn btn-primary">Import Excel</button>
        </form>
    </div>
    <div style="margin: 10px 0;">
        <button type="button" onclick="printAttendance()" class="btn btn-secondary">Print Attendance</button>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div id="msg"></div>
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="class_id" class="form-label">Class</label>
                                <select name="class_id" id="class_id" class="form-select" required>
                                    <option value="" disabled <?= empty($class_id) ? "selected" : "" ?>> -- Select Here -- </option>
                                    <?php foreach($classList as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= $class_id == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="class_date" class="form-label">Date</label>
                                <input type="date" name="class_date" id="class_date" class="form-control" value="<?= $class_date ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($class_id) && !empty($class_date)): ?>
                <div class="card shadow mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Attendance Sheet</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="attendance-tbl" class="table table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-center">Student Name</th>
                                        <th class="text-center">Present</th>
                                        <th class="text-center">Late</th>
                                        <th class="text-center">Absent</th>
                                        <th class="text-center">Holiday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($studentList as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $row['id'] ?>]" value="1"></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $row['id'] ?>]" value="2"></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $row['id'] ?>]" value="3"></td>
                                            <td class="text-center"><input type="radio" name="status[<?= $row['id'] ?>]" value="4"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success">Save Attendance</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Change class or date reloads attendance table
        $('#class_id, #class_date').change(function() {
            var class_id = $('#class_id').val();
            var class_date = $('#class_date').val();
            location.replace(`./?page=attendance&class_id=${class_id}&class_date=${class_date}`);
        });

        // Save Attendance
        $('#manage-attendance').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: './ajax-api.php?action=save_attendance',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Attendance saved successfully!');
                        location.reload();
                    } else {
                        alert('Failed to save attendance: ' + response.msg);
                    }
                },
                error: function() {
                    alert('An error occurred while saving attendance.');
                }
            });
        });

        // Import Attendance
        $('#import-attendance').click(function() {
            var formData = new FormData($('#import-form')[0]);
            $.ajax({
                url: './ajax-api.php?action=import_attendance',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Attendance imported successfully!');
                        location.reload();
                    } else {
                        alert('Failed to import attendance: ' + response.msg);
                    }
                },
                error: function() {
                    alert('An error occurred while importing attendance.');
                }
            });
        });

        // Print Attendance
        window.printAttendance = function() {
            var divToPrint = document.getElementById('attendance-tbl');
            var newWin = window.open('', '_blank');
            newWin.document.write('<html><head><title>Attendance</title></head><body>');
            newWin.document.write('<h2>Attendance Sheet</h2>');
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.print();
        };
    });
</script>
