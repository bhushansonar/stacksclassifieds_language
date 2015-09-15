<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?>
            <a  href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
    </div>
    <?php
    echo validation_errors();
    //echo $this->session->flashdata('flash_message');
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new posts created with success.';
            echo '</div>';

            $this->session->set_userdata('flash_message', '');
            //echo $this->session->flashdata('flash_message');
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> posts updated with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> posts deleted with success.';
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
                $options_posts = array();
                foreach ($posts as $array) {
                    foreach ($array as $key => $value) {
                        $options_posts[$key] = $key;
                    }
                    break;
                }

                echo form_open('admin/posts', $attributes);

                echo form_label('Search:', 'search_string');
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'country.country_name') ? 'selected="selected"' : "" ?> value="country.country_name">Country</option>
                    <option <?php echo ($order == 'state.state_name') ? 'selected="selected"' : "" ?> value="state.state_name">State</option>
                    <option <?php echo ($order == 'city.city_name') ? 'selected="selected"' : "" ?> value="city.city_name">City</option>
                    <option <?php echo ($order == 'email') ? 'selected="selected"' : "" ?> value="email">Email</option>
                    <option <?php echo ($order == 'posts.status') ? 'selected="selected"' : "" ?> value="posts.status">Status</option>
                </select>
                <?php
                echo form_input('search_string', $search_string_selected);

                echo form_label('Order by:', 'order');
//echo form_dropdown('order', $options_posts, $order, 'class="span2"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/posts/") . '">Reset</a>';
                }
                echo form_close();
                ?>

            </div>

            <table style="table-layout: fixed;width: 100%;" class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="width: 6%;" class="header">#</th>
                        <th class="yellow header headerSortDown">Country Name</th>
                        <th class="yellow header headerSortDown">States</th>
                        <th class="yellow header headerSortDown">City</th>
                        <th class="yellow header headerSortDown">Title</th>
                        <th style=" width: 22%;" class="yellow header headerSortDown">Email</th>
                        <th class="yellow header headerSortDown">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($posts as $key => $row) {
                        $index = $key + 1;
                        echo '<tr>';
                        echo '<td>' . $index . '</td>';
                        echo '<td>' . $row['g_country_name'] . '</td>';
                        echo '<td>' . $row['g_state_name'] . '</td>';
                        echo '<td>' . $row['g_city_name'] . '</td>';
                        echo '<td style="word-wrap: break-word;">' . unserialize(base64_decode($row['title'])) . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td class="crud-actions">
                  <a  href="' . site_url("admin") . '/posts/update/' . $row['posts_id'] . '" class="btn btn-info">view & edit</a>
                  <a href="' . site_url("admin") . '/posts/delete/' . $row['posts_id'] . '" class="btn btn-danger complexConfirm">delete</a>
                </td>';
                        echo '</tr>';
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