<?php
$db = Database::Instance();

$criteria = $_SESSION['company_id'];

$applyData = $db->Select("SELECT tbl_job_apply.*,tbl_job_seekers.*,tbl_job_categories.category_name,tbl_companies.company_name as cmp_name FROM tbl_job_apply
LEFT JOIN tbl_manage_job_apply ON tbl_job_apply.id=tbl_manage_job_apply.apply_id
LEFT JOIN tbl_job_seekers on tbl_job_seekers.id=tbl_manage_job_apply.seeker_id
LEFT JOIN tbl_job_categories ON tbl_job_categories.id=tbl_manage_job_apply.category_id
LEFT JOIN tbl_companies ON tbl_companies.id=tbl_manage_job_apply.company_id
WHERE tbl_manage_job_apply.company_id='$criteria'
");

?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>

        </div>
    </div>
    <div class="row">
        <?= Messages(); ?>
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th>S.n</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>

                </tr>
                <?php foreach ($applyData as $key => $jobs): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $jobs->fist_name. ' '.$jobs->middle_name. ' '.$jobs->last_name ?></td>
                        <th><?=$jobs->email?></th>
                        <th><?=$jobs->mobile_number?></th>
                        <td>
                            <a href="<?=URL('@company-admin/view_details_apply?criteria='.$jobs->id)?>"
                               class="btn btn-primary btn-xs">View Details</a>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </div>
    </div>
</div>