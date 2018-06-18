<h2>Change password</h2>
<?php echo validation_errors("<p class=\"text-danger\">","</p>");?>
<?php if (isset($success)) { echo '<p class="text-success">Password was changed successfully</p>';}?>
<?php echo form_open('account/change_pass',array('id' => 'passwordChangeForm'))?>
    <?php
        echo form_label("Current password","currentPass");
        echo form_password("currentPass",null,array("maxlength"=>"100","class"=>"form-control")); ?>
        <br>
     <?php
        echo form_label("New password","newPass");
        echo form_password("newPass",null,array("maxlength"=>"100","class"=>"form-control")); ?>
        <br>
    <input type="submit" class="btn btn-success" value="Change password"/>
</form>
<script type="text/javascript">
$(document).ready(function() {
 $('#passwordChangeForm').validate({
  rules: {
    currentPass: {
        required: true,
        maxlength: 100
    },
    newPass: {
       required: true,
       maxlength: 100
   }
  },
  messages: {
    currentPass: {
        required: "Current password is required",
        maxlength: "Current password can't contain more than 100 characters"
    },
    newPass:
    {
        required: "New password is required",
        maxlength: "New password can't contain more than 100 characters"
    }
  }
});}) // end document.ready
</script>