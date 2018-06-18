<h2>Login</h2>
<?php if ($this->session->flashdata('newAccountSuccess') != null) { echo '<p class="text-success">Registration successful!</p>';}?>
<?php echo validation_errors("<p class=\"text-danger\">","</p>");?>
<?php echo form_open('account/login',array('id' => 'loginForm'))?>
    <?php
        echo form_label("Username/E-mail address","login");
        echo form_input("login",set_value("login"), array("maxlength"=>"512","class"=>"form-control"));?>
        <br>
     <?php
        echo form_label("Password","password");
        echo form_password("password",null,array("maxlength"=>"100","class"=>"form-control")); ?>
        <br>
    <input type="submit" class="btn btn-success" value="Login"/> <a href="<?php echo site_url('account/reset_pass');?>" class="btn btn-danger" role="button">Reset password</a>
</form>
<script type="text/javascript">
$(document).ready(function() {
 $('#loginForm').validate({
  errorPlacement: function(label, element) {
      label.addClass('text-danger');
      label.insertAfter(element);
  },
  rules: {
    login: {
        maxlength: 512,
        required: true
    },
   password: {
       required: true,
       maxlength: 100
   }
  },
  messages: {
    login: {
        required: "The username/e-mail address field is required",
        maxlength: "The username/e-mail address field can't contain more than 512 characters"
    },
    password:
    {
        required: "Password is required",
        maxlength: "The password input can't contain more than 100 characters"
    }
  }
});}) // end document.ready
</script>