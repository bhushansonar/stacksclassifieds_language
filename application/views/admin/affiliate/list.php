<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo ucfirst('Affiliate'); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst('Affiliate'); ?>
            <a  href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
    </div>
    <?php
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new affiliate created with success.';
            echo '</div>';

            $this->session->set_userdata('flash_message', '');
            //echo $this->session->flashdata('flash_message');
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> affiliate updated with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> affiliate deleted with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    ?>
    <div class="row">
        <div class="span12 columns">
            <div class="well">

                <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');

//save the columns names in a array that we will use as filter         
                $options_affiliate = array();
                foreach ($affiliate as $array) {
                    foreach ($array as $key => $value) {
                        $options_affiliate[$key] = $key;
                    }
                    break;
                }

                echo form_open('admin/affiliate', $attributes);

                echo form_label('Search:', 'search_string');
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'register_price') ? 'selected="selected"' : "" ?> value="register_price">Affiliate Register Price</option>
                    <option <?php echo ($order == 'posted_ad_price') ? 'selected="selected"' : "" ?> value="posted_ad_price">Affiliate Posted Ads Price</option>
                    <option <?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>
                </select>
                <?php
                echo form_input('search_string', $search_string_selected);

                echo form_label('Order by:', 'order');
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/affiliate/") . '">Reset</a>';
                }
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">User Id</th>
                        <th class="yellow header headerSortDown">Affiliate Number</th>
                        <th class="yellow header headerSortDown">Name</th>
                        <th class="yellow header headerSortDown">Email</th>
<!--                        <th class="yellow header headerSortDown">Affiliation Register Price</th>
                        <th class="yellow header headerSortDown">Affiliation Posted Ads Price</th>-->
<!--                        <th class="yellow header headerSortDown">Status</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $key => $row) { ?>
                        <tr>
                            <td><?php echo $row['user_id']; ?>
                            <td><?php echo $row['affiliate_number']; ?>
                            <td><?php echo $row['username']; ?>
                            <td><?php echo $row['primary_email']; ?>
    <!--                            <td><?php echo $key + 1 ?></td>-->
    <!--                            <td> <?php echo $row['register_price'] ?></td>
             <td><?php echo $row['posted_ad_price'] ?></td>
             <td><?php echo $row['status']; ?></td>-->
                            <td class="crud-actions">
                                <a  href="<?php echo site_url("admin"); ?>/affiliate/update/<?php echo $row['user_id']; ?>" class="btn btn-info">view & edit</a>
                                <a href="<?php echo site_url("admin") ?>/affiliate/delete/<?php echo $row['user_id']; ?>" class="btn btn-danger complexConfirm">delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>