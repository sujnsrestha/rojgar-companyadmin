<?php

$db = Database::Instance();

$criteria = $_SESSION['company_id'];

$findCompanyData = $db->SelectByCriteria(
    'tbl_companies', '',
    'id=?', array($criteria));


if (isset($_POST['update-company-action'])) {
    $criteria = $_POST['criteria'];
    $data['company_name'] = $_POST['company_name'];
    $data['company_address'] = $_POST['company_address'];
    $data['company_contact'] = $_POST['company_contact'];
    $data['company_optional_contact_number'] = $_POST['company_optional_contact_number'];
    $data['company_email'] = $_POST['company_email'];
    $data['company_username'] = $_POST['company_username'];
    $data['company_website'] = $_POST['company_website'];

    if (!empty($_FILES['company_logo']['name'])) {
        $findData = $db->SelectByCriteria('tbl_companies', '', 'id=?', array($criteria));
        $findFileName = $findData->company_logo;
        $removePath = page_path('public/images/company/' . $findFileName);
        if (file_exists($removePath) && is_file($removePath)) {
            unlink($removePath);
        }

        $target_dir = page_path('public/images/company/');
        $imageFileType = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);

        $imageName = md5(microtime()) . '.' . $imageFileType;
        $tpmName = $_FILES['company_logo']['tmp_name'];

        if (move_uploaded_file($tpmName, $target_dir . $imageName)) {
            $data['company_logo'] = $imageName;
        }

    }


    if ($db->Update('tbl_companies', $data, 'id=?', array($criteria))) {
        $_SESSION['success'] = 'data was successfully updated';
        redirect_to('@company-admin/company-setting');

    }

}


?>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
            <?= Messages(); ?>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-10">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="criteria" value="<?= $findCompanyData->id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" name="company_name"
                                       value="<?= $findCompanyData->company_name ?>"
                                       id="company_name"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_address">Company Address</label>
                                <input type="text" name="company_address"
                                       value="<?= $findCompanyData->company_address ?>"
                                       id="company_address"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_contact">Contact Number</label>
                                <input type="text" name="company_contact"
                                       value="<?= $findCompanyData->company_contact ?>"
                                       id="company_contact"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_optional_contact_number">Optional Contact
                                    Number</label>
                                <input type="text" name="company_optional_contact_number"
                                       value="<?= $findCompanyData->company_optional_contact_number ?>"
                                       id="company_optional_contact_number"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_email">Email</label>
                                <input type="text"
                                       value="<?= $findCompanyData->company_email ?>"
                                       name="company_email"
                                       id="company_email"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_username">User name</label>
                                <input type="text"
                                       value="<?= $findCompanyData->company_username ?>"
                                       name="company_username"
                                       id="company_username"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_website">Website</label>
                                <input type="text"
                                       value="<?= $findCompanyData->company_website ?>"
                                       name="company_website"
                                       id="company_website"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="change_image">Company logo</label>
                                <input type="file" name="company_logo"
                                       id="change_image"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button name="update-company-action" class="btn btn-primary">
                                    Update Company
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-2">
                <img src="<?= URL('public/images/company/' . $findCompanyData->company_logo) ?>" id="target_image"
                     alt="image not select"
                     class="img-responsive thumbnail" style="margin-top: 23px">
            </div>

        </div>
    </div>
</div>