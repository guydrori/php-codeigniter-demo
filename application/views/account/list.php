<?php $i = 1;?>
<?php if ($this->session->flashdata('deleteAccountSuccess') != null) { echo '<p class="text-success">Account deleted successfully</p>';}?>
<h2>Administrator accounts</h2>
<table class="text-center table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>E-mail address</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($users as $user) { ?> 
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $user["Username"];?></td>
                <td><?php echo $user["Email"];?></td>
        <td><?php if ($user["ID"] != $currentId) { ?><button onclick="location.href='<?php echo base_url();?>account/delete_user/<?php echo $user["ID"];?>'" class="btn btn-danger margin-right">Delete</button><?php } ?></td>
            </trd>
        <?php $i++; } ?>
    </tobdy>
</table>