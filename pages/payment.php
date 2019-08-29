<?php
$db = Database::Instance();

$companyId = $_SESSION['company_payment_id'];
$categoryId = $_SESSION['category_payment_id'];
$comData = $db->SelectByCriteria('tbl_companies', '', 'id=?', array($companyId));
$jboCatData = $db->SelectByCriteria('tbl_job_categories', '', 'id=?', array($categoryId));

if (isset($_POST['pay-amount']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data['amount'] = $_POST['amount'];
    $data['payment_date'] = date('Y-m-d');
    $lastInsertId = $db->Insert('tbl_payments', $data);

    if ($lastInsertId) {
        $addData['payment_id'] = $lastInsertId;
        $addData['category_id'] = $categoryId;
        $addData['company_id'] = $companyId;
        $result = $db->Insert('tbl_manage_payment', $addData);

        if ($result == true) {
            $_SESSION['success'] = "Payment was successfully add";
            redirect_to('@company-admin/post-jobs');

        }


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
                            <input type="text" name="company_name" value="<?= $comData->company_name ?>" readonly
                                   id="company_name"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job-type">Job types</label>
                            <input type="text" name="job_data" readonly value="<?= $jboCatData->category_name ?>"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button name="pay-amount" class="btn btn-primary">Payment</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /page content -->
