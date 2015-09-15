<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo ucfirst('Featured Price'); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Featured Price
            <a  href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
    </div>
    <?php
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new Featured price created with success.';
            echo '</div>';

            $this->session->set_userdata('flash_message', '');
            //echo $this->session->flashdata('flash_message');
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Featured price updated with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Featured price deleted with success.';
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
            <!--            <div class="well">

            <?php
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');

            //save the columns names in a array that we will use as filter
            $options_city = array();
            foreach ($city as $array) {
                foreach ($array as $key => $value) {
                    $options_city[$key] = $key;
                }
                break;
            }

            echo form_open('admin/featured_price', $attributes);

            echo form_label('Search:', 'search_string');
            ?>
                            <select name="order" class="span2">
                                <option <?php echo ($order == 'city_name') ? 'selected="selected"' : "" ?> value="city_name">City Name</option>
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
                echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/featured_price/") . '">Reset</a>';
            }
            echo form_close();
            ?>

                        </div>-->

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">City Name</th>
                        <th class="yellow header headerSortDown">Category</th>
<!--                        <th class="yellow header headerSortDown">Price</th>-->
                        <th class="yellow header headerSortDown">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ci = & get_instance();
                    $ci->load->model('common_model');
                    foreach ($city as $key => $row) {
                        $featured_price_after_decode = json_decode($row['featured_week_price']);

                        $category_id = $row['category_id'];
                        $city_id = $row['city_id'];
                        $where_city_id = " AND city_id={$city_id}";
                        $city_name = $ci->common_model->getFieldData('city', 'city_name', $where_city_id);
                        $where_category_id = " AND category_id={$category_id}";
                        $category_name = $ci->common_model->getFieldData('category', 'category_name_en', $where_category_id);
                        ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $city_name; ?> </td>
                            <td><?php echo $category_name; ?></td>
    <!--                            <td>-->
                            <?php
//                                echo "<pre>";
//                                foreach ($featured_price_after_decode as $key => $value) {
//                                    //print_r($value);
//                                    foreach ($value as $key => $value1) {
//                                        if ($key % 2) {
//                                            $brek = "<br>";
//                                        } else {
//                                            $brek = "";
//                                        }
//                                        echo $key . ' week => ' . $value1 . ',' . $brek;
//                                    }
//                                }
//                                echo "</pre>";
                            //echo $row['featured_week_price'];
                            ?>
                            <!--                            </td>-->
                            <td><?php echo $row['status']; ?></td>
                            <td class = "crud-actions">
                                <a href = " <?php echo site_url("admin") ?>/featured_price/update/<?php echo $row['featured_price_id'] ?>" class = "btn btn-info">view & edit</a>
                                <a href = "<?php echo site_url("admin") ?>/featured_price/delete/<?php echo $row['featured_price_id'] ?>" class = "btn btn-danger complexConfirm">delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>