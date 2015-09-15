<div class="container top">
  
    <?php
    //\\print_r($this->session->userdata('flash_message'));
    //print_r($this->session->flashdata('data'));
    //flash messages

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

                echo form_open('listing', $attributes);

                ?>
               

            </div>

            <table class="table table-striped table-bordered table-condensed" style="clear: both;">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Country Name</th>
                        <th class="yellow header headerSortDown">States</th>
                        <th class="yellow header headerSortDown">City</th>
                        <th class="yellow header headerSortDown">Title</th>
                        <th class="yellow header headerSortDown">Email</th>
                        
                        <th class="yellow header headerSortDown">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($posts as $key => $row) {
					$index = $key +1 ;
                        echo '<tr>';
                        echo '<td>' . $index . '</td>';
                        echo '<td>' . $row['country_name'] . '</td>';
                        echo '<td>' . $row['state_name'] . '</td>';
                        echo '<td>' . $row['city_name'] . '</td>';
                        echo '<td>' . $row['title'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                       
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td class="crud-actions">
                  <a  href="' . site_url() . 'listing/update/' . $row['posts_id'] . '" class="btn btn-info">view & edit</a>  
                  <a href="' . site_url() . 'listing/delete/' . $row['posts_id'] . '" class="btn btn-danger complexConfirm">delete</a>
                </td>';
                        echo '</tr>';
                    }
                    ?>      
                </tbody>
            </table>

            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
			echo form_close();
            ?>

        </div>
    </div>