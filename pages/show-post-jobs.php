<?php

$db = Database::Instance();

$criteria = $_SESSION['company_id'];

$jobsData = $db->Select("SELECT tbl_job_post.*,tbl_job_categories.category_name,tbl_companies.* FROM tbl_job_post
JOIN tbl_manage_job_post on tbl_manage_job_post.job_post_id=tbl_job_post.id
JOIN tbl_job_categories ON tbl_job_categories.id=tbl_manage_job_post.job_category_id
JOIN tbl_companies ON tbl_companies.id=tbl_manage_job_post.company_id
WHERE tbl_manage_job_post.company_id='$criteria'")


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
                    <th>Company Name</th>
                    <th>Download</th>

                </tr>
                <?php foreach ($jobsData as $key => $jobs): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $jobs->company_name ?></td>
                        <td>
                            <a href="<?= URL('public/images/document/'.$jobs->documents) ?>" download>
                                <i class="fa fa-file-pdf-o"></i>Download</a>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </div>
    </div>
</div>