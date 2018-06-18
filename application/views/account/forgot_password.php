<h2>Password reset</h2>
<?php echo validation_errors("<p class=\"text-danger\">","</p>");?>
<?php if (isset($success)) { echo '<p class="text-success">Your password has been reset successfully, please check your inbox</p>';}?>
<?php echo form_open('account/reset_pass',array('id' => 'passResetForm'))?>
    <?php
        echo form_label("Username/e-mail address","login");
        echo form_input("login",set_value("login"), array("maxlength"=>"512","class"=>"form-control"));?>
        <br>
    <input type="submit" class="btn btn-success" value="Reset password"/>
</form>
<script type="text/javascript">
$(document).ready(function() {
 $('#passResetForm').validate({
  errorPlacement: function(label, element) {
      label.addClass('text-danger');
      label.insertAfter(element);
  },
  rules: {
    login: {
        maxlength: 512,
        required: true
    }
  },
  messages: {
    login: {
        required: "The username/e-mail address field is required",
        maxlength: "The username/e-mail address field can't contain more than 512 characters"
    }
  }
});}) // end document.ready
</script>