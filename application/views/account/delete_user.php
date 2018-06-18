<h2>Administrator accounts</h2>
<h3 class="error-text">Are you sure you would like to delete this account?</h3>
<br/>
<table class= "text-center table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>E-mail address</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td><?php echo $user["Username"];?></td>
            <td><?php echo $user["Email"];?></td>
        </tr>
    </tbody>
</table>

<?php echo form_open('account/delete_user_post',array('id' => 'deleteUserForm'),array('userId'=>$user["ID"]))?>
    <input type="submit" class="btn btn-danger" value="Delete account"/> <a href="javascript:history.back()" class="btn btn-warning" role="button">Return</a>
</form>