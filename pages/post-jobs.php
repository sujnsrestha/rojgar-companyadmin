<?php
$db = Database::Instance();
$jobCategory = $db->SelectAll('tbl_job_categories');


if (!empty($_POST)) {
    $data['company_name'] = $_POST['company_name'];
    $data['address'] = $_POST['address'];
    $data['contact_number'] = $_POST['contact_number'];
    $data['email'] = $_POST['email'];
    $data['position'] = $_POST['position'];
    $data['qualification'] = $_POST['qualification'];
    $data['experience'] = $_POST['experience'];
    $data['gender'] = md5($_POST['gender']);
    $data['description'] = $_POST['description'];
    $data['post_date'] = $_POST['post_date'];
    $data['exip_date'] = $_POST['exip_date'];
    $companyId = $_SESSION['company_id'];
    $jobType = $_POST['job_type'];

    // check payment status

    $getPaymentResult = $db->Select("SELECT tbl_payments.*,tbl_job_categories.category_name,tbl_companies.* FROM tbl_payments
LEFT JOIN tbl_manage_payment on tbl_payments.id=tbl_payments.id
LEFT JOIN tbl_job_categories on tbl_manage_payment.category_id=tbl_job_categories.id
LEFT JOIN tbl_companies ON tbl_manage_payment.company_id=tbl_companies.id
WHERE tbl_companies.id='$companyId' and tbl_job_categories.id='$jobType'");

    if (count($getPaymentResult) <= 0) {
        $_SESSION['company_payment_id'] = $companyId;
        $_SESSION['category_payment_id'] = $jobType;
        redirect_to('@company-admin/payment');
    }

//=========company logo========
    $target_dir = page_path('public/images/company/');
    $imageFileType = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);

    $imageName = md5(microtime()) . '.' . $imageFileType;
    $tpmName = $_FILES['company_logo']['tmp_name'];

    if (move_uploaded_file($tpmName, $target_dir . $imageName)) {
        $data['company_logo'] = $imageName;
    }

    //=========document logo========
    $target_dir = page_path('public/images/document/');
    $imageFileType = pathinfo($_FILES['documents']['name'], PATHINFO_EXTENSION);

    $docName = md5(microtime()) . '.' . $imageFileType;
    $tpmName = $_FILES['documents']['tmp_name'];

    if (move_uploaded_file($tpmName, $target_dir . $docName)) {
        $data['documents'] = $docName;
    }


    if ($lastInsertId = $db->Insert('tbl_job_post', $data)) {
        if ($lastInsertId) {
            $dbs = Database::Instance();
            $cmpType['company_id'] = $companyId;
            $cmpType['job_category_id'] = $jobType;
            $cmpType['job_post_id'] = $lastInsertId;
            $dbs->Insert('tbl_manage_job_post', $cmpType);
        }

        $_SESSION['success'] = 'data was successfully inserted';
        redirect_to('@company-admin/show-post-jobs');

    }
}


?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1>Post Jobs</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Messages(); ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" name="company_name" value="" id="company_name"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Company Address</label>
                            <input type="text" name="address" id="address"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" name="email" id="email"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position">Position
                            </label>
                            <input type="text" name="position"
                                   id="position"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qualification">qualification</label>
                            <input type="text" name="qualification"
                                   id="qualification"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="experience">experience</label>
                            <input type="text" name="experience"
                                   id="experience"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job-type">Job types</label>
                            <select name="job_type" id="job-type"
                                    class="form-control">
                                <?php foreach ($jobCategory as $jobCat) : ?>
                                    <option value="<?= $jobCat->id ?>"><?= $jobCat->category_name ?></option>

                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="openings">openings</label>
                            <input type="text" name="openings"
                                   id="openings"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_logo">Company logo</label>
                            <input type="file" name="company_logo"
                                   id="company_logo"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="documents"> Documents</label>
                            <input type="file" name="documents"
                                   id="documents"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        Post Date
                        <div class="form-group">
                            <div class="input-group date" id="myDatepicker">
                                <input type="text" name="post_date" class="form-control">
                                <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                             </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        Date expire
                        <div class="form-group">
                            <div class="input-group date" id="myDatepicker1">
                                <input type="text" name="exip_date" class="form-control">
                                <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">gender</label>
                            <input type="radio" name="gender" value="male"> Male
                            <input type="radio" name="gender" value="female"> Female
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control"
                                      name="description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary">Post Job</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /page content -->

