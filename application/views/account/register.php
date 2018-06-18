<h2>Registration</h2>
<?php echo validation_errors("<p class=\"text-danger\">","</p>");?>
<?php echo form_open('account/register',array('id' => 'regForm'))?>
    <?php
        echo form_label("Username","username");
        echo form_input("username",set_value("username"), array("maxlength"=>"255","class"=>"form-control"));?>
        <br>
     <?php
        echo form_label("Password","password");
        echo form_password("password",null,array("maxlength"=>"100","class"=>"form-control")); ?>
        <br>
     <?php
        echo form_label("E-mail address","email");
        echo form_input("email",set_value("email"),array("maxlength"=>"512","class"=>"form-control"));
    ?>
    <br>
    <input type="submit" class="btn btn-success margin-right" value="Register"/> <a href="javascript:history.back()" class="btn btn-warning" role="button">Return</a>
</form>
<script type="text/javascript">
$(document).ready(function() {
 $('#regForm').validate({
  errorPlacement: function(label, element) {
      label.addClass('text-danger');
      label.insertAfter(element);
  },
  rules: {
   username: {
    maxlength: 255,
    required: true
   },
   email: {
    required: true,
    email: true,
    maxlength: 512
   },
   password: {
       required: true,
       maxlength: 100
   }
  },
  messages: {
    username: {
        required: "Username is required",
        maxlength: "Username can't contain more than 255 characters"
    },
    email: {
        required: "E-mail address is required",
        maxlength: "E-mail address can't contain more than 512 characters",
        email: "The e-mail address must be entered in the proper format"
    },
    password:
    {
        required: "Password is required",
        maxlength: "Password can't contain more than 100 characters"
    }
  }
});}) // end document.ready
</script>