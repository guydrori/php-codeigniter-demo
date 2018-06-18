<h2>Edit product</h2>
<?php echo validation_errors("<p class=\"text-danger\">","</p>");?>
<?php echo form_open('products/edit_post',array('id' => 'editProductForm'),array("productId"=>$product["ID"]))?>
    <?php
        echo form_label("Name","name");
        echo form_input("name",$product["Name"], array("maxlength"=>"255","class"=>"form-control"));?>
        <br>
    <?php
        echo form_label("Description","description");
        echo form_textarea("description",$product["Description"], array("maxlength"=>"2048","class"=>"form-control"));?>
        <br>
    <input type="submit" class="btn btn-success" value="Edit product"/> <a href="javascript:history.back()" class="btn btn-warning" role="button">Back</a>
</form>
<script type="text/javascript">
$(document).ready(function() {
 $('#editProductForm').validate({
  errorPlacement: function(label, element) {
      label.addClass('text-danger');
      label.insertAfter(element);
  },
  rules: {
    name: {
        maxlength: 255,
        required: true
    },
    description: {
        maxlength: 2048,
        required: false
    }
  },
  messages: {
    name: {
        required: "Name is required",
        maxlength: "Name can't contain more than 255 characters"
    },
    description: {
        maxlength: "Description can't contain more than 2048 characters!"
    }
  }
});}) // end document.ready
</script>